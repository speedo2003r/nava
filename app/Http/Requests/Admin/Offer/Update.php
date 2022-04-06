<?php

namespace App\Http\Requests\Admin\Offer;

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
            'expire_date'  => 'required',
            'description'  => 'required',
            'image'  => 'sometimes',
        ];
    }
}
