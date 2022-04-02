<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=> 'required|max:191',
            'phone'     => 'required|numeric|unique:users,phone,NULL,id,deleted_at,NULL',
            'email'     => 'required|email|max:191|unique:users,email,NULL,id,deleted_at,NULL',
            'password'  => 'required|max:191',
            'image'    => 'nullable|mimes:jpeg,jpg,png',
            'role_id'   => 'required|exists:roles,id',
        ];
    }
}
