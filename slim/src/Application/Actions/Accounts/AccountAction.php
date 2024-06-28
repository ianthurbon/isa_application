<?php

declare(strict_types=1);

namespace App\Application\Actions\Accounts;

use App\Application\Actions\Action;
use App\Domain\Accounts\AccountManager;
use Psr\Log\LoggerInterface;

abstract class AccountAction extends Action
{
    protected AccountManager $accounts;

    public function __construct(LoggerInterface $logger, AccountManager $accounts)
    {
        parent::__construct($logger);
        $this->accounts = $accounts;
    }
}
