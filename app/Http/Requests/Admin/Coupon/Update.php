<?php

namespace App\Http\Requests\Admin\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
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
