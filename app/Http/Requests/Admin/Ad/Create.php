<?php

namespace App\Http\Requests\Admin\Ad;

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
            'image' => 'required|mimes:jpg,jpeg,png',
            'file' => 'required|mimes:jpg,jpeg,png,avi,mp4,mov,mpg,mpeg,wmv,mkv,ogg',
            'title_ar'  => 'required|max:191',
            'title_en'  => 'required|max:191',
            'user_id'  => 'required|exists:users,id',
            'phone'  => 'required|numeric',
            'whatsapp'  => 'required|numeric',
            'desc_ar'  => 'required|string',
            'desc_en'  => 'required|string',
            'end_date'  => 'required|after:yesterday',
        ];
    }
}
