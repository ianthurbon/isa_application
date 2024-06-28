<?php

namespace Tests\Domain\Accounts;

use App\Domain\Accounts\AccountManager;
use App\Domain\Accounts\DTO\AccountData;
use App\Domain\Accounts\Validator\AccountValidator;
use App\Domain\Accounts\AccountRepository;
use App\Domain\FundAllocations\DTO\FundAllocationData;
use App\Domain\FundAllocations\FundAllocationRepository;
use App\Domain\DomainException\ValidationException;
use Psr\Log\LoggerInterface;
use Mockery;
use Tests\TestCase;

class AccountManagerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testCreate()
    {
        $logger = Mockery::mock(LoggerInterface::class);
        $accountRepository = Mockery::mock(AccountRepository::class);
        $fundAllocationRepository = Mockery::mock(FundAllocationRepository::class);
        $accountValidator = Mockery::mock(AccountValidator::class);

        $accountData = new AccountData([
            'user' => 1,
            'type' => 1
        ]);

        $createdAccountData = new AccountData([
            'id' => 1,
            'user' => 1,
            'type' => 1
        ]);

        $fundAllocationData = new FundAllocationData([
            'fund' => 1,
            'account' => 1,
            'percentage_allocation' => 100,
        ]);

        $accountValidator->shouldReceive('validateNewAccountData')
            ->once()
            ->with($accountData);

        $accountRepository->shouldReceive('create')
            ->once()
            ->with($accountData)
            ->andReturn($createdAccountData);

        $fundAllocationRepository->shouldReceive('create')
            ->once()
            ->with(Mockery::any());

        $accountRepository->shouldReceive('findById')
            ->once()
            ->with(1, 1)
            ->andReturn($createdAccountData);

        $manager = new AccountManager($logger, $accountRepository, $fundAllocationRepository, $accountValidator);

        $result = $manager->create($accountData);

        $this->assertInstanceOf(AccountData::class, $result);
        $this->assertEquals(1, $result->id());
    }


    public function testCreateWithInvalidData()
    {
        $this->expectException(ValidationException::class);

        $logger = Mockery::mock(LoggerInterface::class);
        $accountRepository = Mockery::mock(AccountRepository::class);
        $fundAllocationRepository = Mockery::mock(FundAllocationRepository::class);
        $accountValidator = Mockery::mock(AccountValidator::class);

        $accountData = new AccountData([
            'user' => 1,
            'type' => 1
        ]);

        $accountValidator->shouldReceive('validateNewAccountData')
            ->once()
            ->with($accountData)
            ->andThrow(new ValidationException());

        $manager = new AccountManager($logger, $accountRepository, $fundAllocationRepository, $accountValidator);

        $manager->create($accountData);
    }

    public function testGet()
    {
        $logger = Mockery::mock(LoggerInterface::class);
        $accountRepository = Mockery::mock(AccountRepository::class);
        $fundAllocationRepository = Mockery::mock(FundAllocationRepository::class);
        $accountValidator = Mockery::mock(AccountValidator::class);

        $accountData = new AccountData([
            'id' => 1,
            'user' => 1,
            'type' => 1
        ]);

        $accountRepository->shouldReceive('findById')
            ->once()
            ->with(1, 1)
            ->andReturn($accountData);

        $manager = new AccountManager($logger, $accountRepository, $fundAllocationRepository, $accountValidator);

        $result = $manager->get(1, 1);

        $this->assertInstanceOf(AccountData::class, $result);
        $this->assertEquals(1, $result->id());
    }

    public function testAll()
    {
        $logger = Mockery::mock(LoggerInterface::class);
        $accountRepository = Mockery::mock(AccountRepository::class);
        $fundAllocationRepository = Mockery::mock(FundAllocationRepository::class);
        $accountValidator = Mockery::mock(AccountValidator::class);

        $accountData1 = new AccountData([
            'id' => 1,
            'user' => 1,
            'type' => 1
        ]);

        $accountData2 = new AccountData([
            'id' => 2,
            'user' => 1,
            'type' => 2
        ]);

        $accountRepository->shouldReceive('findAll')
            ->once()
            ->with(1)
            ->andReturn([$accountData1, $accountData2]);

        $manager = new AccountManager($logger, $accountRepository, $fundAllocationRepository, $accountValidator);

        $result = $manager->all(1);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(AccountData::class, $result[0]);
        $this->assertInstanceOf(AccountData::class, $result[1]);
    }

    public function testDelete()
    {
        $logger = Mockery::mock(LoggerInterface::class);
        $accountRepository = Mockery::mock(AccountRepository::class);
        $fundAllocationRepository = Mockery::mock(FundAllocationRepository::class);
        $accountValidator = Mockery::mock(AccountValidator::class);

        $accountRepository->shouldReceive('delete')
            ->once()
            ->with(1, 1);

        $manager = new AccountManager($logger, $accountRepository, $fundAllocationRepository, $accountValidator);

        $manager->delete(1, 1);

        $this->assertTrue(true); // If no exception is thrown, the test passes
    }
}
