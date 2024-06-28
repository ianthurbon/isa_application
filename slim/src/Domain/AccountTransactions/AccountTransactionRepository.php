<?php

declare(strict_types=1);

namespace App\Domain\AccountTransactions;

use App\Domain\AccountTransactions\DTO\AccountTransactionData;

abstract class AccountTransactionRepository
{
    abstract public function create(AccountTransactionData $request): AccountTransactionData;
    abstract public function findAll(?int $accountId): array;
    abstract public function currentTaxYearDeposits(int $accountId): float;

}
