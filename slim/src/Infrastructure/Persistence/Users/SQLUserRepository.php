<?php

namespace App\Infrastructure\Persistence\Users;

use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Users\DTO\UserData;
use App\Domain\Users\UserRepository;

class SQLUserRepository extends UserRepository
{
    /**
     * Retrieves a user by their ID.
     *
     * @param int $id The ID of the user to retrieve.
     * @return UserData The data of the retrieved user.
     * @throws DomainRecordNotFoundException if the user is not found.
     */
    public function findById(int $id): UserData
    {
        $user = User::find($id);

        if (!$user) {
            throw new DomainRecordNotFoundException($id);
        }

        return new UserData($user->toArray());
    }

    /**
     * Retrieves a user by their API token.
     *
     * @param string $token The API token of the user to retrieve.
     * @return UserData The data of the retrieved user.
     * @throws DomainRecordNotFoundException if the user is not found.
     */
    public function findByToken(string $token): UserData
    {
        $user = User::where([
            ['api_token', '=', $token]
        ])->first();

        if (!$user) {
            throw new DomainRecordNotFoundException($token);
        }

        return new UserData($user->toArray());
    }

    /**
     * Retrieves all users.
     *
     * @return array An array of UserData objects representing all users.
     */
    public function findAll(): array
    {
        $users      = [];
        $models          = User::all();
        foreach ($models as $model) {
            $users[] = new UserData($model->toArray());
        }

        return $users;
    }
}