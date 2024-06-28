<?php

namespace App\Domain\Accounts;

use App\Domain\Accounts\DTO\AccountData;
use App\Domain\Accounts\Validator\AccountValidator;
use App\Domain\DomainException\ValidationException;
use App\Domain\FundAllocations\DTO\FundAllocationData;
use App\Domain\FundAllocations\FundAllocationRepository;
use Psr\Log\LoggerInterface;

class AccountManager
{
    public const DEFAULT_FUND_ID = 1;
    public const DEFAULT_ALLOCATION = 100;

    public function __construct(
        protected LoggerInterface $logger,
        protected AccountRepository $accounts,
        protected FundAllocationRepository $allocations,
        protected AccountValidator $validator,
    )
    {}

    /**
     * Creates a new account and sets the initial fund allocation.
     *
     * @param AccountData $request The data for the account to be created.
     * @return AccountData The created account data with initial fund allocation.
     * @throws ValidationException
     */
    public function create(AccountData $request): AccountData
    {
        //Throw an exception if the request is invalid
        $this->validator->validateNewAccountData($request);

        //Create the new account
        $newAccount = $this->accounts->create($request);

        //This is a new account so add the fund allocation, which for now will be 100% to the Cushon Equities Fund
        $this->allocations->create(new FundAllocationData([
            'fund' => self::DEFAULT_FUND_ID,
            'account' => $newAccount->id(),
            'percentage_allocation' => self::DEFAULT_ALLOCATION
        ]));

        return $this->get($newAccount->id(), $newAccount->user());
    }

    /**
     * Retrieves account data for a given account ID and user ID.
     *
     * @param int $id The ID of the account to retrieve.
     * @param int $userId The ID of the user who owns the account.
     * @return AccountData The account data for the specified account and user.
     */
    public function get(int $id, int $userId): AccountData
    {
        return $this->accounts->findById($id, $userId);
    }

    /**
     * Retrieves all account data for a given user ID.
     *
     * @param int $userId The ID of the user whose accounts are to be retrieved.
     * @return array An array of account data for the specified user.
     */
    public function all(int $userId): array
    {
        return $this->accounts->findAll($userId);
    }

    /**
     * Deletes an account for a given account ID and user ID.
     *
     * @param int $id The ID of the account to delete.
     * @param int $userId The ID of the user who owns the account.
     * @return void
     */
    public function delete(int $id, int $userId): void
    {
        $this->accounts->delete($id, $userId);
    }
}