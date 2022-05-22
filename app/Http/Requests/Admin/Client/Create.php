<?php

namespace App\Http\Requests\Admin\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

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
    public function rules(Request $request)
    {
        return [
            'name' => 'required|max:191',
            'phone'      => 'required|numeric|digits_between:9,13|unique:users,phone,NULL,id,deleted_at,NULL',
            'email'      => 'required|email|max:191|unique:users,email,NULL,id,deleted_at,NULL',
            'image'      => 'nullable|image|mimes:jpeg,jpg,png',
            'address'    => 'required',
            'lat'   => 'required',
            'lng'   => 'required',
        ];
    }
}
