<?php

namespace App\Http\Controllers\Api\Tech;

use App\Entities\Income;
use App\Entities\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LangRequest;
use App\Http\Resources\Orders\OrderTableCollection;
use App\Http\Resources\Orders\OrderTableResource;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\OrderServiceRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\UserRepository;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Validator;

class StatisticController extends Controller
{
    use ResponseTrait;
    use NotifyTrait;

    public $orderRepo, $userRepo, $orderService;

    public function __construct(OrderServiceRepository $orderService, OrderRepository $order, UserRepository $user)
    {
        $this->userRepo = $user;
        $this->orderRepo = $order;
        $this->orderService = $orderService;
    }
    public function statistics(Request $request)
    {
        $user = auth()->user();
        $totalOrders = Income::where('user_id',$user['id'])->count();
        $totalIncomes = Income::where('user_id',$user['id'])->sum('income');
        return $this->successResponse([
            'totalOrders' => $totalOrders,
            'totalIncomes' => $totalIncomes,
        ]);
    }
    public function techWallet(Request $request)
    {
        $user = auth()->user();
        $wallet = $user['wallet'];
        $debtor = Income::where('user_id',$user['id'])->where('status',0)->sum('debtor');
        $first = Order::where('technician_id',$user['id'])->latest()->first();
        $firstDate = $first ? Carbon::parse($first['created_date'])->format('Y-m-d') : Carbon::now()->format('Y-m-d');
        $currentDate = Carbon::now()->format('Y-m-d');
        $orders = Order::where('technician_id',$user['id'])->where('status','finished')->latest()->paginate(10);
        return $this->successResponse([
            'debtor' => $debtor,
            'wallet' => $wallet,
            'firstDate' => $firstDate,
            'currentDate' => $currentDate,
            'orders' => OrderTableCollection::make($orders),
        ]);
    }
    public function downloadPdf(Request $request)
    {

        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->SetHTMLFooter('
                 <div dir="ltr" style="text-align: right">{DATE j-m-Y H:m}</div>
                 <div dir="ltr" style="text-align: center">{PAGENO} of {nbpg}</div>'
            );
        }];
        $user = auth()->user();
        $data = Order::where('technician_id',$user['id'])->where('status','finished')->latest()->get();
//        return view('pdf',compact('data'));
        $pdf = PDF::loadView('pdf', compact('data'), [], $config);

        $path = public_path('pdf');
        $fileName =  time().'.'. 'pdf' ;
        $pdf->save($path . '/' . $fileName);

        $pdf = dashboard_url('pdf/'.$fileName);
        $user->pdf = $pdf;
        $user->save();
        return $this->successResponse($pdf);
    }
}
