<?php

namespace App\Repositories\Customer;

use App\DTO\customer\{
    CreateCustomerDTO,
    UpdateCustomerDTO,
};

use stdClass;

interface CustomerRepositoryInterface
{
    public function getAll(string $filter = null): array;
    public function findOne(string $id): stdClass|null;
    public function delete(string $id): void;
    public function create(CreateCustomerDTO $dto): null|stdClass;
    public function update(UpdateCustomerDTO $dto): null|stdClass;
}
