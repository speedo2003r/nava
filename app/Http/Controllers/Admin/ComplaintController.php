<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ComplaintDatatable;
use App\DataTables\ContactUsDatatable;
use App\Http\Controllers\Controller;
use App\Repositories\ComplaintRepository;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    protected $complaint;

    public function __construct(ComplaintRepository $complaint)
    {
        $this->complaint = $complaint;
    }

    /***************************  get all contacts  **************************/
    public function index(ComplaintDatatable $contactUsDatatable)
    {
        $contacts = $this->complaint->all();
        return $contactUsDatatable->render('admin.complaints.index', compact('contacts'));
    }

    /***************************  update contact  **************************/
    public function update(Request $request, $id)
    {
        $contact = $this->complaint->find($id);
        $this->complaint->update(array_filter($request->all()),$contact['id']);
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }
    /***************************  delete contact  **************************/
    public function destroy(Request $request,$id)
    {
        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $this->complaint->delete($d);
                }
            }
        }else {
            $role = $this->complaint->find($id);
            $this->complaint->delete($role['id']);
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

}
