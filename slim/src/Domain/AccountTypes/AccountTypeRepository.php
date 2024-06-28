<?php

declare(strict_types=1);

namespace App\Domain\AccountTypes;

use App\Domain\AccountTypes\DTO\AccountTypeData;

abstract class AccountTypeRepository
{
    abstract public function findAll(): array;
    abstract public function findById(int $id): AccountTypeData;

}
