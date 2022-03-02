<?php

namespace App\Http\Requests;

use App\Models\Trade;
use Illuminate\Foundation\Http\FormRequest;

class TradeRequest extends FormRequest
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

    public function prepareForValidation()
    {
        $this->merge([
            'trade_type' => strtolower($this->trade_type),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'trade_type' => 'required|in:' . implode(',',Trade::TRADE_TYPES),
            'company_id' => 'required|exists:companies,id',
            'date' => 'required|date',
            'shares' => 'required|int',
            'price' => 'required|numeric',
            'target_price' => 'nullable|numeric',
            'cut_loss' => 'nullable|numeric',
            'remarks' => 'nullable',
        ];
    }
}
