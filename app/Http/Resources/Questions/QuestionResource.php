<?php

namespace App\Http\Resources\Questions;

use App\Http\Resources\Items\ItemsResource;
use App\Http\Resources\Settings\BannerResource;
use Illuminate\Http\Resources\Json\JsonResource;
class QuestionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'question' => $this['key'] ?? '',
            'answer' => $this['value'] ?? '',
        ];
    }
}
