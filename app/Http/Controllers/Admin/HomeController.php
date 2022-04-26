<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Branch;
use App\Entities\Category;
use App\Entities\Country;
use App\Entities\Order;
use App\Events\UpdateNotificationsMessages;
use App\Entities\ReviewRate;
use App\Events\UpdateNotification;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\Admin\NewOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /***************** dashboard *****************/
    public function dashboard()
    {
        $allUsers        = User::get();
        $countAdmins     = $allUsers->where('user_type', 'admin')->count();
        $countClients    = $allUsers->where('user_type', 'client')->count();
        $countCategories = Category::count();
        $countCountries  = Country::count();
        $newClients  = User::where('user_type','client')->latest()->get()->take(10);
        $branches = Branch::whereHas('regions',function ($query){
            $query->whereHas('Orders');
        })->get();
        $firstOfYear = Carbon::now()->startOfYear();
        $selleds = [
            '1'  => Order::whereDate('created_at' , '>=' , Carbon::parse($firstOfYear)->format('Y-m-d'))->whereDate('created_at' , '<' , Carbon::parse($firstOfYear->addMonths(1))->format('Y-m-d'))->where('live',1)->count(),
            '2'  => Order::whereDate('created_at' , '>=' , Carbon::parse($firstOfYear)->format('Y-m-d'))->whereDate('created_at' , '<' , Carbon::parse($firstOfYear->addMonths(1))->format('Y-m-d'))->where('live',1)->count(),
            '3'  => Order::whereDate('created_at' , '>=' , Carbon::parse($firstOfYear)->format('Y-m-d'))->whereDate('created_at' , '<' , Carbon::parse($firstOfYear->addMonths(1))->format('Y-m-d'))->where('live',1)->count(),
            '4'  => Order::whereDate('created_at' , '>=' , Carbon::parse($firstOfYear)->format('Y-m-d'))->whereDate('created_at' , '<' , Carbon::parse($firstOfYear->addMonths(1))->format('Y-m-d'))->where('live',1)->count(),
            '5'  => Order::whereDate('created_at' , '>=' , Carbon::parse($firstOfYear)->format('Y-m-d'))->whereDate('created_at' , '<' , Carbon::parse($firstOfYear->addMonths(1))->format('Y-m-d'))->where('live',1)->count(),
            '6'  => Order::whereDate('created_at' , '>=' , Carbon::parse($firstOfYear)->format('Y-m-d'))->whereDate('created_at' , '<' , Carbon::parse($firstOfYear->addMonths(1))->format('Y-m-d'))->where('live',1)->count(),
            '7'  => Order::whereDate('created_at' , '>=' , Carbon::parse($firstOfYear)->format('Y-m-d'))->whereDate('created_at' , '<' , Carbon::parse($firstOfYear->addMonths(1))->format('Y-m-d'))->where('live',1)->count(),
            '8'  => Order::whereDate('created_at' , '>=' , Carbon::parse($firstOfYear)->format('Y-m-d'))->whereDate('created_at' , '<' , Carbon::parse($firstOfYear->addMonths(1))->format('Y-m-d'))->where('live',1)->count(),
            '9'  => Order::whereDate('created_at' , '>=' , Carbon::parse($firstOfYear)->format('Y-m-d'))->whereDate('created_at' , '<' , Carbon::parse($firstOfYear->addMonths(1))->format('Y-m-d'))->where('live',1)->count(),
            '10' => Order::whereDate('created_at' , '>=' , Carbon::parse($firstOfYear)->format('Y-m-d'))->whereDate('created_at' , '<' , Carbon::parse($firstOfYear->addMonths(1))->format('Y-m-d'))->where('live',1)->count(),
            '11' => Order::whereDate('created_at' , '>=' , Carbon::parse($firstOfYear)->format('Y-m-d'))->whereDate('created_at' , '<' , Carbon::parse($firstOfYear->addMonths(1))->format('Y-m-d'))->where('live',1)->count(),
            '12' => Order::whereDate('created_at' , '>=' , Carbon::parse($firstOfYear)->format('Y-m-d'))->whereDate('created_at' , '<' , Carbon::parse($firstOfYear->addMonths(1))->format('Y-m-d'))->where('live',1)->count(),
        ];
        $data = [
            'selleds'   => $selleds,
        ];
        return view('admin.dashboard.index',compact('data','branches','newClients','countAdmins','countClients','countCategories','countCountries'));
    }

    public function charts() {

        // prepare financial chart (money in month through last year)

        $requests = Order::whereYear('created_data', date('Y'))->orderBy('created_data')->get()->groupBy('date2');

        $default = 0;

        for($i = 12; $i > 0; $i--){
            if(isset($requests->all()[$i])){
                $paid = $requests->all()[$i]->sum('paid');
            } else {
                $paid = $default;
            }

            $lineData[] = [$i, $paid];
        }
        $lineData = collect($lineData)->toJson();

//        dd($lineData);

        // prepare piechart of (requests per category) data
        $categories = Category::all();

        $colors = [
            '#00F7F7',
            '#FF049B',
            '#04FFA4',
            '#0000FF',
            '#FF69B4',
            '#F4A460',
            '#DC143C',
            '#FFD700',
            '#00FF00',
            '#00FFFF',
            '#FFFF00',
            '#8A2BE2',
            '#FF4500',
            '#778899',
            '#D2691E',
            '#0000CD',
            '#ADFF2F',
        ];

        $pieData = array();

        if(auth()->user()->type == 'admin'){
            $total_requests = ServiceRequest::withTrashed()->whereNotIn('status', ['rejected', 'canceled'])->whereIn('branch_id', auth()->user()->branches->pluck('id'))->count();

            foreach ($categories as $num => $category) {
                $pieData[] = (object) [
                    'label' => $category->title,
                    'value' => $total_requests ? round(($category->services()->withCount([
                                'requests as requests_number' => function($q){
                                    $q->whereNotIn('status', ['canceled', 'rejected'])
                                        ->whereIn('branch_id', auth()->user()->branches->pluck('id'));
                                }
                            ])->get()->sum('requests_number') / $total_requests) * 100, 2): 0,
                    'color' => isset($colors[$num]) ? $colors[$num] : $colors[$num % count($colors)]
                ];
            }
        } else {
            $total_requests = $categories->sum('requests_count');

            foreach ($categories as $num => $category) {
                $pieData[] = (object) [
                    'label' => $category->title,
                    'value' => ($total_requests && $category->requests_count) ? round(($category->requests_count / $total_requests) * 100, 2) : 0 ,
                    'color' => isset($colors[$num]) ? $colors[$num] : $colors[$num % count($colors)]
                ];
            }
        }

        $pieData = collect($pieData);

        // prepare data for last week finished requests chart

        $last_week_requests = $this->lastWeekRequests();

        if(auth()->user()->type == 'admin'){
            $data = [
                'servies' => Service::count(),
                'branches' => auth()->user()->branches()->with('services'),
                'last_requests' => ServiceRequest::whereNotIn('status', ['canceled', 'rejected'])->whereIn('branch_id', auth()->user()->branches->pluck('id'))->with('client', 'service')->latest()->limit(5)->get()
            ];
        } else {

            $data = [
                'users' => \App\User::where('type', 'client')->latest()->limit(5)->with('requests.service')->get(),

                'servies' => Service::count(),
                'branches' => Branch::withCount('services')->get(),
                'logs' => \App\Log::latest()->limit(5)->with('user')->get(),
                'last_requests' => ServiceRequest::whereNotIn('status', ['canceled', 'rejected'])->latest()->with('client', 'service')->limit(5)->get()
            ];
        }
        if(auth()->user()->type == 'admin'){
            $branches = auth()->user()->branches()->withCount('requests','operations','technicians','engineers')->limit(10)->get();
        }else{

            $branches = Branch::withCount('requests','operations','technicians','engineers')->limit(10)->get();

        }

        $branchChart['branchTit'] = array();
        $branchChart['branchReq'] = array();
        $branchChart['branchOper'] = array();
        $branchChart['branchTech'] = array();
        $branchChart['branchEng'] = array();



        foreach ($branches as $branch) {


            array_push($branchChart['branchTit'], $branch->title);
            array_push($branchChart['branchReq'], $branch->requests_count);
            array_push($branchChart['branchOper'], $branch->operations_count);
            array_push($branchChart['branchTech'], $branch->technicians_count);
            array_push($branchChart['branchEng'], $branch->engineers_count);




        }

        // $branchChart =  response()->json($branchChart);

        // dd($branchChart['branchTit']);

        return view('admin.dashboard.index', compact('lineData', 'pieData', 'data', 'last_week_requests','branchChart'));
    }
    public function financialReport(Request $request)
    {
        $type = 'year';
        $year = $request->year ?? date('Y');
        $requests =
            ServiceRequest::
            withTrashed()
                ->whereYear('created_at', $year)
                ->selectRaw('sum(paid) sum_paid');

        if(auth()->user()->type == 'admin'){
            $requests = $requests->whereHas('branch', function($q){
                $q->where('user_id', auth()->user()->id);
            });
        }

        $loopLength = 12;

        if($request->get('month')){
            $type = 'month';
            $loopLength = Carbon::parse("$year/{$request->get('month')}/01")->daysInMonth;
            $requests = $requests->selectRaw('day(created_at) day')->whereMonth('created_at', $request->get('month'))->groupBy('day');
        }else{
            $requests = $requests->selectRaw("month(created_at) month")->groupBy('month');
        }

        $requests = $requests->get()->keyBy($type == 'year' ? 'month' : 'day')->makeHidden('date2')->toArray();

        $data = [];

        for($i=1; $i<=$loopLength; $i++){
            $data[] = [$i, $requests[$i]['sum_paid'] ?? 0];
        }

        return response()->json(['data' => $data, 'type' => $type]);
    }

    public function notifications()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(10);
        auth()->user()->unreadnotifications->markAsRead();
        return view('admin.notifications.index',compact('notifications'));
    }

}
