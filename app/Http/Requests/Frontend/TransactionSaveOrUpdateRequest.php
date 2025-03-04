<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class TransactionSaveOrUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'categoryId' => 'required|exists:categories,id',
            'amount'      => 'required|numeric',
            'memo'        => 'nullable',
            'date'        => 'required|date_format:Y-m-d H:i'
        ];
    }
}
