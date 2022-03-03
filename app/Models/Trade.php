<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trade extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const SELL = 'sell';

    public const BUY = 'buy';

    public const TRADE_TYPES = [
        'buy',
        'sell',
    ];

    protected $fillable = [
        'trade_type',
        'company_id',
        'shares',
        'date',
        'price',
        'ave_cost',
        'commission',
        'vat',
        'sales_tax',
        'sccp_fee',
        'pse_fee',
        'target_price',
        'cut_loss',
        'remarks',
        'debit',
        'credit'
    ];

    protected $casts = [
        'company_id',
        'shares' => 'int',
        'date' => 'date:Y-m-d',
        'price' => 'double',
        'ave_cost' =>  'double',
        'commission' =>  'double',
        'vat' =>  'double',
        'sales_tax' =>  'double',
        'sccp_fee' =>  'double',
        'pse_fee' =>  'double',
        'target_price' => 'double',
        'cut_loss' => 'double',
        'total_cost' => 'double',
        'total_fees' => 'double',
        'debit' => 'double',
        'credit' => 'double',
    ];

    protected $appends = [
        'total_cost',
        'total_fees'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalCostAttribute()
    {
        $fees = $this->commission
            + $this->vat
            + $this->sales_tax
            + $this->sccp_fee
            + $this->pse_fee;

        $base = $this->price * $this->shares;

        return $this->trade_type == self::TRADE_TYPES[1]
            ? $base - $fees
            : $base + $fees;
    }

    public function getTotalFeesAttribute()
    {
        return $this->commission
            + $this->vat
            + $this->sales_tax
            + $this->sccp_fee
            + $this->pse_fee;
    }

    public function getBreakevenPriceAttribute()
    {
        return ($this->total_cost / 0.99105) / $this->shares;
    }
}
