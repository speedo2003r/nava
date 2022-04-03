<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TechnicianDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('id',function ($query){
                return '<label class="custom-control material-checkbox" style="margin: auto">
                            <input type="checkbox" class="material-control-input checkSingle" id="'.$query->id.'">
                            <span class="material-control-indicator"></span>
                        </label>';
            })
            ->addColumn('status',function ($query){
                return '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success" style="direction: ltr">
                            <input type="checkbox" onchange="changeUserStatus('.$query->id.')" '.($query->banned == 0 ? 'checked' : '') .' class="custom-control-input" id="customSwitch'.$query->id.'">
                            <label class="custom-control-label" id="status_label'.$query->id.'" for="customSwitch'.$query->id.'"></label>
                        </div>';
            })
            ->addColumn('accounts',function ($query){
                return '<a href="'.route('admin.technicians.accounts',$query['id']).'" data-placement="top" data-original-title="المديونيه"  class="btn btn-info subs">('.($query['debtor'] ?? 0).') مديونيه</a>';
            })
            ->addColumn('data',function ($query){
                return $query;
            })
            ->addColumn('categories','admin.partial.ControlCats')
            ->addColumn('deductions',function ($query){
                return '<button type="button" data-user_id="'.$query['id'].'"  data-toggle="modal" data-target="#deductions"  data-placement="top" data-original-title="الخصومات"  class="btn btn-sm btn-clean btn-icon btn-icon-md dis"><i class="fa fa-percent"></i></button>';
            })
            ->addColumn('orders',function ($query){
                return '<a href="'.route("admin.technicians.orders",$query['id']).'"  class="btn btn-info" data-placement="top" data-original-title="الطلبات"  class="btn btn-sm btn-clean btn-icon btn-icon-md dis">الطلبات</a>';
            })
            ->addColumn('url',function ($query){
                return 'admin.technicians.delete';
            })
            ->addColumn('target',function ($query){
                return 'editModel';
            })
            ->addColumn('control','admin.partial.Control')
            ->rawColumns(['data','orders','accounts','deductions','categories','status','control','id']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ClientDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->query()
            ->select('users.*',DB::raw('SUM(incomes.income) as techIncome'),DB::raw('SUM(incomes.debtor) as debtor'))
            ->leftJoin('incomes',function ($in){
                $in->on('incomes.user_id','=','users.id');
                $in->where('incomes.status',0);
            })
            ->groupBy('users.id')
            ->with('categories')->with('branches')->with('Technician')->where('company_id',null)->where('user_type','technician')->latest();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('clientdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Blfrtip')
            ->parameters([
                'lengthMenu' => [
                    [10,25,50,100,-1],[10,25,50,100,'عرض الكل']
                ],
                'buttons' => [
                    ['extend' => 'excel','className' => 'btn btn-success' , 'text' => 'ملف Excel'],
                    ['extend' => 'print','className' => 'btn btn-inverse' , 'text' => 'طباعه'],
                    ['extend' => 'copy','className' => 'btn btn-success' , 'text' => 'نسخ'],
                ],
                "language" =>  datatableTrans(),
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title('')->orderable(false),
            Column::make('name')->title('الاسم'),
            Column::make('status')->title('الحاله')->searchable(false),
            Column::make('balance')->searchable(false)->title('المديونيه'),
            Column::make('v_code')->title('OTP'),
            Column::make('email')->title('البريد الالكتروني'),
            Column::make('orders')->title('الطلبات'),
            Column::make('accounts')->title('كشف حساب'),
            Column::make('deductions')->title('الخصومات'),
            Column::make('categories')->title('التخصصات'),
            Column::make('wallet')->title('المحفظه'),
            Column::make('techIncome')->searchable(false)->title('المدخول'),
            Column::make('phone')->title('الهاتف'),
            Column::make('control')->title('التحكم')->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Client_' . date('YmdHis');
    }
}
