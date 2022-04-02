<?php

namespace App\Http\Requests\Admin\Coupon;

use Illuminate\Foundation\Http\FormRequest;

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
    public function rules()
    {
        return [
            'code'  => 'required',
            'kind'  => 'required',
            'count'  => 'required',
            'value'  => 'required',
            'start_date'  => 'required|before:end_date',
            'end_date'  => 'required|after:start_date',
        ];
    }
}
