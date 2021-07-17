<?php

namespace App\Http\Requests\Admin\Question;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'key_ar' => 'required|max:191',
            'key_en'  => 'required|max:191',
            'value_ar' => 'required',
            'value_en'  => 'required',
        ];
    }
}
