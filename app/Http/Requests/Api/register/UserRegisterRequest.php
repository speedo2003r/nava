<?php

namespace App\Http\Requests\Api\register;

use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class UserRegisterRequest extends FormRequest
{
    use ResponseTrait;
    public function __construct(Request $request)
    {
        $request['v_code']     = generateCode();
        $request['user_type']  = 'client';
        $request['lang']       = 'ar';
        $request['role_id']    = null;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'       => 'required|min:2|max:191',
            'phone'      => 'required|numeric|digits_between:9,13|unique:users,phone,NULL,id,deleted_at,NULL',
            'email'      => 'nullable|email|max:191|unique:users,email,NULL,id,deleted_at,NULL',
            'password'   => 'required|min:6|max:255',
            'v_code'     => 'nullable',
            'user_type'  => 'nullable',
            'lang'       => 'nullable',
            'role_id'    => 'nullable',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function filters()
    {
        return [
            //'email' => 'trim|lowercase',
            //'name'  => 'trim|capitalize|escape'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            //if(isset($request['type']) && $request['type'] == 'user') $request['admin_activation'] = 1;
        });
    }

    protected function failedValidation(Validator $validator)
    {
        // $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException($this->ApiResponse('fail',$validator->errors()->first()));
    }
}
