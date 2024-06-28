<?php

namespace Tests\Domain\Accounts\DTO;

use App\Domain\Accounts\DTO\AccountData;
use Tests\TestCase;

class AccountDataTest extends TestCase
{
    public function testConstructorWithFullData()
    {
        $data = [
            'id' => 1,
            'user' => 2,
            'user_name' => 'John Doe',
            'type' => 3,
            'account_type_name' => 'Savings',
            'max_allowance' => 1000,
            'fund_allocations' => ['allocation1', 'allocation2'],
            'transactions' => ['transaction1', 'transaction2']
        ];

        $accountData = new AccountData($data);

        $this->assertEquals(1, $accountData->id());
        $this->assertEquals(2, $accountData->user());
        $this->assertEquals('John Doe', $accountData->userName());
        $this->assertEquals(3, $accountData->type());
        $this->assertEquals('Savings', $accountData->accountTypeName());
        $this->assertEquals(1000, $accountData->maxAllowance());
        $this->assertEquals(['allocation1', 'allocation2'], $accountData->fundAllocations());
        $this->assertEquals(['transaction1', 'transaction2'], $accountData->transactions());
    }

    public function testConstructorWithPartialData()
    {
        $data = [
            'id' => 1,
            'user' => 2,
            'user_name' => 'John Doe',
        ];

        $accountData = new AccountData($data);

        $this->assertEquals(1, $accountData->id());
        $this->assertEquals(2, $accountData->user());
        $this->assertEquals('John Doe', $accountData->userName());
        $this->assertNull($accountData->type());
        $this->assertNull($accountData->accountTypeName());
        $this->assertNull($accountData->maxAllowance());
        $this->assertNull($accountData->fundAllocations());
        $this->assertNull($accountData->transactions());
    }

    public function testConstructorWithMissingData()
    {
        $data = [];

        $accountData = new AccountData($data);

        $this->assertNull($accountData->id());
        $this->assertNull($accountData->user());
        $this->assertNull($accountData->userName());
        $this->assertNull($accountData->type());
        $this->assertNull($accountData->accountTypeName());
        $this->assertNull($accountData->maxAllowance());
        $this->assertNull($accountData->fundAllocations());
        $this->assertNull($accountData->transactions());
    }

    public function testId()
    {
        $data = ['id' => 1];
        $accountData = new AccountData($data);
        $this->assertEquals(1, $accountData->id());
    }

    public function testUser()
    {
        $data = ['user' => 2];
        $accountData = new AccountData($data);
        $this->assertEquals(2, $accountData->user());
    }

    public function testUserName()
    {
        $data = ['user_name' => 'John Doe'];
        $accountData = new AccountData($data);
        $this->assertEquals('John Doe', $accountData->userName());
    }

    public function testType()
    {
        $data = ['type' => 3];
        $accountData = new AccountData($data);
        $this->assertEquals(3, $accountData->type());
    }

    public function testAccountTypeName()
    {
        $data = ['account_type_name' => 'Savings'];
        $accountData = new AccountData($data);
        $this->assertEquals('Savings', $accountData->accountTypeName());
    }

    public function testMaxAllowance()
    {
        $data = ['max_allowance' => 1000];
        $accountData = new AccountData($data);
        $this->assertEquals(1000, $accountData->maxAllowance());
    }

    public function testFundAllocations()
    {
        $data = ['fund_allocations' => ['allocation1', 'allocation2']];
        $accountData = new AccountData($data);
        $this->assertEquals(['allocation1', 'allocation2'], $accountData->fundAllocations());
    }

    public function testTransactions()
    {
        $data = ['transactions' => ['transaction1', 'transaction2']];
        $accountData = new AccountData($data);
        $this->assertEquals(['transaction1', 'transaction2'], $accountData->transactions());
    }

    public function testToArray()
    {
        $data = [
            'id' => 1,
            'user' => 2,
            'user_name' => 'John Doe',
            'type' => 3,
            'account_type_name' => 'Savings',
            'max_allowance' => 1000,
            'fund_allocations' => ['allocation1', 'allocation2'],
            'transactions' => ['transaction1', 'transaction2']
        ];

        $accountData = new AccountData($data);
        $array = $accountData->toArray();

        $this->assertIsArray($array);
        $this->assertEquals($data, $array);
    }

    public function testJsonSerialize()
    {
        $data = [
            'id' => 1,
            'user' => 2,
            'user_name' => 'John Doe',
            'type' => 3,
            'account_type_name' => 'Savings',
            'max_allowance' => 1000,
            'fund_allocations' => ['allocation1', 'allocation2'],
            'transactions' => ['transaction1', 'transaction2']
        ];

        $accountData = new AccountData($data);
        $json = json_encode($accountData);

        $this->assertJson($json);
        $this->assertEquals(json_encode($data), $json);
    }
}
