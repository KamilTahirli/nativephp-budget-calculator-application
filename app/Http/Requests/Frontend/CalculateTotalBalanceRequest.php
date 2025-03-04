<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class CalculateTotalBalanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'calculationDate' => 'required|date_format:Y-m-d',
            'type' => 'nullable|in:1,2'
        ];
    }
}
