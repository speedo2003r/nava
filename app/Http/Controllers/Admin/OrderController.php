<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\GuaranteeDatatable;
use App\DataTables\OrderDatatable;
use App\Entities\OrderGuarantee;
use App\Entities\OrderPart;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IOrder;
use App\Repositories\OrderRepository;
use App\Repositories\OrderServiceRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class OrderController extends Controller
{
    protected $orderRepo,$orderService;

    public function __construct(OrderServiceRepository $orderService,OrderRepository $order)
    {
        $this->orderRepo = $order;
        $this->orderService = $orderService;
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
        return view('admin.orders.show', compact('order','id','timeLineStatus'));
    }

    /***************************  update provider  **************************/
    public function rejectOrder(Request $request)
    {
        $order = $this->orderRepo->find($request['order_id']);
        $this->orderRepo->update([
            'status' => 'rejected'
        ],$order['id']);
        return back()->with('success','تم الرفض بنجاح');
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
                'status' => 'accepted',
            ],$order['id']);
            creatPrivateRoom($request['technician_id'],$order['user_id'],$order['id']);
        }else{
            $this->orderRepo->update([
                'technician_id' => $request['technician_id'],
            ],$order['id']);
        }

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

}
