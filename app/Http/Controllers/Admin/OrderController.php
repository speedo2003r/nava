<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrderDatatable;
use App\Entities\OrderPart;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IOrder;
use App\Repositories\OrderRepository;
use App\Repositories\OrderServiceRepository;
use Illuminate\Http\Request;

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




    /***************************  update provider  **************************/
    public function show($id)
    {
        $order = $this->orderRepo->find($id);
        return view('admin.orders.show', compact('order','id'));
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
        $this->orderRepo->update([
            'technician_id' => $request['technician_id']
        ],$order['id']);
        return back()->with('success','تم تعيين تقني للطلب');
    }

    /***************************  delete provider  **************************/
    public function destroy(Request $request,$id)
    {
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
