<?php

namespace App\Repositories\Staff;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Staff;
use App\Models\User;
use App\Repositories\Staff\StaffRepositoryInterface;
use stdClass;

class StaffEloquentORM implements StaffRepositoryInterface
{
    public function __construct(
        protected Staff $staff,
        protected User $user,
        protected Address $address,
        protected Customer $customer
    ) {
    }

    public function getAll(string $filter = null): array
    {
        $staff = $this->staff
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('id', $filter);
                }
            })
            ->with('user')
            ->with('address')
            ->first();
        
        if (!$staff) return [];
        $staff->customer = $this->customer->where('user_id', $staff->user_id)->first();

        return $staff->toArray();
    }

    public function findOne(string $id): stdClass|null|array
    {
        $staff = $this->staff->with(['address','user'])->find($id);
        if (!$staff) return null;

        $staff->customer = $this->customer->where('user_id', $staff->user_id)->first();
        
        return (object) $staff->toArray();
    }

    public function delete(string $id): void
    {
        $staff   = $this->staff->find($id)->toArray();

        if ($staff) {
            // $this->user->findOrFail($staff['user_id'])->delete();
            // $this->address->findOrFail($staff['address_id'])->delete();
            $this->staff->find($id)->delete();
            $this->customer->where('user_id', $staff['user_id'])->delete();
        }
    }

    public function create($dto): stdClass
    {
        User::validarEmail($dto->user['email']);
        $user = $this->user->create((array)$dto->user);

        $address = $this->address->create((array)$dto->address);

        $this->customer->create([
            'user_id'       => $user->id,
            'address_id'    => $address->id,
            'telephone'     => $dto->telephone
        ]);

        $staff = $this->staff->create([
            'user_id' => $user->id,
            'address_id' => $address->id
        ]);

        return (object) $staff->toArray();
    }

    public function update($dto, $id): stdClass|null
    {
        if (!$staff = $this->staff->find($id)) {
            return null;
        }

        $user = $this->user->find($staff->user_id);
        User::validarEmail($dto->user['email']);
        
        $user->update(
            (array) $dto->user
        );

        $address = $this->address->find($staff->address_id);

        $address->update(
            (array) $dto->address
        );

        return (object) $staff->toArray();
    }
}
