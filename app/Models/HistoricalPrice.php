<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class HistoricalPrice extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const NEUTRAL    = 'neutral';
    public const BULLISH    = 'bullish';
    public const BEARISH    = 'bearish';
    public const BUY        = 'buy';
    public const SELL       = 'sell';
    public const WATCH      = 'watch';
    public const HOLD       = 'hold';

    protected $touches = ['company'];

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
        'lag_macd_hist',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
//        'date' => 'timestamp',
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
        'lag_macd_hist' => 'float',
        'pct_change' => 'float',
    ];

//    protected $appends = [
//        'candle',
//        'alma_direction',
//        'macd_direction',
//        'risk',
//        'recommendation',
//    ];

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function indicator(): HasOne
    {
        return $this->hasOne(Indicator::class);
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
        return $this->close > 0
            ? ($this->close - $this->alma) / $this->close * 100 + 1.195
            : 0;
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

    public function getCandleAttribute(): string
    {
        if ($this->open > $this->close) {
            return self::BEARISH;
        }

        if ($this->close > $this->open) {
            return self::BULLISH;
        }

        return self::NEUTRAL;
    }

    public function getAlmaDirectionAttribute(): string
    {
        if ($this->alma < $this->low) {
            return self::BULLISH;
        }

        if ($this->alma > $this->high) {
            return self::BEARISH;
        }

        if ($this->alma > $this->low && $this->alma < $this->high) {
            return $this->candle;
        }

        return self::NEUTRAL;
    }

    public function getTrixDirectionAttribute()
    {
        $current = $this->trix;
        $lagged = $this->lag_trix;

        if (($lagged < 0 && $current == 0.0) || ($lagged < 0.0 && $current > 0.0)) {
            return self::BULLISH;
        }

        if (($lagged > 0.0 && $current == 0.0) || ($lagged > 0.0 && $current < 0)) {
            return self::BEARISH;
        }

        return self::NEUTRAL;

    }

    public function getMacdDirectionAttribute(): string
    {
        $current    = $this->macd_hist;
        $lagged     = $this->lag_macd_hist;

        // three possible scenarios for bullish
        if (($lagged < 0 && $current == 0.0) || ($lagged < 0.0 && $current > 0.0)) {
            return self::BULLISH;
        }

        if (($lagged > 0.0 && $current == 0.0) || ($lagged > 0.0 && $current < 0)) {
            return self::BEARISH;
        }

        return self::NEUTRAL;
    }

    public function getRecommendationAttribute(): string
    {
        if ($this->alma_direction == self::BULLISH && $this->macd_direction == self::BULLISH) {
            return self::BUY;
        }

        if ($this->alma_direction == self::BEARISH && $this->macd_direction == self::BEARISH) {
            return self::SELL;
        }

        return self::HOLD;
    }
}
