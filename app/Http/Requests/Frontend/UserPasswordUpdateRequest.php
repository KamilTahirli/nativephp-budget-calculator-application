<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class UserPasswordUpdateRequest extends FormRequest
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
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required'
        ];
    }
}
