<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoricalPrice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'date',
        'open',
        'high',
        'low',
        'close',
        'value',
        'alma',
        'macd',
        'macd_signal',
        'macd_hist',
        'ma_20',
        'ma_50',
        'ma_100',
        'ma_200',
        'rsi',
        'cci',
        'atr',
        'sts',
        'williams_r'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'date' => 'timestamp',
        'open' => 'float',
        'high' => 'float',
        'low' => 'float',
        'close' => 'float',
        'value' => 'float',
        'alma' => 'float',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getRiskAttribute()
    {
        // commission = 1.195
        return $this->low > $this->alma
            ? number_format(($this->close - $this->alma) / $this->close * 100 + 1.195, 2)
            : '-';
    }
}
