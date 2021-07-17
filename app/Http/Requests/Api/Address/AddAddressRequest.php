<?php

namespace App\Http\Requests\Api\Address;

use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AddAddressRequest extends FormRequest
{
  use ResponseTrait;
  public function __construct(Request $request)
  {
    $request['user_id'] = auth()->id();
  }

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'name'     => 'required|max:191',
      'user_id'  => 'required|exists:users,id',
      'city_id'  => 'required|exists:cities,id',
      'lat'      => 'required|max:191',
      'lng'      => 'required|max:191',
      'map_desc' => 'required|max:255',
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
    throw new HttpResponseException($this->ApiResponse('fail', $validator->errors()->first()));
  }
}
