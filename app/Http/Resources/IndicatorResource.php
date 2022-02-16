<?php

namespace App\Http\Resources;

use App\Models\HistoricalPrice;
use Illuminate\Http\Resources\Json\JsonResource;

class IndicatorResource extends JsonResource
{
    public $resource = HistoricalPrice::class;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'date' => $this->date,
            'alma' => $this->alma,
            'macd' => $this->macd,
            'macd_signal' => $this->macd_signal,
            'macd_hist' => $this->macd_hist,
            'ma_20' => $this->ma_20,
            'ma_50' => $this->ma_50,
            'ma_100' => $this->ma_100,
            'ma_200' => $this->ma_200,
            'rsi' => $this->rsi,
            'cci' => $this->cci,
            'atr' => $this->atr,
            'sts' => $this->sts,
            'williams_r' => $this->williams_r,
            'trix' => $this->trix,
            'psar' => $this->psar,
            'ema_9' => $this->ema_9,
        ];
    }
}
