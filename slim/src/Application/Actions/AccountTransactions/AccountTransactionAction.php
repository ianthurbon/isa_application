<?php

declare(strict_types=1);

namespace App\Application\Actions\AccountTransactions;

use App\Application\Actions\Action;
use App\Domain\AccountTransactions\AccountTransactionManager;
use Psr\Log\LoggerInterface;

abstract class AccountTransactionAction extends Action
{
    protected AccountTransactionManager $transactions;

    public function __construct(LoggerInterface $logger, AccountTransactionManager $transactions)
    {
        parent::__construct($logger);
        $this->transactions = $transactions;
    }
}
