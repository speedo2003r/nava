<?php

namespace App\Http\Requests\Admin\Ad;

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
            'image' => 'nullable|mimes:jpg,jpeg,png',
            'file' => 'nullable|mimes:jpg,jpeg,png,avi,mp4,mov,mpg,mpeg,wmv,mkv,ogg',
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
