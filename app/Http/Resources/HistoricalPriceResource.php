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
            'date'  => $this->date,
            'open'  => $this->open,
            'high'  => $this->high,
            'low'   => $this->low,
            'close' => $this->close,
            'value' => $this->value,
            'alma_dir' => $this->alma_dir,
            'macd_dir' => $this->macd_dir,
            'recom' => $this->recom,
            'risk' => $this->risk,
        ];
    }
}
