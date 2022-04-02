<?php

namespace App\Http\Requests\Api;

use App\Traits\ResponseApi;
use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LangRequest extends FormRequest
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
            'lang'     => 'required',
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
            //$request['code'] = generateCode();
            //if(isset($request['type']) && $request['type'] == 'user') $request['admin_activation'] = 1;
        });

    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException($this->ApiResponse('fail',$validator->errors()->first() ));
    }
}
