<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ClientDatatable;
use App\DataTables\TechnicianDatatable;
use App\DataTables\TechnicianOrderDatatable;
use App\Entities\Income;
use App\Entities\Order;
use App\Entities\UserDeduction;
use App\Enum\OrderStatus;
use App\Enum\IncomeType;
use App\Enum\PayType;
use App\Enum\WalletOperationType;
use App\Enum\WalletType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Technician\Create;
use App\Http\Requests\Admin\Technician\Update;
use App\Repositories\BranchRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\TechnicianRepository;
use App\Repositories\UserRepository;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TechnicianController extends Controller
{
    use NotifyTrait;
    use ResponseTrait;
    use UploadTrait;
    protected $category,$user, $country,$city,$technician,$branch;

    public function __construct(CategoryRepository $category,BranchRepository $branch,TechnicianRepository $technician,UserRepository $user,CountryRepository $country,CityRepository $city)
    {
        $this->user = $user;
        $this->country = $country;
        $this->city = $city;
        $this->technician = $technician;
        $this->branch = $branch;
        $this->category = $category;
    }

    /***************************  get all providers  **************************/
    public function index(TechnicianDatatable $clientDatatable)
    {
        $countries = $this->country->all();
        $categories = $this->category->where('parent_id',null)->get();
        $cities = $this->city->all();
        return $clientDatatable->render('admin.technicians.index', compact('categories','cities','countries'));
    }


    /***************************  store provider **************************/
    public function store(Create $request)
    {
        $data = array_filter($request->except('image'));
        $data['user_type']  = 'technician';
        if($request->has('image')){
            $data['avatar'] = $this->uploadFile($request['image'],'users');
        }
        $data['active'] = 1;
        $data['v_code'] = generateCode();
        $user = $this->user->create($data);
        $fillable = $user->getFillable();
        $request->request->add(['user_id'=>$user['id']]);
        $this->technician->create($request->except($fillable));
        $user->branches()->attach($request['branches']);
        return redirect()->back()->with('success', '???? ?????????????? ??????????');
    }


    /***************************  update provider  **************************/
    public function update(Update $request, $id)
    {
        $user = $this->user->find($id);
        if($request->has('image')){
            if($user['avatar'] != null || $user['avatar'] != '/default.png'){
                $this->deleteFile($user['avatar'],'users');
            }
            $request->request->add(['avatar'=>$this->uploadFile($request['image'],'users')]);
        }
        $this->user->update(array_filter($request->except('image')),$user['id']);
        $this->technician->update($request->except($user->getFillable()),$user->technician['id']);
        $user->branches()->sync($request['branches']);
        return redirect()->back()->with('success', '???? ?????????????? ??????????');
    }

    /***************************  delete provider  **************************/
    public function destroy(Request $request,$id)
    {
        $user = auth()->user();
        if($user['user_type'] == 'operation'){
            return back()->with('danger','?????? ???????? ???????????????? ??????????');
        }
        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $this->user->delete($d);
                }
            }
        }else {
            $role = $this->user->find($id);
            $this->user->delete($role['id']);
        }
        return redirect()->back()->with('success', '???? ?????????? ??????????');
    }

    public function orders(TechnicianOrderDatatable $datatable,$id,Request $request)
    {
        $orderCount = Order::where('technician_id',$id)
            ->when($request->has('status') && $request['status'] == OrderStatus::PENDING ,function ($q){
                $q->where('status',OrderStatus::PENDING);
            })
            ->when($request->has('status') && $request['status'] == OrderStatus::DAILY,function ($q){
                $q->whereDate('created_date',Carbon::now()->format('Y-m-d'));
            })
            ->when($request->has('status') && $request['status'] == OrderStatus::FINISHED,function ($q){
                $q->where('status',OrderStatus::FINISHED);
            })
            ->count();
        return $datatable->with(['id'=>$id])->render('admin.technicians.order',compact('id','orderCount'));
    }
    public function decreaseVal(Request $request)
    {
        $this->validate($request,[
            'deduction' => 'required',
            'notes' => 'required',
        ],[],[
            'deduction' => '???????? ??????????',
            'notes' => '??????????',
        ]);
        $user = $this->user->find($request->id);
        if(isset($request['order_id'])){
            $order = Order::find($request['order_id']);
            if($request['deduction'] > $order['final_total']){
                return back()->with('danger',awtTrans('???????? ?????????? ???????? ???? ???????? ??????????'));
            }
        }

        $user->wallets()->create([
            'amount' => $request['deduction'],
            'type' => WalletType::DEPOSIT,
            'created_by'=>auth()->id(),
            'operation_type'=>WalletOperationType::WITHDRAWAL,
        ]);

        UserDeduction::create([
            'user_id' => $user['id'],
            'admin_id' => auth()->id(),
            'balance' => $request['deduction'],
            'notes' => $request['notes'],
            'order_id' => $request['order_id'] ?? null,
        ]);
        return back()->with('success',awtTrans('???? ?????????? ??????????'));
    }

    public function selectCategories(Request $request)
    {
        $user = $this->user->find($request->user_id);
        $user->categories()->sync($request['perms']);
        return back()->with('success',awtTrans('???? ?????????? ??????????'));
    }
    public function accounts($id)
    {
        $user = $this->user->find($id);
        $incomes = Income::where('user_id',$user['id'])->latest()->get();
        return view('admin.technicians.accounts',compact('incomes','user'));
    }
    public function settlement(Request $request)
    {
        $income = Income::find($request['id']);
        $user = $income->user;
        if($income['type'] == IncomeType::CREDITOR){
            $user->wallets()->create([
                'amount' => $income['creditor'],
                'type' => WalletType::DEPOSIT,
                'created_by'=>$user['id'],
                'operation_type'=>WalletOperationType::WITHDRAWAL,
            ]);
            $income->status = 1;
            $income->save();
        }else{
            if($request['type'] == PayType::WALLET){
                $user->wallets()->create([
                    'amount' => $income['debtor'],
                    'type' => WalletType::DEPOSIT,
                    'created_by'=>$user['id'],
                    'operation_type'=>WalletOperationType::WITHDRAWAL,
                ]);
                $income->status = 1;
                $income->save();
            }else{
                $income->status = 1;
                $income->save();
            }
        }
        return back()->with('success',awtTrans('???? ?????????????? ??????????'));
    }
    public function accountsDelete($id)
    {
        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $role = Income::find($d);
                    $role->delete();
                }
            }
        }else {
            $role = Income::find($id);
            $role->delete();
        }

        return redirect()->back()->with('success', '???? ?????????? ??????????');
    }
}
