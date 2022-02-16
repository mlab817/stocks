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
        'williams_r',
        'trix',
        'psar',
        'ema_9',
        'pct_change',
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
        'macd' => 'float',
        'macd_signal' => 'float',
        'macd_hist' => 'float',
        'ma_20' => 'float',
        'ma_50' => 'float',
        'ma_100' => 'float',
        'ma_200' => 'float',
        'rsi' => 'float',
        'cci' => 'float',
        'atr' => 'float',
        'sts' => 'float',
        'williams_r' => 'float',
        'trix' => 'float',
        'psar' => 'float',
        'ema_9' => 'float',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getAlmaBullishAttribute(): bool
    {
        return $this->low > $this->alma;
    }

    public function getMacdBullishAttribute(): bool
    {
        return $this->macd_hist > 0;
    }

    public function getRiskAttribute()
    {
        // commission = 1.195
        return $this->low > $this->alma
            ? number_format(($this->close - $this->alma) / $this->close * 100 + 1.195, 2)
            : '-';
    }

    public function getRiskBullishAttribute(): bool
    {
        return floatval($this->risk) < 5;
    }

    public function getValueBullishAttribute(): bool
    {
        return $this->value > 10 **6;
    }
}
