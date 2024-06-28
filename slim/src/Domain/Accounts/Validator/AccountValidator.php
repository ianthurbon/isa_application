<?php

declare(strict_types=1);

namespace App\Domain\Accounts\Validator;

use App\Domain\Accounts\AccountRepository;
use App\Domain\Accounts\DTO\AccountData;
use App\Domain\AccountTypes\AccountTypeRepository;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\DomainException\ValidationException;
use Psr\Log\LoggerInterface;

class AccountValidator
{
    public function __construct(
        protected LoggerInterface $logger,
        protected AccountRepository $accounts,
        protected AccountTypeRepository $accountTypes,
    )
    {}

    /**
     * @throws ValidationException
     */
    public function validateNewAccountData(AccountData $request): void
    {
        //Validate Account Type
        $accountType = $request->type();
        if(empty($accountType)){
            throw new ValidationException("Missing Account Type");
        }
        else if (!$this->validateAccountType($accountType)) {
            throw new ValidationException("Invalid Account Type");
        }

        //Ensure only a single account is allowed per user
        if (!$this->hasExistingAccount($request->user(), $accountType)) {
            throw new ValidationException("Account Type already exists");
        }
    }

    private function validateAccountType(int $id): bool
    {
        try {
            $this->accountTypes->findById($id);
            return true;
        } catch (DomainRecordNotFoundException $e) {
            return false;
        }
    }

    private function hasExistingAccount(int $user, int $type): bool
    {
        try {
            $this->accounts->findByUserAndType($user, $type);
            return false;
        } catch (DomainRecordNotFoundException $e) {
            return true;
        }
    }
}
