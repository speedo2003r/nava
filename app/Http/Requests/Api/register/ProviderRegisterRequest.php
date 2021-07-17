<?php

namespace App\Http\Requests\Api\register;

use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ProviderRegisterRequest extends FormRequest
{
  use ResponseTrait;
  public function __construct(Request $request)
  {
    $request['v_code']     = generateCode();
    $request['user_type']  = User::PROVIDER;
    $request['lang']       = 'ar';
    $request['role_id']    = null;
    $request['accepted']   = false; // need admin approved
    $request['first_name'] = $request['name'];
  }

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'name'       => 'required|min:4|max:191',
      'phone'      => 'required|numeric|unique:users,phone',
      'email'      => 'required|email|max:191|unique:users,email',
      'country_id' => 'required|exists:countries,id',
      'city_id'    => 'required|exists:cities,id',
      'password'   => 'required|min:6|max:255',
      'v_code'     => 'nullable',
      'user_type'  => 'nullable',
      'lang'       => 'nullable',
      'role_id'    => 'nullable',
      'first_name' => 'nullable',
      'accepted'   => 'nullable',
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
    throw new HttpResponseException($this->ApiResponse('fail', $validator->errors()->first()));
  }
}
