<?php

namespace App\Http\Requests\Admin\Client;

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
            'password'   => 'nullable|max:191|confirmed',
            'image'      => 'nullable|image|mimes:jpeg,jpg,png',
            'address'    => 'required',
            'lat'   => 'required',
            'lng'   => 'required',
        ];
    }
}
