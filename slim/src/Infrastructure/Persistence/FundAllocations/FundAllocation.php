<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\FundAllocations;

use App\Infrastructure\Persistence\Accounts\Account;
use App\Infrastructure\Persistence\FundTypes\FundType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundAllocation extends Model
{
    use SoftDeletes;

    protected $table = 'fund_allocations';

    protected $fillable = ['account', 'fund', 'percentage_allocation'];

    public function accountModel()
    {
        return $this->belongsTo(Account::class, 'account');
    }

    public function fundModel()
    {
        return $this->belongsTo(FundType::class, 'fund');
    }
}
