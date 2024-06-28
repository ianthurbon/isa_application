<?php

declare(strict_types=1);

namespace App\Domain\AccountTransactions\Validator;

use App\Domain\Accounts\AccountRepository;
use App\Domain\Accounts\DTO\AccountData;
use App\Domain\AccountTransactions\AccountTransactionRepository;
use App\Domain\AccountTransactions\DTO\AccountTransactionData;
use App\Domain\AccountTypes\AccountTypeRepository;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\DomainException\ValidationException;
use Psr\Log\LoggerInterface;
use Respect\Validation\Validator as v;

class AccountTransactionValidator
{
    public function __construct(
        protected LoggerInterface $logger,
        protected AccountTransactionRepository $transactions
    )
    {}

    /**
     * @throws ValidationException
     */
    public function validateNewAccountTransactionData(AccountData $account, AccountTransactionData $request): void
    {
        //Validate GBP Total deposit amount
        $gbpTotal = $request->gbpTotal();
        if(empty($gbpTotal)){
            throw new ValidationException("Missing GBP Total deposit amount");
        }
        else if (!v::floatVal()->validate($gbpTotal) || $gbpTotal <= 0) {
            throw new ValidationException("Invalid GBP Total deposit amount");
        }

        //Ensure maximum allowance has not been exceeded
        if ($this->exceededMaxAllowance($account, $gbpTotal)) {
            throw new ValidationException("This deposit will exceed the maximum allowance");
        }
    }

    private function exceededMaxAllowance(AccountData $account, $gbpTotal): bool
    {
        $totalDeposits = $this->transactions->currentTaxYearDeposits($account->id());
        return ($totalDeposits + $gbpTotal) > $account->maxAllowance();
    }
}
