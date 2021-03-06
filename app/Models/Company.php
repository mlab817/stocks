<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class Company extends Model
{
    use HasFactory;
    use Searchable;

    public bool $asYouType = false;

    protected $fillable = [
        'name',
        'symbol',
        'listing_date',
        'psei',
        'active',
        'last_price_date',
    ];

    public function getRouteKeyName(): string
    {
        return 'symbol'; // TODO: Change the autogenerated stub
    }

    public static function findBySymbol($symbol = '')
    {
        return static::where('symbol', strtoupper($symbol))->firstOrFail();
    }

    public function market_statistics(): HasMany
    {
        return $this->hasMany(MarketStatistic::class);
    }

    public function market_statistic(): HasOne
    {
        return $this->hasOne(MarketStatistic::class)
            ->latestOfMany('year');
    }

    public function subsector(): BelongsTo
    {
        return $this->belongsTo(Subsector::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(HistoricalPrice::class);
//            ->orderBy('date','ASC');
    }

    public function latest_price(): HasOne
    {
        return $this->hasOne(HistoricalPrice::class)
            ->latestOfMany('date');
    }

    public function other_information(): HasOne
    {
        return $this->hasOne(OtherInformation::class);
    }

    public function getLatestVolumeAttribute()
    {
        return $this->latest_price
            ? $this->latest_price->volume
            : 0;
    }

    public function getTradedSharesAttribute()
    {
        return $this->other_information
            ? floatval($this->other_information->free_float_level) / 100 * $this->other_information->outstanding_shares
            : 0;

    }

    public function getOutstandingSharesAttribute()
    {
        return $this->other_information
            ? $this->other_information->outstanding_shares
            : 0;
    }

    public function getPctTradedAttribute()
    {
        return  $this->outstanding_shares > 0
            ? $this->latest_volume /  $this->outstanding_shares * 100
            : 0;
    }

    public function getLastTradedDateAttribute()
    {
        return $this->latest_price
            ? $this->latest_price->date
            : '';
    }

    public function scopeActive($query)
    {
        $query->where('active', true);
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array['subsector'] = $this->subsector ? $this->subsector->label: '';
        $array['sector'] = $this->subsector ? $this->subsector->sector->label: '';

        return $array;
    }
}
