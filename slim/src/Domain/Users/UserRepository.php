<?php

declare(strict_types=1);

namespace App\Domain\Users;

use App\Domain\Users\DTO\UserData;

abstract class UserRepository
{
    abstract public function findById(int $id): UserData;

    abstract public function findByToken(string $token): UserData;

    abstract public function findAll(): array;

}
