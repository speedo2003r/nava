<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TechnicianCompanyDatatable extends DataTable
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
            ->addColumn('url',function ($query){
                return 'admin.technicians.delete';
            })
            ->addColumn('categories',function ($query){
                return '<button type="button" data-user_id="'.$query['id'].'" data-perms='.$query->categories.'  data-toggle="modal" data-target="#categories-modal"  data-placement="top" data-original-title="التخصصات"  class="btn btn-sm btn-clean btn-icon btn-icon-md subs"><i class="fa fa-bars"></i></button>';
            })
            ->addColumn('target',function ($query){
                return 'editModel';
            })
            ->addColumn('data',function ($query){
                return $query;
            })
            ->addColumn('control','admin.partial.ControlNotify')
            ->rawColumns(['categories','status','control','id']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ClientDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->query()->where('company_id',$this->id)->with('Technician')->where('company_id','!=',null)->where('user_type','technician')->latest();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('techniciancompanydatatable-table')
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
            Column::make('balance')->title('المديونيه'),
            Column::make('email')->title('البريد الالكتروني'),
            Column::make('categories')->title('التخصصات'),
            Column::make('wallet')->title('المحفظه'),
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
