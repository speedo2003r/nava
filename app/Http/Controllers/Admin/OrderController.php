<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\GuaranteeDatatable;
use App\DataTables\OrderDatatable;
use App\Entities\OrderBill;
use App\Entities\OrderGuarantee;
use App\Entities\OrderPart;
use App\Entities\OrderService;
use App\Enum\OrderStatus;
use App\Enum\PayStatus;
use App\Http\Controllers\Controller;
use App\Notifications\Admin\AddInvoice;
use App\Notifications\Admin\UpdateInvoice;
use App\Notifications\Api\AssignDelegate;
use App\Repositories\OrderRepository;
use App\Repositories\OrderServiceRepository;
use App\Repositories\ServiceRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class OrderController extends Controller
{
    protected $orderRepo,$orderService;

    public function __construct(protected ServiceRepository $service,OrderServiceRepository $orderService,OrderRepository $order)
    {
        $this->orderRepo = $order;
        $this->orderService = $orderService;
        $this->service = $service;
    }

    /***************************  get all providers  **************************/
    public function index(OrderDatatable $orderDatatable)
    {
        return $orderDatatable->render('admin.orders.index');
    }

    public function guarantees(GuaranteeDatatable $datatable)
    {
        return $datatable->render('admin.orders.guarantee');
    }

    public function guaranteeShow($id)
    {
        $orderGuarantee = OrderGuarantee::find($id);
        $order = $orderGuarantee->order;
        return view('admin.orders.guaranteeShow',compact('order','id','orderGuarantee'));
    }

    public function guaranteeDestroy(Request $request,$id)
    {
        $user = auth()->user();
        if($user['user_type'] == 'operation'){
            return back()->with('danger','ليس لديك الصلاحيه للحذف');
        }
        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $role = OrderGuarantee::find($d);
                    $role->delete();
                }
            }
        }else {
            $role = OrderGuarantee::find($id);
            $role->delete();
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

    /***************************  update provider  **************************/
    public function show($id)
    {
        $order = $this->orderRepo->find($id);
        $timeLineStatus = $order->timeLineStatus;
        $category = $order->category;
        $services = $category->childServices;
        $bills = $order->bills()->whereDoesntHave('orderServices')->get();
        return view('admin.orders.show', compact('services','order','id','timeLineStatus','bills'));
    }

    /***************************  update provider  **************************/
    public function rejectOrder(Request $request)
    {
        $order = $this->orderRepo->find($request['order_id']);
        $this->orderRepo->update([
            'status' => OrderStatus::REJECTED
        ],$order['id']);
        $this->orderRepo->addStatusTimeLine($order['id'],OrderStatus::REJECTED);
        return back()->with('success','تم الرفض بنجاح');
    }

    public function billCreate(Request $request)
    {
        $this->validate($request,[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
            'service_id' => 'required|exists:services,id,deleted_at,NULL',
            'count' => 'required|numeric',
        ]);
        $order = $this->orderRepo->find($request['order_id']);
        if($order['pay_status'] == PayStatus::DONE){
            $msg = app()->getLocale() == 'ar' ? 'تم سداد الطلب بالفعل من قبل العميل': 'The order has already been paid by the customer';
            return back()->with('danger',$msg);
        }
        if($order['status'] == OrderStatus::FINISHED){
            $msg = app()->getLocale() == 'ar' ? 'تم الانتهاء من الطلب': 'The order has already been finished';
            return back()->with('danger',$msg);
        }

        $service = $this->service->find($request['service_id']);
        $tax = ($service['price'] * settings('tax')) / 100;
        $orderBill = OrderBill::create([
            'order_id'=>$order['id'],
            'vat_amount' => $tax,
            'price' => $service['price'],
            'type'=>'service',
            'status'=>0,
        ]);
        $orderBill->orderServices()->create([
            'title' => $service['title'],
            'type' => $service['type'],
            'status' => 0,
            'order_id' => $order['id'],
            'category_id' => $service['category_id'],
            'count' => $request['count'],
            'service_id' => $service['id'],
            'price' => $service['price'],
            'tax' => ($service['price'] * settings('tax') ?? 0) / 100,
        ]);
        $this->orderRepo->addBillStatusTimeLine($orderBill['id'],OrderStatus::NEWINVOICE);
        $user = $order->user;
        $user->notify(new AddInvoice($order,$orderBill));
        $msg = app()->getLocale() == 'ar' ? 'تم الاضافه بنجاح' : 'successfully add';
        return back()->with('success',$msg);
    }
    public function billUpdate(Request $request,$id)
    {
        $this->validate($request,[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
            'service_id' => 'required|exists:services,id,deleted_at,NULL',
            'count' => 'required|numeric',
        ]);
        $order = $this->orderRepo->find($request['order_id']);
        if($order['pay_status'] == PayStatus::DONE){
            $msg = app()->getLocale() == 'ar' ? 'تم سداد الطلب بالفعل من قبل العميل': 'The order has already been paid by the customer';
            return back()->with('danger',$msg);
        }
        if($order['status'] == OrderStatus::FINISHED){
            $msg = app()->getLocale() == 'ar' ? 'تم الانتهاء من الطلب': 'The order has already been finished';
            return back()->with('danger',$msg);
        }
        $service = $this->service->find($request['service_id']);
        $orderService = OrderService::find($id);
        $orderService->update([
            'title' => $service['title'],
            'type' => $service['type'],
            'count' => $request['count'],
            'order_id' => $order['id'],
            'category_id' => $service['category_id'],
            'service_id' => $service['id'],
            'price' => $service['price'],
            'tax' => ($service['price'] * settings('tax') ?? 0) / 100,
        ]);

        $orderBill = OrderBill::where('status',0)->where('order_id',$request['order_id'])->whereHas('orderServices',function ($q) use ($orderService){
            $q->where('order_services.id',$orderService['id']);
        })->first();
        if($orderBill) {
            $tax = 0;
            $amount = 0;
            foreach ($orderBill->orderServices()->where('order_services.status',0)->get() as $servs){
                $tax += $servs['tax'] * $servs['count'];
                $amount += $servs['price'] * $servs['count'];
            }
            if($amount > 0){
                if($orderBill['price'] != $amount){
                    $user = $order->user;
                    $user->notify(new UpdateInvoice($order,$orderBill));
                }
                $orderBill->update([
                    'vat_amount' => $tax,
                    'price' => $amount,
                ]);

                $this->orderRepo->addBillStatusTimeLine($orderBill['id'],OrderStatus::UPDATEINVOICE);
            }else{
                $orderBill->update([
                    'status' => 1,
                ]);
            }

        }
        $msg = app()->getLocale() == 'ar' ? 'تم التعديل بنجاح' : 'successfully edit';
        return back()->with('success',$msg);
    }
    /***************************  update provider  **************************/
    public function servicesDelete(Request $request)
    {

        if($request['bill_type'] == 'bill') {
            $orderBill = OrderBill::where('id', $request['order_service_id'])->first();
            $order = $orderBill->order;
            if($order['pay_status'] == PayStatus::DONE){
                $msg = app()->getLocale() == 'ar' ? 'تم سداد الطلب بالفعل من قبل العميل': 'The order has already been paid by the customer';
                return back()->with('danger',$msg);
            }
            if($order['status'] == OrderStatus::FINISHED){
                $msg = app()->getLocale() == 'ar' ? 'تم الانتهاء من الطلب': 'The order has already been finished';
                return back()->with('danger',$msg);
            }
            $orderBill->delete();
            $this->orderRepo->addBillStatusTimeLine($orderBill['id'],OrderStatus::DELETEINVOICE);

        }else{
            $orderService = $this->orderService->find($request['order_service_id']);
            $order = $orderService->order;
            if($order['pay_status'] == PayStatus::DONE){
                $msg = app()->getLocale() == 'ar' ? 'تم سداد الطلب بالفعل من قبل العميل': 'The order has already been paid by the customer';
                return back()->with('danger',$msg);
            }
            if($order['status'] == OrderStatus::FINISHED){
                $msg = app()->getLocale() == 'ar' ? 'تم الانتهاء من الطلب': 'The order has already been finished';
                return back()->with('danger',$msg);
            }
            if(count($orderService->bills) > 0){
                foreach ($orderService->bills as $bill){
                    $bill->price -= ($orderService['price'] * $orderService['count']);
                    $bill->vat_amount -= (($orderService['price'] * $orderService['count']) * settings('tax')) / 100;
                    $bill->save();
                }
            }
            $orderService->delete();
            $this->orderRepo->addStatusTimeLine($order['id'],OrderStatus::DELETESERVICE);

        }

        return back()->with('success','تم الحذف بنجاح');
    }
    /***************************  update provider  **************************/
    public function servicesUpdate(Request $request)
    {
        $data = array_filter($request->all());
        $orderService = $this->orderService->find($request['order_service_id']);
        $this->orderService->update($data,$orderService['id']);
        return back()->with('success','تم ارسال السعر التقدير للعميل');
    }
    /***************************  update provider  **************************/
    public function assignTech(Request $request)
    {
        $data = array_filter($request->all());
        $order = $this->orderRepo->find($data['order_id']);
        if($order['technician_id'] == null){
            $this->orderRepo->update([
                'technician_id' => $request['technician_id'],
                'status' => OrderStatus::ACCEPTED,
            ],$order['id']);
            $this->orderRepo->addStatusTimeLine($order['id'],OrderStatus::ACCEPTED);
            creatPrivateRoom($request['technician_id'],$order['user_id'],$order['id']);
        }else{
            $room = $order->room;
            if($room){
                $room->Users()->where('room_users.user_id',$order['technician_id'])->delete();
                joinRoom($room['id'],$request['technician_id']);
            }
            $this->orderRepo->update([
                'technician_id' => $request['technician_id'],
            ],$order['id']);
        }
        $order->refresh();
        $technician = $order->technician;
        $technician->notify(new AssignDelegate($order));

        return back()->with('success','تم تعيين تقني للطلب');
    }

    /***************************  update status  **************************/
    public function changeStatus(Request $request)
    {
        $data = array_filter($request->all());
        $order = $this->orderRepo->find($data['order_id']);
        if($order['technician_id'] == null){
            return back()->with('danger','قم باختيار تقني أولا للمهمه');
        }
        $this->orderRepo->update([
            'status' => $request['status'],
        ],$order['id']);

        $this->orderRepo->addStatusTimeLine($order['id'],$request['status']);
        return back()->with('success','تم تغيير حالة الطلب');
    }

    /***************************  update address  **************************/
    public function changeAddress(Request $request)
    {
        $data = array_filter($request->all());
        $order = $this->orderRepo->find($data['order_id']);
        $this->orderRepo->update([
            'lat' => $request['lat'],
            'lng' => $request['lng'],
//            'map_desc' => $request['address'],
        ],$order['id']);
        return back()->with('success','تم تغيير عنوان الطلب');
    }
    public function operationNotes(Request $request)
    {
        $data = array_filter($request->all());
        $order = $this->orderRepo->find($data['order_id']);
        $this->orderRepo->update([
            'oper_notes' => $request['oper_notes'],
        ],$order['id']);
        return back()->with('success','تم اضافة ملاحظات للطلب');
    }
    /***************************  update address  **************************/
    public function changeAllAddress(Request $request)
    {
        $data = array_filter($request->all());
        $order = $this->orderRepo->find($data['order_id']);
        $this->orderRepo->update([
            'map_desc' => $request['map_desc'],
            'residence' => $request['residence'],
            'street' => $request['street'],
            'floor' => $request['floor'],
            'address_notes' => $request['address_notes'],
        ],$order['id']);
        return back()->with('success','تم تغيير عنوان الطلب');
    }
    /***************************  update address  **************************/
    public function changePayType(Request $request)
    {
        $data = array_filter($request->all());
        $order = $this->orderRepo->find($data['order_id']);
        $order->update([
            'pay_type' => $request['pay_type'],
        ]);
        return back()->with('success','تم تغيير طريقة دفع الطلب');
    }

    /***************************  update time  **************************/
    public function changeTime(Request $request)
    {
        $data = array_filter($request->all());
        $order = $this->orderRepo->find($data['order_id']);
        $this->orderRepo->update([
            'time' => $request['time'],
        ],$order['id']);
        return back()->with('success','تم تغيير وقت الطلب');
    }

    /***************************  update date  **************************/
    public function changeDate(Request $request)
    {
        $data = array_filter($request->all());
        $order = $this->orderRepo->find($data['order_id']);
        $this->orderRepo->update([
            'date' => $request['date'],
        ],$order['id']);
        return back()->with('success','تم تغيير تاريخ الطلب');
    }

    /***************************  delete provider  **************************/
    public function destroy(Request $request,$id)
    {
        $user = auth()->user();
        if($user['user_type'] == 'operation'){
            return back()->with('danger','ليس لديك الصلاحيه للحذف');
        }
        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $this->orderRepo->delete($d);
                }
            }
        }else {
            $role = $this->orderRepo->find($id);
            $this->orderRepo->delete($role['id']);
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
    /***************************  delete provider  **************************/
    public function partsDestroy(Request $request,$id)
    {
        $role = OrderPart::find($id);
        $role->delete();
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

    public function billAccept(Request $request)
    {
        if($request['bill_type'] == 'bill'){
            $orderBill = OrderBill::where('status',0)->where('id',$request['order_service_id'])->first();

            $order = $orderBill->order;
            if($order['pay_status'] == PayStatus::DONE){
                $msg = app()->getLocale() == 'ar' ? 'تم سداد الطلب بالفعل من قبل العميل': 'The order has already been paid by the customer';
                return back()->with('danger',$msg);
            }
            if($order['status'] == OrderStatus::FINISHED){
                $msg = app()->getLocale() == 'ar' ? 'تم الانتهاء من الطلب': 'The order has already been finished';
                return back()->with('danger',$msg);
            }
            if($orderBill) {
                $orderBill['status'] = 1;
                $orderBill->save();
                $this->orderRepo->addBillStatusTimeLine($orderBill['id'],OrderStatus::ACCEPTINVOICE);
            }
        }else{
            $orderService = OrderService::find($request['order_service_id']);
            $order = $orderService->order;
            if($order['pay_status'] == PayStatus::DONE){
                $msg = app()->getLocale() == 'ar' ? 'تم سداد الطلب بالفعل من قبل العميل': 'The order has already been paid by the customer';
                return back()->with('danger',$msg);
            }
            if($order['status'] == OrderStatus::FINISHED){
                $msg = app()->getLocale() == 'ar' ? 'تم الانتهاء من الطلب': 'The order has already been finished';
                return back()->with('danger',$msg);
            }
            $orderService->update([
                'status' => 1
            ]);
            $orderBill = OrderBill::where('status',0)->where('order_id',$order['id'])->whereHas('orderServices',function ($q) use ($orderService){
                $q->where('order_services.id',$orderService['id']);
            })->first();
            if($orderBill) {
                $tax = 0;
                $amount = 0;
                foreach ($orderBill->orderServices()->where('order_services.status',0)->get() as $servs){
                    $tax += $servs['tax'] * $servs['count'];
                    $amount += $servs['price'] * $servs['count'];
                }
                $orderBill->update([
                    'vat_amount' => $tax,
                    'price' => $amount,
                ]);
                if($orderBill['price'] == 0){
                    $orderBill['status'] = 1;
                    $orderBill->save();
                }

                $this->orderRepo->addBillStatusTimeLine($orderBill['id'],OrderStatus::ACCEPTINVOICE);
            }
        }

        return back()->with('success','تم الموافقه علي الخدمه بنجاح');

    }
    public function billReject(Request $request)
    {
        if($request['bill_type'] == 'bill'){
            $orderBill = OrderBill::where('status',0)->where('id',$request['order_service_id'])->first();
            $order = $orderBill->order;
            if($order['pay_status'] == PayStatus::DONE){
                $msg = app()->getLocale() == 'ar' ? 'تم سداد الطلب بالفعل من قبل العميل': 'The order has already been paid by the customer';
                return back()->with('danger',$msg);
            }
            if($order['status'] == OrderStatus::FINISHED){
                $msg = app()->getLocale() == 'ar' ? 'تم الانتهاء من الطلب': 'The order has already been finished';
                return back()->with('danger',$msg);
            }
            if($orderBill) {
                $orderBill['status'] = 2;
                $orderBill->save();
                $this->orderRepo->addBillStatusTimeLine($orderBill['id'],OrderStatus::REFUSEINVOICE);
            }
        }else {
            $orderService = OrderService::find($request['order_service_id']);
            $order = $orderService->order;
            if ($order['pay_status'] == PayStatus::DONE) {
                $msg = app()->getLocale() == 'ar' ? 'تم سداد الطلب بالفعل من قبل العميل' : 'The order has already been paid by the customer';
                return back()->with('danger', $msg);
            }
            if ($order['status'] == OrderStatus::FINISHED) {
                $msg = app()->getLocale() == 'ar' ? 'تم الانتهاء من الطلب' : 'The order has already been finished';
                return back()->with('danger', $msg);
            }
            $orderService->update([
                'status' => 2
            ]);
            $orderBill = OrderBill::where('status', 0)->where('order_id', $order['id'])->whereHas('orderServices', function ($q) use ($orderService) {
                $q->where('order_services.id', $orderService['id']);
            })->first();
            if ($orderBill) {
                $tax = 0;
                $amount = 0;
                foreach ($orderBill->orderServices()->where('order_services.status', 0)->get() as $servs) {
                    $tax += $servs['tax'] * $servs['count'];
                    $amount += $servs['price'] * $servs['count'];
                }
                $orderBill->update([
                    'vat_amount' => $tax,
                    'price' => $amount,
                ]);
                if ($orderBill['price'] == 0) {
                    $orderBill['status'] = 2;
                    $orderBill->save();
                }
                $this->orderRepo->addBillStatusTimeLine($orderBill['id'], OrderStatus::REFUSEINVOICE);
            }
        }
        return back()->with('success','تم رفض الخدمه بنجاح');
    }

}
