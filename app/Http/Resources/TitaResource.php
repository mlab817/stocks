<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TitaResource extends JsonResource
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
            'alma'  => $this->alma,
            'candle' => $this->candle,
            'rsi' => $this->rsi,
            'alma_dir' => $this->alma_dir,
            'rsi_dir' => $this->rsi_dir,
            'tita_signal' => $this->tita_signal,
            'risk' => $this->risk,
        ];
    }
}
