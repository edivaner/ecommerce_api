<?php

namespace App\Repositories\Department;

use App\DTO\department\CreateDepartmentDTO;
use App\DTO\department\UpdateDepartmentDTO;
use App\Models\Department;
use App\Repositories\Department\DepartmentRepositoryInterface;
use stdClass;

class DepartmentEloquentORM implements DepartmentRepositoryInterface
{
    public function __construct(
        protected Department $department
    ) {}

    public function getAll(string $filter = null): array
    {
        return $this->department
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('id', $filter);
                }
            })
            ->get()
            ->toArray();
    }

    public function findOne(string $id): stdClass
    {
        $department = $this->department->find($id);
        if (!$department) return null;
        return (object) $department->toArray();
    }

    public function delete(string $id): void
    {
        $department = $this->department->findOrFail($id)->toArray();

        if ($department) {
            $this->department->findOrFail($id)->delete();
        }
    }

    public function create(CreateDepartmentDTO $dto): stdClass
    {
        $department = $this->department->create([
            'name' => $dto->name
        ]);

        return (object) $department->toArray();
    }

    public function update(UpdateDepartmentDTO $dto): stdClass
    {
        if (!$department = $this->department->find($dto->id)) {
            return null;
        }

        $department->update(['name' => $dto->name]);

        return (object) $department->toArray();
    }
}
