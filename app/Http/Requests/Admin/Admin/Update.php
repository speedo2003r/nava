<?php

namespace App\Http\Requests\Admin\Admin;

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
            'name'      => 'required|max:191',
            'phone'     => "required|numeric|unique:users,phone,{$this->id},id,deleted_at,NULL",
            'email'     => "required|email|max:191|unique:users,email,{$this->id},id,deleted_at,NULL",
            'password'  => 'nullable|max:191',
            'image'    => 'nullable|mimes:jpeg,jpg,png',
            'role_id'   => 'required|exists:roles,id',
        ];
    }
}
