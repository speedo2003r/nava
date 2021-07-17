<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ContactUsDatatable;
use App\Http\Controllers\Controller;
use App\Repositories\ContactUsRepository;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $contact;

    public function __construct(ContactUsRepository $contact)
    {
        $this->contact = $contact;
    }

    /***************************  get all contacts  **************************/
    public function index(ContactUsDatatable $contactUsDatatable)
    {
        $contacts = $this->contact->all();
        return $contactUsDatatable->render('admin.contacts.index', compact('contacts'));
    }

    /***************************  update contact  **************************/
    public function update(Request $request, $id)
    {
        $contact = $this->contact->find($id);
        $this->contact->update(array_filter($request->all()),$contact['id']);
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }
    /***************************  delete contact  **************************/
    public function destroy(Request $request,$id)
    {
        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $this->contact->delete($d);
                }
            }
        }else {
            $role = $this->contact->find($id);
            $this->contact->delete($role['id']);
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

}
