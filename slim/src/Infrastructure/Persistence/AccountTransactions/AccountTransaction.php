<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\AccountTransactions;

use App\Infrastructure\Persistence\Accounts\Account;
use App\Infrastructure\Persistence\FundTypes\FundType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountTransaction extends Model
{
    use SoftDeletes;

    protected $table = 'account_transactions';

    protected $fillable = ['account', 'fund', 'transaction_type', 'units', 'gbp_total'];

    public function accountModel()
    {
        return $this->belongsTo(Account::class, 'account');
    }

    public function fundModel()
    {
        return $this->belongsTo(FundType::class, 'fund');
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['user'] = $this->accountModel->user ?? null;

        return $array;
    }
}
