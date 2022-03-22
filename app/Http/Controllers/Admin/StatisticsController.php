<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Entities\Branch;
use App\Entities\Category;
use App\Entities\City;
use App\Entities\Country;
use App\Entities\Item;
use App\Entities\Order;
use App\Entities\Setting;
use App\Models\User;
use App\Entities\Visit;
use App\Repositories\CountryRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller{
    protected $countryRepo;
    public function __construct(CountryRepository $country)
    {
        $this->countryRepo = $country;
    }
    public function clients(Request $request)
    {
        $countryquery = $request->query('country_id');
        $countries = $this->countryRepo->all();
        if($countryquery != null){
            $users = User::select('users.id','users.name','users.email','users.phone','users.active','users.created_at',DB::raw('COUNT(orders.id) AS count'))
                ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
                ->where('users.user_type','client')
                ->where('users.country_id',$countryquery)
                ->groupBy('users.id','users.name','users.email','users.phone','users.active','users.created_at')->orderBy('count','desc')->get();
        }else{
            if(auth()->user()['role_id'] == 1){
                $users = User::select('users.id','users.name','users.email','users.phone','users.active','users.created_at',DB::raw('COUNT(orders.id) AS count'))
                    ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
                    ->where('users.user_type','client')
                    ->groupBy('users.id','users.name','users.email','users.phone','users.active','users.created_at')->orderBy('count','desc')->get();
            }else{
                $users = User::select('users.id','users.name','users.email','users.phone','users.active','users.created_at',DB::raw('COUNT(orders.id) AS count'))
                    ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
                    ->where('users.user_type','client')
                    ->where('users.country_id',auth()->user()['country_id'])
                    ->groupBy('users.id','users.name','users.email','users.phone','users.active','users.created_at')->orderBy('count','desc')->get();
            }
        }
        return view('admin.statistics.clients',compact('users','countries','countryquery'));
    }

    public function visits(Request $request)
    {
        $days = [];
        $times = [];
        $ios = [];
        $android = [];
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
            $ios[] = Visit::where('device_type','ios')->whereMonth('created_at',$now->format('m'))->whereDay('created_at',$i)->count();
            $start->addDay();
        }
        for($i = $from;$i <= $to;$i++){
            $days[] = $i;
            $android[] = Visit::where('device_type','android')->whereMonth('created_at',$now->format('m'))->whereDay('created_at',$i)->count();
            $start->addDay();
        }

        return view('admin.statistics.visits',compact('to','from','now','format','arr','times','ios','android','days','start'));
    }
    public function pay(Request $request)
    {
        $countryquery = $request->query('country_id');
        if(auth()->user()['role_id'] == 1){
            if($countryquery != null){
                $countries = $this->countryRepo->all();
                $cod = Order::where('payment_type','cod')->where('country_id',$countryquery)->count();
                $online = Order::where('payment_type','online')->where('country_id',$countryquery)->count();
                $apple = Order::where('payment_type','apple')->where('country_id',$countryquery)->count();
                $publicDelegates = User::where('user_type','delegate')->where('country_id',$countryquery)->whereDoesntHave('delegatesSellers')->whereDoesntHave('delegateCompanies')->count();
                $sellerDelegates = User::where('user_type','delegate')->where('country_id',$countryquery)->whereHas('delegatesSellers')->count();
                $companyDelegates = User::where('user_type','delegate')->where('country_id',$countryquery)->whereHas('delegateCompanies')->count();
            }else{
                $countries = $this->countryRepo->all();
                $cod = Order::where('payment_type','cod')->count();
                $online = Order::where('payment_type','online')->count();
                $apple = Order::where('payment_type','apple')->count();
                $publicDelegates = User::where('user_type','delegate')->whereDoesntHave('delegatesSellers')->whereDoesntHave('delegateCompanies')->count();
                $sellerDelegates = User::where('user_type','delegate')->whereHas('delegatesSellers')->count();
                $companyDelegates = User::where('user_type','delegate')->whereHas('delegateCompanies')->count();
            }
        }else{
            $countries = $this->countryRepo->all();
            $cod = Order::where('payment_type','cod')->where('country_id',auth()->user()['country_id'])->count();
            $online = Order::where('payment_type','online')->where('country_id',auth()->user()['country_id'])->count();
            $apple = Order::where('payment_type','apple')->where('country_id',auth()->user()['country_id'])->count();
            $publicDelegates = User::where('user_type','delegate')->where('country_id',auth()->user()['country_id'])->whereDoesntHave('delegatesSellers')->whereDoesntHave('delegateCompanies')->count();
            $sellerDelegates = User::where('user_type','delegate')->where('country_id',auth()->user()['country_id'])->whereHas('delegatesSellers')->count();
            $companyDelegates = User::where('user_type','delegate')->where('country_id',auth()->user()['country_id'])->whereHas('delegateCompanies')->count();
        }


        return view('admin.statistics.pay',compact('apple','online','cod','countries','countryquery','companyDelegates','publicDelegates','sellerDelegates'));
    }

    public function sales(Request $request)
    {
        $companies = User::Where('user_type','provider')->get();
        $branches = Branch::all();
        $categories = Category::where('parent_id',null)->get();
        $items = Item::where('status',1)->get();
        return view('admin.statistics.sales',compact('items','categories','companies','branches'));
    }
    public function postSales(Request $request)
    {
        if($request->ajax()){
            $type = $request['type'];
            if($type == 'company'){
                $price = Order::where('seller_id',$request['id'])->where('delivered_date','!=',null)->sum('totalPrice');
                $shopping = Order::where('seller_id',$request['id'])->where('delivered_date','!=',null)->sum('shopping_value');
                $offer = Order::where('seller_id',$request['id'])->where('delivered_date','!=',null)->where('priceAfterDiscount','>',0)->count();
            }elseif($type == 'branch'){
                $price = Order::where('branch_id',$request['id'])->where('delivered_date','!=',null)->sum('totalPrice');
                $shopping = Order::where('branch_id',$request['id'])->where('delivered_date','!=',null)->sum('shopping_value');
                $offer = Order::where('branch_id',$request['id'])->where('delivered_date','!=',null)->where('priceAfterDiscount','>',0)->count();
            }elseif($type == 'category'){
                $price = Order::where('category_id',$request['id'])->where('delivered_date','!=',null)->sum('totalPrice');
                $shopping = Order::where('category_id',$request['id'])->where('delivered_date','!=',null)->sum('shopping_value');
                $offer = Order::where('category_id',$request['id'])->where('delivered_date','!=',null)->where('priceAfterDiscount','>',0)->count();
            }elseif($type == 'item'){
                $price = OrderProduct::where('item_id',$request['id'])->whereHas('order',function ($query){
                    $query->where('delivered_date','!=',null);
                })->sum('order_products.priceAfterDiscount');
                $shopping = OrderProduct::where('item_id',$request['id'])->whereHas('order',function ($query){
                    $query->where('delivered_date','!=',null);
                })->sum('shopping_value');
                $offer = OrderProduct::where('item_id',$request['id'])->whereHas('order',function ($query){
                    $query->where('delivered_date','!=',null);
                })->whereColumn('priceAfterDiscount','<','price')->count();
            }
            return response()->json([
                'total' => $price,
                'shopping' => $shopping,
                'count' => $offer,
            ]);
        }
    }
    public function almostOrder(Request $request)
    {
        $days = [];
        $times = [];
        $almostorders = [];
        $almosttimeorders = [];
        $from = 1;

        $countryquery = $request->query('country_id');
        $countries = $this->countryRepo->all();
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
        for($t = 1;$t <= 24;$t++){
            if(strlen($t) == 1){
                $times[] = '0'.$t;
                $y = $t+1;
                $y = '0'.$y;
            }else{
                $times[] = $t;
                $y = $t+1;
            }
            if($countryquery != null) {
                $almosttimeorders[] = Order::where('live', '>', 0)->where('country_id',$countryquery)->whereMonth('created_at', $now->format('m'))->whereTime('created_at', '>', $t . ':00:00')->whereTime('created_at', '<', $y . ':00:00')->count();
            }else{
                $almosttimeorders[] = Order::where('live', '>', 0)->whereMonth('created_at', $now->format('m'))->whereTime('created_at', '>', $t . ':00:00')->whereTime('created_at', '<', $y . ':00:00')->count();
            }
        }
        for($i = $from;$i <= $to;$i++){
            $days[] = $i;
            if($countryquery != null) {
                $almostorders[] = Order::where('live', '>', 0)->where('country_id',$countryquery)->whereMonth('created_at', $now->format('m'))->whereDay('created_at', $i)->count();
            }else{
                $almostorders[] = Order::where('live', '>', 0)->whereMonth('created_at', $now->format('m'))->whereDay('created_at', $i)->count();
            }
            $start->addDay();
        }
        if($countryquery != null) {
            if(isset($request['from'])){
                $users = User::select('users.id','users.name','users.email','users.phone','users.active','users.created_at',DB::raw('COUNT(orders.id) AS count'))
                    ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
                    ->where('users.user_type','client')
                    ->where('users.country_id',$countryquery)
                    ->whereMonth('orders.created_at',date('m',strtotime($request['from'])))
                    ->groupBy('users.id','users.name','users.email','users.phone','users.active','users.created_at')->orderBy('count','desc')->take(10)->get();
            }else{
                $users = User::select('users.id','users.name','users.email','users.phone','users.active','users.created_at',DB::raw('COUNT(orders.id) AS count'))
                    ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
                    ->where('users.user_type','client')
                    ->where('users.country_id',$countryquery)
                    ->groupBy('users.id','users.name','users.email','users.phone','users.active','users.created_at')->orderBy('count','desc')->take(10)->get();
            }
        }else{
            if(auth()->user()['role_id'] == 1){
                if(isset($request['from'])){
                    $users = User::select('users.id','users.name','users.email','users.phone','users.active','users.created_at',DB::raw('COUNT(orders.id) AS count'))
                        ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
                        ->where('users.user_type','client')
                        ->whereMonth('orders.created_at',date('m',strtotime($request['from'])))
                        ->groupBy('users.id','users.name','users.email','users.phone','users.active','users.created_at')->orderBy('count','desc')->take(10)->get();
                }else{
                    $users = User::select('users.id','users.name','users.email','users.phone','users.active','users.created_at',DB::raw('COUNT(orders.id) AS count'))
                        ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
                        ->where('users.user_type','client')
                        ->groupBy('users.id','users.name','users.email','users.phone','users.active','users.created_at')->orderBy('count','desc')->take(10)->get();
                }
            }else{
                if(isset($request['from'])){
                    $users = User::select('users.id','users.name','users.email','users.phone','users.active','users.created_at',DB::raw('COUNT(orders.id) AS count'))
                        ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
                        ->where('users.user_type','client')
                        ->where('users.country_id',auth()->user()['country_id'])
                        ->whereMonth('orders.created_at',date('m',strtotime($request['from'])))
                        ->groupBy('users.id','users.name','users.email','users.phone','users.active','users.created_at')->orderBy('count','desc')->take(10)->get();
                }else{
                    $users = User::select('users.id','users.name','users.email','users.phone','users.active','users.created_at',DB::raw('COUNT(orders.id) AS count'))
                        ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
                        ->where('users.user_type','client')
                        ->where('users.country_id',auth()->user()['country_id'])
                        ->groupBy('users.id','users.name','users.email','users.phone','users.active','users.created_at')->orderBy('count','desc')->take(10)->get();
                }
            }
        }
        return view('admin.statistics.almostOrder',compact('countryquery','countries','now','format','arr','users','almosttimeorders','times','days','almostorders'));
    }
    public function search(Request $request)
    {
        $countryquery = $request->query('country_id');
        $countries = $this->countryRepo->all();
        if(auth()->user()['role_id'] != 1){
            $items = Item::where('status',1)->whereHas('user',function ($query){
                $query->where('country_id',auth()->user()['country_id']);
            })->whereHas('searches',function ($query){
                $query->where('country_id',auth()->user()['country_id']);
            })->orderBy('views','desc')->get();
        }else{
            if($countryquery){
                $items = Item::where('status',1)->whereHas('searches',function ($query) use ($countryquery){
                    $query->where('country_id',$countryquery);
                })->orderBy('views','desc')->get();
            }else{
                $items = Item::where('status',1)->whereHas('searches')->orderBy('views','desc')->get();
            }
        }
        return view('admin.statistics.search',compact('items','countryquery','countries'));
    }
    public function delegates(Request $request)
    {
        $countryquery = $request->query('country_id');
        $countries = $this->countryRepo->all();
        if($countryquery != null){
            $delegates = User::where('user_type','delegate')->where('country_id',$countryquery)->count();
            $activedelegate = User::where('user_type','delegate')->where('country_id',$countryquery)->where('active',1)->where('banned',0)->count();
            $deactivedelegate = User::where('user_type','delegate')->where('country_id',$countryquery)->where('active',0)->orWhere('banned',1)->count();
            $accepteddelegate = User::where('user_type','delegate')->where('country_id',$countryquery)->whereHas('delegateorders',function ($delegateorder){
                $delegateorder->where('delegate_orders.status','=',1);
            })->count();
        }else{
            if(auth()->user()['role_id'] == 1){
                $delegates = User::where('user_type','delegate')->count();
                $activedelegate = User::where('user_type','delegate')->where('active',1)->where('banned',0)->count();
                $deactivedelegate = User::where('user_type','delegate')->where('active',0)->orWhere('banned',1)->count();
                $accepteddelegate = User::where('user_type','delegate')->whereHas('delegateorders',function ($delegateorder){
                    $delegateorder->where('delegate_orders.status','=',1);
                })->count();
            }else{
                $delegates = User::where('user_type','delegate')->where('country_id',auth()->user()['country_id'])->count();
                $activedelegate = User::where('user_type','delegate')->where('country_id',auth()->user()['country_id'])->where('active',1)->where('banned',0)->count();
                $deactivedelegate = User::where('user_type','delegate')->where('country_id',auth()->user()['country_id'])->where('active',0)->orWhere('banned',1)->count();
                $accepteddelegate = User::where('user_type','delegate')->where('country_id',auth()->user()['country_id'])->whereHas('delegateorders',function ($delegateorder){
                    $delegateorder->where('delegate_orders.status','=',1);
                })->count();
            }
        }
        return view('admin.statistics.delegates',compact('accepteddelegate','deactivedelegate','activedelegate','countryquery','countries','delegates'));
    }
    public function getdata(Request $request)
    {
        if($request['company']){
            $data = User::find($request['company']);
            $ordermounts = $data->ordersAsSeller()->sum('priceAfterDiscount');
            $ordercounts = $data->ordersAsSeller()->count();
            $type = 'شركه';
            $name = $data['name'];
        }elseif($request['branch']){
            $data = Branch::find($request['branch']);
            $ordermounts = $data->orders()->sum('priceAfterDiscount');
            $ordercounts = $data->orders()->count();
            $type = 'فرع';
            $name = $data['title'];
        }elseif($request['category']){
            $data = Category::find($request['category']);
            $items = $data->items;
            $ordercounts = 0;
            $ordermounts = 0;
            if(count($items) > 0){
                $orderproducts = OrderProduct::with('options')->whereIn('item_id',$data->items()->pluck('id')->toArray())->get();
                $ordersoptions = DB::table('ordersoptions')->whereIn('id',$orderproducts->pluck('id')->toArray())->get();
                $ordermounts = $orderproducts->sum(function($c){return $c->price * $c->qty;}) + $ordersoptions->sum(function($t){return $t->price * $t->count;});
                $ordercounts = count($orderproducts->unique('order_id'));
            }
            $type = 'قسم رئيسي';
            $name = $data['title'];
        }elseif($request['item']){
            $data = Item::find($request['item']);
            $orderproducts = $data->OrderProducts()->get();
            $orderproducts = $orderproducts->map(function ($query){
                return [
                    'count' => $query->qty,
                    'price' => $query->price * $query->qty,
                ];
            });
            $ordermounts = $orderproducts->sum('price');
            $ordercounts = $orderproducts->sum('count');
            $type = 'منتج';
            $name = $data['title'];
        }
        return back()->with(['ordermounts'=>$ordermounts,'ordercounts'=>$ordercounts,'type'=>$type,'name'=>$name]);
    }
}
