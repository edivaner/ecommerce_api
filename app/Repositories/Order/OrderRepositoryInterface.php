<?php

namespace App\Repositories\Order;

use stdClass;

interface OrderRepositoryInterface
{
    public function getAll(string $filter = null): array;
    public function findOne(string $id): null|stdClass;
    public function delete(string $id): void;
    public function create($dto): null|stdClass;
    public function updateStatus(string $id, string $status): null|stdClass;
    public function update($id, $dto): null|stdClass;
}
