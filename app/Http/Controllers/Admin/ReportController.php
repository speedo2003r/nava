<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ReportDatatable;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IReport;
use App\Repositories\ReportRepository;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $report;

    public function __construct(ReportRepository $report)
    {
        $this->report = $report;
    }

    /***************************  get all reports  **************************/
    public function index(ReportDatatable $reportDatatable)
    {
        $reports = $this->report->all();
        return $reportDatatable->render('admin.reports.index', compact('reports'));
    }

    /***************************  delete report  **************************/
    public function destroy(Request $request,$id)
    {
        $user = auth()->user();
        if($user['user_type'] == 'operation'){
            return back()->with('danger','ليس لديك الصلاحيه للحذف');
        }
        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $this->report->delete($d);
                }
            }
        }else {
            $role = $this->report->find($id);
            $this->report->delete($role['id']);
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

}
