<?php

declare(strict_types=1);

use App\Domain\Accounts\AccountRepository;
use App\Domain\AccountTransactions\AccountTransactionRepository;
use App\Domain\AccountTypes\AccountTypeRepository;
use App\Domain\FundAllocations\FundAllocationRepository;
use App\Domain\FundTypes\FundTypeRepository;
use App\Domain\Users\UserRepository;
use App\Infrastructure\Persistence\Accounts\SQLAccountRepository;
use App\Infrastructure\Persistence\AccountTransactions\SQLAccountTransactionRepository;
use App\Infrastructure\Persistence\AccountTypes\SQLAccountTypeRepository;
use App\Infrastructure\Persistence\FundAllocations\SQLFundAllocationRepository;
use App\Infrastructure\Persistence\FundTypes\SQLFundTypeRepository;
use App\Infrastructure\Persistence\Users\SQLUserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our repository classes to their infrastructure implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(SQLUserRepository::class),
        AccountRepository::class => \DI\autowire(SQLAccountRepository::class),
        AccountTransactionRepository::class => \DI\autowire(SQLAccountTransactionRepository::class),
        AccountTypeRepository::class => \DI\autowire(SQLAccountTypeRepository::class),
        FundAllocationRepository::class => \DI\autowire(SQLFundAllocationRepository::class),
        FundTypeRepository::class => \DI\autowire(SQLFundTypeRepository::class),
    ]);
};
