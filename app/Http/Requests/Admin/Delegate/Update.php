<?php

namespace App\Http\Requests\Admin\Delegate;

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
            'image'      => 'required|mimes:jpeg,jpg,png',
            'city_id'    => 'required',
            'address'    => 'required',
            'id_number'    => 'required',
            'active'     => 'nullable|in:1,0',
        ];
    }
}
