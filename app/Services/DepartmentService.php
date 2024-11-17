<?php

namespace App\Services;

use App\DTO\department\CreateDepartmentDTO;
use App\DTO\department\UpdateDepartmentDTO;
use App\Repositories\Department\DepartmentRepositoryInterface;
use stdClass;

class DepartmentService
{
    public function __construct(
        protected DepartmentRepositoryInterface $repositoryDepartment
    ) {}

    public function getAll(string $filter = null): array
    {
        return $this->repositoryDepartment->getAll($filter);
    }
    public function findOne(string $id): stdClass|null
    {
        return $this->repositoryDepartment->findOne($id);
    }

    public function delete(string $id): void
    {
        $this->repositoryDepartment->delete($id);
    }

    public function create(CreateDepartmentDTO $dto): stdClass|null
    {
        $department = $this->repositoryDepartment->create($dto);
        if (!$department) return null;

        return $department;
    }

    public function update(UpdateDepartmentDTO $dto): stdClass|null
    {
        return $this->repositoryDepartment->update($dto);
    }
}