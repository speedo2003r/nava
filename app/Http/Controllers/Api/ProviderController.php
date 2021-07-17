<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\services\ServiceCollection;
use App\Http\Resources\Users\SingleProviderResource;
use App\Http\Resources\Reviews\ReviewCollection;
use App\Models\User;
use App\Repositories\CategoryRepository;
use App\Repositories\SliderRepository;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class ProviderController extends Controller{
    use ResponseTrait;
    public $sliderRepo,$userRepo,$categoryRepo;
    public function __construct(CategoryRepository $category,SliderRepository $slider,UserRepository $user)
    {
        $this->sliderRepo = $slider;
        $this->userRepo = $user;
        $this->categoryRepo = $category;
    }

    public function singleProvider(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'provider_id' => ['required','exists:users,id'],
        ]);
        if($validator->fails())
            return $this->ApiResponse('fail',$validator->errors()->first());

        $provider = $this->userRepo->where('id',$request['provider_id'])->exist()->first();
        $reviews = $provider->reviews()->paginate(10);
        $services = $provider->services()->paginate(10);

        return $this->successResponse([
            'provider'=> $provider ? new SingleProviderResource($provider) : (object) [],
            'reviews'=> $provider ? new ReviewCollection($reviews) : (object) [],
            'services'=> $provider ? new ServiceCollection($services) : (object) [],

        ]);
    }
}
