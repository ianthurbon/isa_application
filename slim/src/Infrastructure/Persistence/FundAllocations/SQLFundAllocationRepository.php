<?php

namespace App\Infrastructure\Persistence\FundAllocations;

use App\Domain\FundAllocations\DTO\FundAllocationData;
use App\Domain\FundAllocations\FundAllocationRepository;

class SQLFundAllocationRepository extends FundAllocationRepository
{
    /**
     * Creates a new fund allocation.
     *
     * @param FundAllocationData $request The data for the fund allocation to be created.
     * @return FundAllocationData The created fund allocation data.
     */
    public function create(FundAllocationData $request): FundAllocationData
    {
        $allocation = FundAllocation::create($request->toArray());
        $allocation->save();

        return new FundAllocationData($allocation->toArray());
    }
}