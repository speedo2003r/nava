<?php

namespace App\Http\Requests\Admin\Company;

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
            'name' => 'required|max:191',
            'phone'      => 'required|numeric|digits_between:9,13|unique:users,phone,'.$this->id.',id,deleted_at,NULL',
            'email'      => 'required|email|max:191|unique:users,email,'.$this->id.',id,deleted_at,NULL',
            'password'   => 'required|max:191',
            'image'      => 'nullable|mimes:jpeg,jpg,png',
            'country_id'    => 'required|exists:countries,id,deleted_at,NULL',
            'city_id'    => 'required|exists:cities,id,deleted_at,NULL',
            'address'    => 'required',
            'lat'    => 'required',
            'lng'    => 'required',
            'id_number'    => 'required',
        ];
    }
}
