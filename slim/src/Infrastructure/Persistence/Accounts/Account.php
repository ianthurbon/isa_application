<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Accounts;

use App\Infrastructure\Persistence\AccountTransactions\AccountTransaction;
use App\Infrastructure\Persistence\AccountTypes\AccountType;
use App\Infrastructure\Persistence\FundAllocations\FundAllocation;
use App\Infrastructure\Persistence\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $table = 'accounts';

    protected $fillable = ['user', 'type'];

    public function userModel()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function accountTypeModel()
    {
        return $this->belongsTo(AccountType::class, 'type');
    }

    public function allocations()
    {
        return $this->hasMany(FundAllocation::class, 'account');
    }

    public function transactions()
    {
        return $this->hasMany(AccountTransaction::class, 'account');
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['user_name'] = $this->userModel->name ?? null;
        $array['account_type_name'] = $this->accountTypeModel?->name ?? null;
        $array['max_allowance'] = $this->accountTypeModel?->max_allowance ?? null;

        foreach ($this->allocations as $fundAllocation) {
            $array['fund_allocations'][] = [
                'fund_id' => $fundAllocation->fund,
                'percentage_allocation' => $fundAllocation->percentage_allocation,
                'current_price' => $fundAllocation->fundModel->current_price,
            ];
        }

        foreach ($this->transactions as $transaction) {
            $array['transactions'][] = [
                'date' => $transaction->created_at,
                'fund_id' => $transaction->fundModel?->id,
                'fund_current_price' => $transaction->fundModel?->current_price,
                'type' => $transaction->transaction_type,
                'units' => $transaction->units,
                'gbp_total' => $transaction->gbp_total,
            ];
        }
        return $array;
    }
}
