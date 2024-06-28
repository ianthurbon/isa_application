<?php

declare(strict_types=1);

namespace App\Application\Actions\FundTypes;

use App\Application\Actions\Action;
use App\Domain\FundTypes\FundTypeRepository;
use App\Domain\Users\UserRepository;
use Psr\Log\LoggerInterface;

abstract class FundTypesAction extends Action
{
    protected FundTypeRepository $fundTypes;

    public function __construct(LoggerInterface $logger, FundTypeRepository $fundTypes)
    {
        parent::__construct($logger);
        $this->fundTypes = $fundTypes;
    }
}
