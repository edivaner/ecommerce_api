<?php

namespace App\Services;

use App\DTO\customer\CreateCustomerDTO;
use App\DTO\customer\UpdateCustomerDTO;
use App\Repositories\Customer\CustomerRepositoryInterface;
use stdClass;

class CustomerService
{
    public function __construct(
        protected CustomerRepositoryInterface $repositoryCustomer
    ) {}

    public function getAll(string $filter = null): array
    {
        return $this->repositoryCustomer->getAll($filter);
    }
    public function findOne(string $id): stdClass|null
    {
        return $this->repositoryCustomer->findOne($id);
    }

    public function delete(string $id): void
    {
        $this->repositoryCustomer->delete($id);
    }

    public function create(CreateCustomerDTO $dto): stdClass|null
    {
        $customer = $this->repositoryCustomer->create($dto);
        if (!$customer) return null;

        return $this->findOne((string)$customer->id);
    }

    public function update(UpdateCustomerDTO $dto): stdClass|null
    {
        return $this->repositoryCustomer->update($dto);
    }
}