<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\FundTypes;

use App\Infrastructure\Persistence\AccountTransactions\AccountTransaction;
use App\Infrastructure\Persistence\FundAllocations\FundAllocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundType extends Model
{
    use SoftDeletes;

    protected $table = 'fund_types';

    protected $fillable = ['name', 'current_price'];

    protected $casts = [
        'current_price'        => 'float',
    ];

    public function allocations()
    {
        return $this->hasMany(FundAllocation::class, 'fund');
    }

    public function transactions()
    {
        return $this->hasMany(AccountTransaction::class, 'fund');
    }
}
