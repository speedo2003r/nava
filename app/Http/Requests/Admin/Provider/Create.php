<?php

namespace App\Http\Requests\Admin\Provider;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class Create extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function __construct(Request $request)
    {
        $request['active'] = 1;
    }
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
            'name' => 'required|max:191',
            'phone'      => 'required|numeric|digits_between:9,13|unique:users,phone,NULL,id,deleted_at,NULL',
            'email'      => 'required|email|max:191|unique:users,email,NULL,id,deleted_at,NULL',
            'password'   => 'required|max:191',
            'category_id'   => 'required|exists:categories,id',
            'image'      => 'nullable|mimes:jpeg,jpg,png',
            'address'    => 'required',
            'lat'        => 'required',
            'lng'        => 'required',
        ];
    }
}
