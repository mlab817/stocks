<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoricalPriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'symbol' => $this->company->symbol,
            'date'  => $this->date,
            'open'  => $this->open,
            'high'  => $this->high,
            'low'   => $this->low,
            'close' => $this->close,
            'value' => $this->value,
            'candle' => $this->candle,
            'alma' => $this->alma,
            'alma_dir' => $this->alma_dir,
            'macd_dir' => $this->macd_dir,
            'mama_signal' => intval($this->mama_signal),
            'risk' => $this->risk,
        ];
    }
}
