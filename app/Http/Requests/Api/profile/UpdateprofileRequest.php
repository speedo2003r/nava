<?php

namespace App\Http\Requests\Api\profile;

use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class UpdateProfileRequest extends FormRequest
{
    use ResponseTrait;
    public $user;
    public function __construct(Request $request)
    {
        $this->user = auth()->user();
        $request['phone'] ? $request['phone'] = convert_to_english($request['phone']) : '';
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'      => 'required',
            'phone'      => 'required|numeric|unique:users,phone,'. $this->user['id'].',id,deleted_at,NULL',
            'email'      => 'required|email|max:191|unique:users,email,'. $this->user['id'].',id,deleted_at,NULL',
        ];
    }

    public function messages()
    {
        return [

        ];
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
            if ($this->has('old_password') && !Hash::check($this->old_password, $this->user->password)) {
                $validator->errors()->add('old_password', trans('api.wrongPassword'));
            }
        });
    }

    protected function failedValidation(Validator $validator)
    {
        //$errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException($this->ApiResponse('fail', $validator->errors()->first()));
    }
}
