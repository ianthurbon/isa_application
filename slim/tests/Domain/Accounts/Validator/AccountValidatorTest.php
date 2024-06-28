<?php

namespace Tests\Domain\Accounts\Validator;

use App\Domain\Accounts\Validator\AccountValidator;
use App\Domain\Accounts\DTO\AccountData;
use App\Domain\Accounts\AccountRepository;
use App\Domain\AccountTypes\AccountTypeRepository;
use App\Domain\AccountTypes\DTO\AccountTypeData;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\DomainException\ValidationException;
use Psr\Log\LoggerInterface;
use Mockery;
use Tests\TestCase;

class AccountValidatorTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testValidateNewAccountDataWithValidData()
    {
        $logger = Mockery::mock(LoggerInterface::class);
        $accountRepository = Mockery::mock(AccountRepository::class);
        $accountTypeRepository = Mockery::mock(AccountTypeRepository::class);

        $accountRepository->shouldReceive('findByUserAndType')
            ->andThrow(new DomainRecordNotFoundException());

        $accountTypeData = new AccountTypeData([
            'id' => 1,
            'name' => 'Savings',
            'max_allowance' => 1000,
        ]);
        $accountTypeRepository->shouldReceive('findById')
            ->andReturn($accountTypeData);

        $accountData = new AccountData([
            'user' => 1,
            'type' => 1
        ]);

        $validator = new AccountValidator($logger, $accountRepository, $accountTypeRepository);

        $validator->validateNewAccountData($accountData);

        $this->assertTrue(true); // If no exception is thrown, the test passes
    }

    public function testValidateNewAccountDataWithMissingAccountType()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Missing Account Type");

        $logger = Mockery::mock(LoggerInterface::class);
        $accountRepository = Mockery::mock(AccountRepository::class);
        $accountTypeRepository = Mockery::mock(AccountTypeRepository::class);

        $accountData = new AccountData([
            'user' => 1,
            'type' => null
        ]);

        $validator = new AccountValidator($logger, $accountRepository, $accountTypeRepository);

        $validator->validateNewAccountData($accountData);
    }

    public function testValidateNewAccountDataWithInvalidAccountType()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Invalid Account Type");

        $logger = Mockery::mock(LoggerInterface::class);
        $accountRepository = Mockery::mock(AccountRepository::class);
        $accountTypeRepository = Mockery::mock(AccountTypeRepository::class);

        $accountTypeRepository->shouldReceive('findById')
            ->andThrow(new DomainRecordNotFoundException());

        $accountData = new AccountData([
            'user' => 1,
            'type' => 999
        ]);

        $validator = new AccountValidator($logger, $accountRepository, $accountTypeRepository);

        $validator->validateNewAccountData($accountData);
    }

    public function testValidateNewAccountDataWithExistingAccount()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Account Type already exists");

        $logger = Mockery::mock(LoggerInterface::class);
        $accountRepository = Mockery::mock(AccountRepository::class);
        $accountTypeRepository = Mockery::mock(AccountTypeRepository::class);

        $accountTypeData = new AccountTypeData([
            'id' => 1,
            'name' => 'Savings',
            'max_allowance' => 1000,
        ]);
        $accountTypeRepository->shouldReceive('findById')
            ->andReturn($accountTypeData);

        $accountData = new AccountData([
            'user' => 1,
            'type' => 1
        ]);

        $accountRepository->shouldReceive('findByUserAndType')
            ->andReturn($accountData);

        $validator = new AccountValidator($logger, $accountRepository, $accountTypeRepository);

        $validator->validateNewAccountData($accountData);
    }
}
