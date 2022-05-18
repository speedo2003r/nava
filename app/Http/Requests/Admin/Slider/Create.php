<?php

namespace App\Http\Requests\Admin\Slider;

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
            'title' => 'required|max:191',
            'image'  => 'required|mimes:jpg,jpeg,png',
            'category_id'  => 'required|exists:categories,id,deleted_at,NULL',
            'sub_category_id'  => 'required|exists:categories,id,deleted_at,NULL',
        ];
    }
}
