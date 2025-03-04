<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class GenerateReportRequest extends FormRequest
{

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'date' => 'required|date_format:Y-m-d',
        ];
    }
}
