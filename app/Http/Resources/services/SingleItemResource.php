<?php

namespace App\Http\Resources\Items;

use App\Entities\Favourite;
use App\Entities\Feature;
use App\Entities\FeatureOption;
use App\Entities\Group;
use App\Entities\Item;
use App\Entities\Specification;
use App\Http\Resources\Branches\BranchFeatureResource;
use App\Http\Resources\Settings\ImageResource;
use App\Http\Resources\Users\AddressResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class SingleItemResource extends JsonResource
{
    protected $group;
    public function toArray($request)
    {
        $check = $this['type'] == 'single' ? 1 : 2;
        $checkDate = false;
        if(isset($request['group_id'])){
            $this->group = Group::find($request['group_id']);
        }elseif($check == 1){
            $this->group =  $this->groups()->where('properties',null)->first();
        }elseif ($check == 2){
            $this->group =  $this->groups()->where('properties','!=',null)->first();
        }
        if(auth()->check()){
            $fav = Favourite::subgroupexist()->where('user_id',auth()->id())->where('favoritable_id',$this->group['id'])->where('favoritable_type',Group::class)->first();
            $checkfav = $fav != null ? true : false;
        }else{
            $fav = Favourite::subgroupexist()->where('uuid',$request['uuid'])->where('user_id',null)->where('favoritable_id',$this->group['id'])->where('favoritable_type',Group::class)->first();
            $checkfav = $fav != null ? true : false;
        }
        $tax = ($this->group['price'] * settings('tax') ?? 0) / 100;
        if($this->group != null){
            $from = $this->group['from'];
            $to = $this->group['to'];
            if($from != null && $to != null){
                $from = Carbon::parse($this->group['from']);
                $to = Carbon::parse($this->group['to']);
                $now = Carbon::now();
                $checkDate = $now->between($from,$to);
            }
            $discount = ($this->group['discount_price'] != null && $checkDate) ? ($this->group['price'] * $this->group['discount_price'] / 100) : 0;
        }
        $branch = $this->branches()->where('branches.city_id',$request['city_id'])->first();
        return [
            'id'              => $this->id,
            'group_id'        => $this->group['id'],
            'branch_id'        => $this->group ? ($branch ? $branch['id'] : '') : '',
            'category_title'  => $this->subcategory['title'],
            'title'           => $check == 1 ? $this->title ?? '' : $this->group['title'] ?? '',
            'main_price'      => $this->group['price'] + $tax,
            'discount_price'  => $check == 1 ? ($this->price() != $this->group['price'] ? ($this->price() + $tax) : 0) : (($checkDate && $discount > 0) ? ($this->group['price'] - $discount) + $tax : 0),
            'count'        => $this->group['count'],
            'discount'        => $discount,
            'discount_percent'=> $discount > 0 ? $this->group['discount_price'].'%' : 0,
            'currency'        => app()->getLocale() == 'ar'? 'ر.س' : 'SAR',
            'images'          => $check == 1 ? ImageResource::collection($this->files) :  ImageResource::collection($this->group->images),
            'coupon_code'        => $this->coupon['code'] ?? '',
            'coupon_value'        => $this->coupon['value'] ?? '',
            'coupon_count'        => $this->coupon['count'] ?? '',
            'favorite'        => $checkfav,
            'warranty'        => $this['warranty'] ?? '',
            'provider'        => $this->user->provider['store_name'] ?? '',
            'reclaim'         => $this->reclaim == 1 ? true : false,
            'free_ship'         => $branch['free_ship'] == 1 ? true : false,
            'groups'          => $check == 2 ? $this->groupCollection($this->features) : [],
            'desc'            => $check == 1 ? $this->description ?? '' : $this->group['description'] ?? '',
            'details'         => $this->detailsCollection($this->details) ?? [],
            'rating'          => $this->ratingCollection() ?? [],
            'countRating'     => DB::table('rating')->where('rateable_type',Group::class)->where('rateable_id',$this->group['id'])->sum('followers'),
            'ratePercent'     => $this->ratePercent(),
            'addToCartBtn'       => $this->type == 'single' ? $this->whereHas('groups',function ($groupValue){
                $groupValue->checkGroup();
            })->exists() : $this->whereHas('groups',function ($groupValue){
                $groupValue->checkGroup();
                $groupValue->where('id',$this->group['id']);
                $groupValue->whereHas('children');
            })->exists(),
            'branchFeatures' => [
                [
                    'feature' => 'ship',
                    'desc' => $branch->features()->where('status',1)->where('feature','ship')->exists() ? $branch->features()->where('status',1)->where('feature','ship')->first()['desc'] : ''
                ],
                [
                    'feature' => 'return',
                    'desc' => $branch->features()->where('status',1)->where('feature','return')->exists() ? $branch->features()->where('status',1)->where('feature','return')->first()['desc'] : ''
                ],
                [
                    'feature' => 'shop',
                    'desc' => $branch->features()->where('status',1)->where('feature','shop')->exists() ? $branch->features()->where('status',1)->where('feature','shop')->first()['desc'] : ''
                ],
            ],
        ];
    }
    protected function getFeatures(){

    }
    protected function ratePercent(){
        $review = 0;
        $sum = (int) DB::table('rating')->where('rateable_type',Group::class)->where('rateable_id',$this->group['id'])->sum('followers');
        $rate = (int) DB::table('rating')->where('rateable_type',Group::class)->where('rateable_id',$this->group['id'])->sum('rate');
        if($rate > 0){
            $review = $rate / $sum;
        }
        return $review;

    }
    protected function ratingCollection(){
        $group = $this->group;
        $count = DB::table('rating')->where('rateable_type',Group::class)->where('rateable_id',$group['id'])->count();
        $arr = [
            [
                'rate' => 1,
                'count' => rateCount($group,1),
                'percent' => rateCount($group,1) > 0 ? (string) round((rateCount($group,1) / $count) * 100,1) : 0,
            ],
            [
                'rate' => 2,
                'count' => rateCount($group,2),
                'percent' => rateCount($group,2) > 0 ? (string) round((rateCount($group,2) / $count) * 100,1) : 0,
            ],
            [
                'rate' => 3,
                'count' => rateCount($group,3),
                'percent' => rateCount($group,3) > 0 ? (string) round((rateCount($group,3) / $count) * 100,1) : 0,
            ],
            [
                'rate' => 4,
                'count' => rateCount($group,4),
                'percent' => rateCount($group,4) > 0 ? (string) round((rateCount($group,4) / $count) * 100,1) : 0,
            ],
            [
                'rate' => 5,
                'count' => rateCount($group,5),
                'percent' => rateCount($group,5) > 0 ? (string) round((rateCount($group,5) / $count) * 100,1) : 0,
            ]
        ];
        return $arr;
    }
    protected function detailsCollection($details)
    {
        $detailsGroups = null;
        $details = $details->where('type','item');
        $group = $this->group->where('id',request()['group_id'])->first();
        if(isset(request()['group_id']) && $this->group != null && $group != null && count($group->details) > 0){
            $detailsGroups = $group->details;
        }
        $ar1 = $details->groupBy('specification_id',true)->toArray();
        if($this->group->item['type'] == 'single'){
            $data = collect($ar1)->map(function ($row,$index){
                return [
                    'id' => $index,
                    'key' => Specification::find($index)['title'],
                    'value' => reset($row)['title']['ar']
                ];
            });
            return $data->toArray();
        }elseif($this->group->item['type'] == 'multiple'){
            if($detailsGroups != null){
                $ar2 = $detailsGroups->groupBy('specification_id',true)->toArray();
                $new_array = array_replace($ar1,$ar2);
                $data = collect($new_array)->map(function ($row,$index){
                    return [
                        'id' => $index,
                        'key' => Specification::find($index)['title'],
                        'value' => reset($row)['title']['ar']
                    ];
                });
                return $data->toArray();
            }

        }
    }

//    protected function groupCollection($groups,$products)
    protected function groupCollection($products)
    {
        $group = $products->groupBy('feature_id');
        $groupModel = $this->group;
        $select_id = FeatureOption::find($groupModel->children()->first()['id'])->groups()->pluck('groups.id')->toArray();
        $firstFeature = FeatureOption::find($groupModel->children()->first()['id'])->feature;
        $array = $groupModel->children->pluck('id')->toArray();
        $item = Item::find(request()['item_id']);
        $data = $group->map(function ($row,$index) use ($array,$item,$firstFeature,$select_id){
            $title = Feature::find($index)['title'];
            $ids = $row->pluck('id')->toArray();
            $data = FeatureOption::whereIn('id',$ids)->whereHas('groups')->get();
            return [
                'id' => $index,
                'title' => Feature::find($index)['title'],
                'options' => $data->map(function ($query) use ($array,$item,$title,$firstFeature,$select_id) {
                    $check = $item->whereHas('groups',function ($groupValue) use ($query){
                        $groupValue->checkGroup();
                        $groupValue->whereHas('children',function ($value) use ($query){
                            $value->where('feature_options.id',$query['id']);
                        });
                    })->exists();
                    $check2 = $item->whereHas('groups',function ($groupValue) use ($query){
                        $groupValue->where('id',$this->group['id']);
                        $groupValue->checkGroup();
                        $groupValue->whereHas('children',function ($value) use ($query){
                            $value->where('feature_options.id',$query['id']);
                        });
                    })->exists();
                    $check3 =  Group::checkGroup()->whereIn('groups.id',$select_id)->whereHas('children',function ($value) use ($query,$firstFeature,$select_id){
                        $value->where('feature_options.id',$query['id']);
                        $value->where('feature_options.feature_id','!=',$firstFeature['id']);
                    })->exists();
                    return [
                        'id'=>$query['id'],
                        'title'=>$query['title'],
                        'feature'=>$title,
                        'type'=>$query['type'],
                        'image'=>$query['type'] == 'image' ? $query['image'] : '',
                        'selected'=> in_array($query['id'],$array) && $check && $check2,
                        'visibility'=> $query['feature_id'] == $firstFeature['id'] ? $check : $check && $check3,
                    ];
                })
            ];
        });
        return $data->toArray();
    }
}
