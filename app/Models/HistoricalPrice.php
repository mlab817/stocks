<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricalPrice extends Model
{
    use HasFactory;

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

    public function getRiskAttribute(): float
    {
        return number_format(($this->close - $this->alma) / $this->close * 100, 2);
    }
}
