<?php

namespace Tests\Domain\Users\DTO;

use App\Domain\Users\DTO\UserData;
use Tests\TestCase;

class UserDataTest extends TestCase
{
    public function testConstructorWithFullData()
    {
        $data = [
            'id' => 1,
            'name' => 'John Doe',
            'ni_number' => 'AB123456C',
            'api_token' => 'token123'
        ];

        $userData = new UserData($data);

        $this->assertEquals(1, $userData->id());
        $this->assertEquals('John Doe', $userData->name());
        $this->assertEquals('AB123456C', $userData->niNumber());
        $this->assertEquals('token123', $userData->apiToken());
    }

    public function testConstructorWithPartialData()
    {
        $data = [
            'id' => 1,
            'name' => 'John Doe'
        ];

        $userData = new UserData($data);

        $this->assertEquals(1, $userData->id());
        $this->assertEquals('John Doe', $userData->name());
        $this->assertNull($userData->niNumber());
        $this->assertNull($userData->apiToken());
    }

    public function testConstructorWithMissingData()
    {
        $data = [];

        $userData = new UserData($data);

        $this->assertNull($userData->id());
        $this->assertNull($userData->name());
        $this->assertNull($userData->niNumber());
        $this->assertNull($userData->apiToken());
    }

    public function testId()
    {
        $data = ['id' => 1];
        $userData = new UserData($data);
        $this->assertEquals(1, $userData->id());
    }

    public function testName()
    {
        $data = ['name' => 'John Doe'];
        $userData = new UserData($data);
        $this->assertEquals('John Doe', $userData->name());
    }

    public function testNiNumber()
    {
        $data = ['ni_number' => 'AB123456C'];
        $userData = new UserData($data);
        $this->assertEquals('AB123456C', $userData->niNumber());
    }

    public function testApiToken()
    {
        $data = ['api_token' => 'token123'];
        $userData = new UserData($data);
        $this->assertEquals('token123', $userData->apiToken());
    }

    public function testToArray()
    {
        $data = [
            'id' => 1,
            'name' => 'John Doe',
            'ni_number' => 'AB123456C',
            'api_token' => 'token123'
        ];

        $userData = new UserData($data);
        $array = $userData->toArray();

        $this->assertIsArray($array);
        $this->assertEquals($data, $array);
    }

    public function testJsonSerialize()
    {
        $data = [
            'id' => 1,
            'name' => 'John Doe',
            'ni_number' => 'AB123456C',
            'api_token' => 'token123'
        ];

        $userData = new UserData($data);
        $json = json_encode($userData);

        $this->assertJson($json);
        $this->assertEquals(json_encode($data), $json);
    }
}
