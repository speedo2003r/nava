<?php

namespace App\Http\Requests\Api\Contact;

use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContactRequest extends FormRequest
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
            'name'    => 'required|max:191',
            'email'   => 'required|email|max:191',
            'message' => 'required',
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
    }

    protected function failedValidation(Validator $validator)
    {
        //$errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException($this->ApiResponse('fail',$validator->errors()->first()));
    }
}
