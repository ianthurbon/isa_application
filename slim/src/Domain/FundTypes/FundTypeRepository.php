<?php

declare(strict_types=1);

namespace App\Domain\FundTypes;

abstract class FundTypeRepository
{
    abstract public function findAll(): array;

}
