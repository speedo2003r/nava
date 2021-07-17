<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\State\Create;
use App\Http\Requests\Admin\State\Update;
use App\Repositories\Interfaces\ICity;
use App\Repositories\Interfaces\IState;
use Illuminate\Http\Request;

class StateController extends Controller
{
    protected $cityRepo,$stateRepo;

    public function __construct(ICity $city,IState $state)
    {
        $this->cityRepo = $city;
        $this->stateRepo = $state;
    }

    /***************************  get all providers  **************************/
    public function index()
    {
        $cities = $this->cityRepo->cities();
        $states = $this->stateRepo->states();
        return view('admin.states.index', compact('cities','states'));
    }


    /***************************  store provider **************************/
    public function store(Create $request)
    {
        $data = array_filter($request->all());
        $this->stateRepo->store($data);
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }


    /***************************  update provider  **************************/
    public function update(Update $request, $id)
    {
        $state = $this->stateRepo->findOrFail($id);
        $this->stateRepo->update($state,array_filter($request->all()));
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }

    /***************************  delete provider  **************************/
    public function destroy(Request $request,$id)
    {
        $data = array_filter($request->all());
        $role = $this->stateRepo->findOrFail($id);
        $this->stateRepo->softDelete($role,$data);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

}
