<?php

namespace App\Infrastructure\Persistence\AccountTypes;

use App\Domain\AccountTypes\DTO\AccountTypeData;
use App\Domain\AccountTypes\AccountTypeRepository;
use App\Domain\DomainException\DomainRecordNotFoundException;

class SQLAccountTypeRepository extends AccountTypeRepository
{
    /**
     * Retrieves all account types.
     *
     * @return array An array of AccountTypeData objects representing the account types.
     */
    public function findAll(): array
    {
        $types      = [];
        $models          = AccountType::all();
        foreach ($models as $model) {
            $types[] = new AccountTypeData($model->toArray());
        }

        return $types;
    }

    /**
     * Retrieves an account type by its ID.
     *
     * @param int $id The ID of the account type to retrieve.
     * @return AccountTypeData The data of the retrieved account type.
     * @throws DomainRecordNotFoundException if the account type is not found.
     */
    public function findById(int $id): AccountTypeData
    {
        $type = AccountType::find($id);

        if (!$type) {
            throw new DomainRecordNotFoundException($id);
        }

        return new AccountTypeData($type->toArray());
    }
}