<?php

namespace App\Infrastructure\Persistence\FundTypes;

use App\Domain\FundTypes\DTO\FundTypeData;
use App\Domain\FundTypes\FundTypeRepository;

class SQLFundTypeRepository extends FundTypeRepository
{
    /**
     * Retrieves all fund types.
     *
     * @return array An array of FundTypeData objects representing the fund types.
     */
    public function findAll(): array
    {
        $funds      = [];
        $models          = FundType::all();
        foreach ($models as $model) {
            $funds[] = new FundTypeData($model->toArray());
        }

        return $funds;
    }
}