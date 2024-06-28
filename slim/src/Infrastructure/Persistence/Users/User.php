<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Users;

use App\Infrastructure\Persistence\Accounts\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = ['name', 'ni_number', 'api_token'];

    public function accounts()
    {
        return $this->hasMany(Account::class, 'user');
    }
}
