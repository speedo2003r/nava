<?php

namespace App\Http\Controllers\Api\Client\Cart;

use App\Entities\Category;
use App\Http\Controllers\Api\Client\Cart\pipline\CheckIfExist;
use App\Http\Controllers\Api\Client\Cart\pipline\SendToResponse;
use App\Http\Controllers\Api\Client\Cart\pipline\StoreCart;
use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Validator;

class AddToCart extends Controller
{
    use ResponseTrait;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if($request['service_id'] > 0){
            $validator = Validator::make($request->all(), [
                'service_id' => 'sometimes|exists:services,id,deleted_at,NULL',
            ]);
            if ($validator->fails()) {
                return $this->ApiResponse('fail', $validator->errors()->first());
            }
        }
        $validator = Validator::make($request->all(), [
            'uuid' => 'required',
            'city_id' => 'required|exists:cities,id,deleted_at,NULL',
            'category_id' => 'required|exists:categories,id,deleted_at,NULL',
            'counter' => 'required|in:up,down',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $pipeline = [
            CheckIfExist::class,
            StoreCart::class,
            SendToResponse::class,
        ];
        $data = $request->all();
        $cart = app(Pipeline::class)->send($data)->through($pipeline)->thenReturn();
        return $cart;
    }
}
