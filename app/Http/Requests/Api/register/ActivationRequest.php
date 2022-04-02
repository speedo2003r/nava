<?php

namespace App\Http\Requests\Api\register;

use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ActivationRequest extends FormRequest
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
            'code'        => 'required|exists,users,v_code',
            'phone'       => 'required|exists:users,phone',
            'device_id'   => 'required',
            'device_type' => 'required:in,ios,android,web',
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
