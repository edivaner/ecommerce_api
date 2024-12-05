<?php

namespace App\Services;

use App\Repositories\Staff\StaffRepositoryInterface;
use stdClass;

class StaffService
{
    public function __construct(
        protected StaffRepositoryInterface $repositoryStaff
    ) {}

    public function getAll(string $filter = null): array
    {
        return $this->repositoryStaff->getAll($filter);
    }
    public function findOne(string $id): stdClass|null
    {
        return $this->repositoryStaff->findOne($id);
    }

    public function delete(string $id): void
    {
        $this->repositoryStaff->delete($id);
    }

    public function create($dto): stdClass|null
    {
        $staff = $this->repositoryStaff->create($dto);
        if (!$staff) return null;

        return $this->findOne((string)$staff->id);
    }

    public function update($dto, $id): stdClass|null
    {
        return $this->repositoryStaff->update($dto, $id);
    }
}