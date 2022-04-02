<?php

  namespace App\Http\Resources\Wallet;

  use Illuminate\Http\Resources\Json\JsonResource;

  class WalletResource extends JsonResource
  {
    public function toArray($request)
    {
      return [
        'id'       => $this->id,
        'user_id'  => $this->user_id,
        'dept'     => $this->dept,
        'credit'   => $this->credit,
        'amount'   => $this->dept > 0 ? -$this->dept: $this->credit,
        'order_id' => $this->order_id??'',
        'notes'    => $this->notes,
        'type'     => $this->type,
      ];
    }
  }
