<?php

namespace App\Http\Requests\Admin\Slider;

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
            'title_ar' => 'required|max:191',
            'title_en'  => 'required|max:191',
            'image'  => 'sometimes|mimes:jpg,jpeg,png',
        ];
    }
}
