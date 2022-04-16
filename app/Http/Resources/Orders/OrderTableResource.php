<?php

namespace App\Http\Resources\Orders;

use App\Entities\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderTableResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_num' => $this->order_num ?? '',
            'category' => $this->category ? $this->category['title'] : '',
            'added' => $this->income ? $this->income['income'] : 0,
            'deduction' => count($this->userDeductions) > 0 ? $this->userDeductions()->sum('balance') : 0,
            'balance' => ($this->income['income'] ?? 0) - ($this->userDeductions()->sum('balance') ?? 0),
        ];
    }

}
