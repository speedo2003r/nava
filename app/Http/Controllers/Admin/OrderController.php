<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrderDatatable;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IOrder;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepository $order)
    {
        $this->orderRepo = $order;
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
        return view('admin.orders.show', compact('order'));
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

}
