<?php

namespace App\Http\Requests\Admin\City;

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
            'country_id'  => 'required|exists:countries,id,deleted_at,NULL',
        ];
    }
}
