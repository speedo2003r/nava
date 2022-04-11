<?php

namespace App\Http\Controllers\Api\Client\Cart;

use App\Entities\Order;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class addNotesAndImage extends Controller
{
    use ResponseTrait;
    use UploadTrait;

    public function __construct(protected OrderRepository $orderRepo)
    {

    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
            'notes' => 'nullable|string|max:2000',
            'image' => 'sometimes|image|mimes:jpg,jpeg,png,svg|max:500000',
            'audio' => 'sometimes|max:500000',
            'video' => 'sometimes|max:500000',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        $order->notes = $request['notes'];
        $order->save();
        if($request->has('image') && $request['image'] != null){
            if($order->files()->where('media_type','image')->count() > 0){
                foreach ($order->files()->where('media_type','image')->get() as $file){
                    $file->delete();
                }
            }
            $order->files()->create([
                'media_type' => 'image',
                'image' => $this->uploadFile($request['image'],'orders'),
                'image_id' => $request['order_id'],
                'image_type' => Order::class,
            ]);
        }
        if($request->has('audio') && $request['audio'] != null){
            if($order->files()->where('media_type','audio')->count() > 0){
                foreach ($order->files()->where('media_type','audio')->get() as $file){
                    $file->delete();
                }
            }
            $order->files()->create([
                'media_type' => 'audio',
                'image' => $this->uploadFile($request['audio'],'orders'),
                'image_id' => $request['order_id'],
                'image_type' => Order::class,
            ]);
        }
        if($request->has('video') && $request['video'] != null){
            if($order->files()->where('media_type','video')->count() > 0){
                foreach ($order->files()->where('media_type','video')->get() as $file){
                    $file->delete();
                }
            }
            $order->files()->create([
                'media_type' => 'video',
                'image' => $this->uploadFile($request['video'],'orders'),
                'image_id' => $request['order_id'],
                'image_type' => Order::class,
            ]);
        }
        return $this->successResponse();
    }
}
