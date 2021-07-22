<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\Create;
use App\Http\Requests\Admin\Coupon\Update;
use App\Repositories\CouponRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected $couponRepo,$userRepo;

    public function __construct(CouponRepository $coupon,UserRepository $user)
    {
        $this->couponRepo = $coupon;
        $this->userRepo = $user;
    }

    /***************************  get all providers  **************************/
    public function index()
    {
        $coupons = $this->couponRepo->findWhere(['type'=>'public']);
        $providers = $this->userRepo->findWhere(['user_type'=>'provider']);
        return view('admin.coupons.index', compact('coupons','providers'));
    }


    /***************************  store provider **************************/
    public function store(Create $request)
    {
        $data = array_filter($request->all());
        $data['type'] = 'public';
        $this->couponRepo->create($data);
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }


    /***************************  update provider  **************************/
    public function update(Update $request, $id)
    {
        $coupon = $this->couponRepo->findOrFail($id);
        $this->couponRepo->update(array_filter($request->all()),$coupon['id']);
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }

    /***************************  delete provider  **************************/
    public function destroy(Request $request,$id)
    {
        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $role = $this->couponRepo->find($d);
                    $this->couponRepo->delete($role['id']);
                }
            }
        }else {
            $role = $this->couponRepo->find($id);
            $this->couponRepo->delete($role['id']);
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

}
