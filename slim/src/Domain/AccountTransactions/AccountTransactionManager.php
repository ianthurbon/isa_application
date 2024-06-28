<?php

namespace App\Domain\AccountTransactions;

use App\Domain\Accounts\AccountRepository;
use App\Domain\Accounts\DTO\AccountData;
use App\Domain\AccountTransactions\DTO\AccountTransactionData;
use App\Domain\AccountTransactions\Validator\AccountTransactionValidator;
use App\Domain\DomainException\ValidationException;
use App\Domain\FundTypes\FundTypeRepository;
use Psr\Log\LoggerInterface;

class AccountTransactionManager
{
    public function __construct(
        protected LoggerInterface $logger,
        protected AccountRepository $accounts,
        protected AccountTransactionRepository $transactions,
        protected FundTypeRepository $fundTypeRepository,
        protected AccountTransactionValidator $validator,
    )
    {}

    /**
     * Creates a new account deposit transaction and records the fund units purchase transactions.
     *
     * @param AccountTransactionData $request The data for the transaction to be created.
     * @return AccountData The updated account data after the transaction.
     * @throws ValidationException
     */
    public function create(AccountTransactionData $request): AccountData
    {
        // Get the account
        $account = $this->accounts->findById($request->id(), $request->user());

        //Throw an exception if the request is invalid
        $this->validator->validateNewAccountTransactionData($account, $request);

        // Record deposit transaction
        $this->transactions->create(
            new AccountTransactionData(
                [
                    'account' => $account->id(),
                    'transaction_type' => AccountTransactionData::DEPOSIT_TRANSACTION,
                    'gbp_total' => $request->gbpTotal(),
                ]
            )
        );

        // Record the fund units purchase transaction
        foreach ($account->fundAllocations() as $fund){
            $gbpTotal = $request->gbpTotal() * ($fund['percentage_allocation']/100);
            $units = round($gbpTotal/$fund['current_price'], 4);
            $this->transactions->create(
                new AccountTransactionData(
                    [
                        'account' => $account->id(),
                        'fund' => $fund['fund_id'],
                        'transaction_type' => AccountTransactionData::BUY_TRANSACTION,
                        'units' => $units,
                        'gbp_total' => $gbpTotal,
                    ]
                )
            );
        }
        return $this->accounts->findById($request->id(), $request->user());
    }

    /**
     * Retrieves all transactions for a given account ID and user ID.
     *
     * @param int $accountId The ID of the account whose transactions are to be retrieved.
     * @param int $userId The ID of the user who owns the account.
     * @return array An array of transaction data for the specified account.
     */
    public function all(int $accountId, int $userId): array
    {
        // Get the account
        $account = $this->accounts->findById($accountId, $userId);
        return $this->transactions->findAll($account->id());
    }
}