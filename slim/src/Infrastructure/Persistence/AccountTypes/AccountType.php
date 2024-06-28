<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\AccountTypes;

use App\Infrastructure\Persistence\Accounts\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountType extends Model
{
    use SoftDeletes;

    protected $table = 'account_types';

    protected $fillable = ['name', 'max_allowance'];

    public function accounts()
    {
        return $this->hasMany(Account::class, 'type');
    }
}
