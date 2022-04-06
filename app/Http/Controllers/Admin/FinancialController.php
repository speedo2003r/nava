<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AccountantDatatable;
use App\DataTables\ClientDatatable;
use App\DataTables\OrderFinancialDatatable;
use App\DataTables\CatServDatatable;
use App\Entities\Category;
use App\Entities\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Accountant\Create;
use App\Http\Requests\Admin\Accountant\Update;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FinancialController extends Controller
{
    use NotifyTrait;
    use ResponseTrait;
    use UploadTrait;
    protected $order;

    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }

    /***************************  get all providers  **************************/
    public function statistics()
    {
        $allOrdersCount = Order::whereHas('category')->where('live',1)->count();
        $newOrdersCount = Order::whereHas('category')->where('live',1)->where('orders.status','created')->count();
        $InProgressOrdersCount = Order::whereNotIn('status',['created','finished'])->whereHas('category')->where('live',1)->count();
        $FinishedOrdersCount = Order::whereHas('category')->where('live',1)->where('orders.status','finished')->count();
        $CashOrdersCount = Order::whereHas('category')->where('pay_type','cash')->where('live',1)->count();
        $OnlineOrdersCount = Order::whereHas('category')->where('pay_type','!=','cash')->where('live',1)->count();
        return view('admin.financials.index',get_defined_vars());
    }

    public function catServ(CatServDatatable $datatable)
    {
        $categories = Category::where('parent_id',null)->get();
        $category_id = \request('category_id');
        $subcategory_id = \request('subcategory_id');
        $service_id = \request('service_id');
        if(request('category_id') != null && request('subcategory_id') != null && request('service_id') != null){
            $income = Order::query()
                ->whereHas('category')->where('order_services.category_id',request('subcategory_id'))->select('orders.id',DB::raw('SUM(order_services.price + order_services.tax) as total'))
                ->leftJoin('order_bills','order_bills.order_id','=','orders.id')
                ->leftJoin('order_services','order_services.order_id','=','orders.id')
                ->where('order_services.service_id',request('service_id'))
                ->where('live',1)
                ->first();
        }elseif(request('category_id') != null && request('subcategory_id') != null && request('service_id') == null){
            $income = Order::query()
                ->whereHas('category')->where('order_services.category_id',request('subcategory_id'))->select(DB::raw('SUM(order_services.price + order_services.tax) as total'))
                ->leftJoin('order_bills','order_bills.order_id','=','orders.id')
                ->leftJoin('order_services','order_services.order_id','=','orders.id')
                ->where('live',1)
                ->first();
        }elseif(request('category_id') != null && request('subcategory_id') == null && request('service_id') == null){
            $income = Order::query()->where('orders.category_id',request('category_id'))
                ->whereHas('category')->select(DB::raw('SUM(order_services.price + order_services.tax) as total'))
                ->leftJoin('order_bills','order_bills.order_id','=','orders.id')
                ->leftJoin('order_services','order_services.order_id','=','orders.id')
                ->where('live',1)
                ->first();
        }elseif(request('from') != null && request('to') != null && request('category_id') != null && request('subcategory_id') != null && request('service_id') == null) {
            $income = Order::query()
                ->whereHas('category')->where('order_services.category_id', request('subcategory_id'))->select(DB::raw('SUM(order_services.price + order_services.tax) as total'))
                ->leftJoin('order_bills', 'order_bills.order_id', '=', 'orders.id')
                ->leftJoin('order_services', 'order_services.order_id', '=', 'orders.id')
                ->whereDate('created_date', '>=', request('from'))
                ->whereDate('created_date', '<=', request('to'))
                ->where('live', 1)
                ->first();
        }elseif(request('from') != null && request('to') != null && request('category_id') != null &&  request('subcategory_id') == null && request('service_id') == null) {
            $income = Order::query()->where('orders.category_id', request('category_id'))
                ->whereHas('category')->select(DB::raw('SUM(order_services.price + order_services.tax) as total'))
                ->leftJoin('order_bills', 'order_bills.order_id', '=', 'orders.id')
                ->leftJoin('order_services', 'order_services.order_id', '=', 'orders.id')
                ->whereDate('created_date', '>=', request('from'))
                ->whereDate('created_date', '<=', request('to'))
                ->where('live', 1)
                ->first();
        }elseif(request('from') != null && request('to') != null && request('category_id') != null && request('subcategory_id') != null && request('service_id') != null){
            $income = Order::query()
                ->whereHas('category')->where('order_services.category_id',request('subcategory_id'))->select(DB::raw('SUM(order_services.price + order_services.tax) as total'))
                ->leftJoin('order_bills','order_bills.order_id','=','orders.id')
                ->leftJoin('order_services','order_services.order_id','=','orders.id')
                ->where('order_services.service_id',request('service_id'))
                ->whereDate('created_date', '>=', request('from'))
                ->whereDate('created_date', '<=', request('to'))
                ->where('live',1)
                ->first();
        }elseif(request('from') != null && request('to') != null && request('category_id') == null &&  request('subcategory_id') == null && request('service_id') == null){
            $income = Order::query()
                ->whereHas('category')->select(DB::raw('SUM((orders.final_total + orders.vat_amount) - orders.coupon_amount) + IFNULL(SUM(order_bills.price + order_bills.vat_amount),0) as total'))
                ->leftJoin('order_bills','order_bills.order_id','=','orders.id')
                ->whereDate('created_date', '>=', request('from'))
                ->whereDate('created_date', '<=', request('to'))
                ->where('live',1)
                ->first();
        }else{
            $income = Order::query()
                ->whereHas('category')->select(DB::raw('SUM((orders.final_total + orders.vat_amount) - orders.coupon_amount) + IFNULL(SUM(order_bills.price + order_bills.vat_amount),0) as total'))
                ->leftJoin('order_bills','order_bills.order_id','=','orders.id')
                ->where('live',1)
                ->first();
        }
        $from = request('from');
        $to = request('to');
        return $datatable->render('admin.financials.catServ',compact('subcategory_id','from','to','service_id','category_id','categories','income'));
    }
    /***************************  get all providers  **************************/
    public function orders(OrderFinancialDatatable $orderDatatable)
    {
        return $orderDatatable->render('admin.financials.orders');
    }

    public function orderShow($id)
    {
        $order = $this->order->find($id);
        return view('admin.financials.orderShow',compact('order','id'));
    }
    public function dailyOrders(Request $request)
    {
        $days = [];
        $orders = [];
        $from = 1;
        $fromdate = $request['from'] ? $request['from'] : Carbon::now()->format('Y-m-d');
        $arr = [];
        $now = Carbon::createFromFormat('Y-m-d', date('Y-m-d',strtotime($fromdate)));
        $monthStartDate = $now->startOfMonth()->format('Y-m-d');
        $monthEndDate = $now->startOfMonth()->format('Y-m-d');
        $period = CarbonPeriod::create($monthStartDate, $monthEndDate);
        $start = new \Carbon\Carbon($monthStartDate);
        $end = new \Carbon\Carbon($monthEndDate);
        $arr['start'] = date('d-m-Y',strtotime($start->subMonth(1)));
        $arr['end'] = date('d-m-Y',strtotime($end->addMonth(1)));

        $to = $start->daysInMonth;
        $format = $start;
        $start = Carbon::parse($format->format('Y-m'))->startOfMonth();
        for($i = $from;$i <= $to;$i++){
            $days[] = $i;
            $orders[] = DB::table('daily_orders')->whereMonth('date',$now->format('m'))->whereDay('date',$i)->sum('total');
            $start->addDay();
        }
        return view('admin.financials.dailyOrders',compact('arr','now','orders','days'));
    }
}
