<?php

namespace App\Repositories\Department;

use App\DTO\department\{
    CreateDepartmentDTO,
    UpdateDepartmentDTO,
};

use stdClass;

interface DepartmentRepositoryInterface
{
    public function getAll(string $filter = null): array;
    public function findOne(string $id): stdClass|null;
    public function delete(string $id): void;
    public function create(CreateDepartmentDTO $dto): null|stdClass;
    public function update(UpdateDepartmentDTO $dto): null|stdClass;
}
