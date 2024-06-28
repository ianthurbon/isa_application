<?php

declare(strict_types=1);

namespace App\Domain\Accounts;

use App\Domain\Accounts\DTO\AccountData;

abstract class AccountRepository
{
    abstract public function create(AccountData $request): AccountData;

    abstract public function findById(int $id, ?int $userId): AccountData;

    abstract public function findByUserAndType(int $userId, int $accountType): AccountData;

    abstract public function findAll(?int $userId): array;

    abstract public function delete(int $id, ?int $userId): void;

}
