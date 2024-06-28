<?php

namespace App\Infrastructure\Persistence\Accounts;

use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Accounts\DTO\AccountData;
use App\Domain\Accounts\AccountRepository;

class SQLAccountRepository extends AccountRepository
{
    /**
     * Creates a new account.
     *
     * @param AccountData $request The data for the account to be created.
     * @return AccountData The created account data.
     */
    public function create(AccountData $request): AccountData
    {
        $account = Account::create($request->toArray());
        $account->save();

        return new AccountData($account->toArray());
    }

    /**
     * Retrieves an account by its ID, optionally filtered by user ID.
     *
     * @param int $id The ID of the account to retrieve.
     * @param int|null $userId The ID of the user to filter the account by, or null to retrieve without filtering by user.
     * @return AccountData The data of the retrieved account.
     * @throws DomainRecordNotFoundException if the account is not found.
     */
    public function findById(int $id, ?int $userId): AccountData
    {
        if($userId){
            $account = Account::where([
                ['id','=',$id],
                ['user','=',$userId]
            ])->first();
        } else {
            $account = Account::find($id);
        }

        if (!$account) {
            throw new DomainRecordNotFoundException($id);
        }

        return new AccountData($account->toArray());
    }

    /**
     * Retrieves an account by user ID and account type.
     *
     * @param int $userId The ID of the user who owns the account.
     * @param int $accountType The type of the account to retrieve.
     * @return AccountData The data of the retrieved account.
     * @throws DomainRecordNotFoundException if the account is not found.
     */
    public function findByUserAndType(int $userId, int $accountType): AccountData
    {
        $account = Account::where([
            ['type','=',$accountType],
            ['user','=',$userId]
        ])->first();

        if (!$account) {
            throw new DomainRecordNotFoundException($userId);
        }

        return new AccountData($account->toArray());
    }

    /**
     * Retrieves all accounts, optionally filtered by user ID.
     *
     * @param int|null $userId The ID of the user to filter accounts by, or null to retrieve all accounts.
     * @return array An array of AccountData objects representing the accounts.
     */
    public function findAll(?int $userId): array
    {
        $accounts      = [];
        if($userId){
            $models = Account::where([
                ['user','=',$userId]
            ])->get();
        } else {
            $models = Account::all();
        }

        foreach ($models as $model) {
            $accounts[] = new AccountData($model->toArray());
        }

        return $accounts;
    }

    /**
     * Deletes an account by its ID, optionally filtered by user ID.
     *
     * @param int $id The ID of the account to delete.
     * @param int|null $userId The ID of the user to filter the account by, or null to delete without filtering by user.
     * @return void
     * @throws DomainRecordNotFoundException if the account is not found.
     */
    public function delete(int $id, ?int $userId): void
    {
        if($userId){
            $account = Account::where([
                ['id','=',$id],
                ['user','=',$userId]
            ])->first();
        } else {
            $account = Account::find($id);
        }

        if (!$account) {
            throw new DomainRecordNotFoundException($id);
        }

        $account->delete();
    }
}