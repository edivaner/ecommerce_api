<?php

namespace App\Repositories\Staff;

use stdClass;

interface StaffRepositoryInterface
{
    public function getAll(string $filter = null): array;
    public function findOne(string $id): stdClass|null|array;
    public function delete(string $id): void;
    public function create($dto): null|stdClass;
    public function update($dto, $id): null|stdClass;
}
