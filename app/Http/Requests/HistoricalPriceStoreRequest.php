<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoricalPriceStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_id' => 'required|exists:companies,id',
            'date' => 'required|date',
            'open' => 'nullable|min:0',
            'high' => 'nullable|min:0',
            'low' => 'nullable|min:0',
            'close' => 'nullable|min:0',
            'value' => 'nullable|min:0',
            'alma'=> 'nullable|min:0',
            'macd'=> 'nullable|min:0',
            'macd_signal'=> 'nullable|min:0',
            'macd_hist'=> 'nullable|min:0',
            'ma_20'=> 'nullable|min:0',
            'ma_50'=> 'nullable|min:0',
            'ma_100'=> 'nullable|min:0',
            'ma_200'=> 'nullable|min:0',
            'rsi'=> 'nullable|min:0',
            'cci'=> 'nullable|min:0',
            'atr'=> 'nullable|min:0',
            'sts'=> 'nullable|min:0',
            'williams_r'=> 'nullable|min:0',
            'trix'=> 'nullable|min:0',
            'psar'=> 'nullable|min:0',
            'ema_9'=> 'nullable|min:0',
            'pct_change'=> 'nullable|min:0',
            'lag_macd_hist'=> 'nullable|min:0',
        ];
    }
}
