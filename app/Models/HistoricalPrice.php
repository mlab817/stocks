<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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

    public function getAlmaCrossAttribute(): bool
    {
        return $this->open <= $this->alma
            && $this->close > $this->alma;
    }

    public function getMacdBullishAttribute(): bool
    {
        $pct = $this->macd > 0
            ? $this->macd_hist / $this->macd
            : 0;

        return abs($pct) <= 0.10;
    }

    public function getRiskAttribute()
    {
        // commission = 1.195
        return number_format(($this->close - $this->alma) / $this->close * 100 + 1.195, 2);
    }

    public function getMamaAttribute(): bool
    {
        // alma cross or alma bullish && macd_hist between 0.01
        return ($this->alma_cross || $this->alma_bullish)
            && $this->macd_bullish;
    }

    public function getRiskBullishAttribute(): bool
    {
        return floatval($this->risk) < 5;
    }

    public function getValueBullishAttribute(): bool
    {
        return $this->value > 10 **6;
    }

    public function getVolumeAttribute(): int
    {
        return $this->close > 0
            ? round($this->value / $this->close, 0)
            : 0;
    }

    public function getMacdDirectionAttribute(): string
    {
        $current = $this->macd_hist;
        $lagged = $this->lag_macd_hist;

        if ($current <= 0 && $lagged >= 0) {
            return 'bearish cross';
        }

        if ($lagged <= 0 && $current >= 0) {
            return 'bullish cross';
        }

        return 'neutral';
    }

    public function getRecommendationAttribute(): string
    {
        if ($this->alma_bullish && $this->macd_direction == 'bullish cross' && $this->risk < 5) {
            return 'buy';
        }

        return 'watch';
    }
}
