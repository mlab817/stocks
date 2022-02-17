<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trade extends Model
{
    use HasFactory;
    use SoftDeletes;

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
        'remarks',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getTotalCostAttribute()
    {
        return $this->price * $this->shares
            + $this->commission
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
