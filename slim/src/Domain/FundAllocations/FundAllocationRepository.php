<?php

declare(strict_types=1);

namespace App\Domain\FundAllocations;

use App\Domain\FundAllocations\DTO\FundAllocationData;

abstract class FundAllocationRepository
{
    abstract public function create(FundAllocationData $request): FundAllocationData;

}
