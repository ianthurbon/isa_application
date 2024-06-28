<?php

declare(strict_types=1);

namespace App\Application\Actions\AccountTypes;

use App\Application\Actions\Action;
use App\Domain\AccountTypes\AccountTypeRepository;
use App\Domain\Users\UserRepository;
use Psr\Log\LoggerInterface;

abstract class AccountTypesAction extends Action
{
    protected AccountTypeRepository $accountTypes;

    public function __construct(LoggerInterface $logger, AccountTypeRepository $accountTypes)
    {
        parent::__construct($logger);
        $this->accountTypes = $accountTypes;
    }
}
