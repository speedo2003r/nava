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
            'title' => 'required|max:191',
            'image'  => 'sometimes|mimes:jpg,jpeg,png',
            'category_id'  => 'required|exists:categories,id,deleted_at,NULL',
            'sub_category_id'  => 'required|exists:categories,id,deleted_at,NULL',
        ];
    }
}
