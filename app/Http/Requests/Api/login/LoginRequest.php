<?php

namespace App\Http\Requests\Api\login;

use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class LoginRequest extends FormRequest
{
    use ResponseTrait;
    public function __construct(Request $request)
    {
        //
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'uuid'       => 'required',
            'phone'       => 'required|exists:users,phone,deleted_at,NULL',
            'password'    => 'required|string|max:100',
            'device_id'   => 'required|max:200',
            'device_type' => 'required|in:android,ios,web',
            //'app_type'    => 'required|in:provider,user',
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
            //
        });
    }

    protected function failedValidation(Validator $validator)
    {
        //$errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException($this->ApiResponse('fail', $validator->errors()->first()));
    }
}
