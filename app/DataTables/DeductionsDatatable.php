<?php

namespace App\DataTables;

use App\Entities\UserDeduction;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DeductionsDatatable extends DataTable
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
            ->addColumn('url',function ($query){
                return 'admin.deduction.delete';
            })
            ->addColumn('target',function ($query){
                return 'editModel';
            })
            ->addColumn('data',function ($query){
                return $query;
            })
//            ->addColumn('control','admin.partial.ControlEditDel')
            ->rawColumns(['status','control','id']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ClientDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(UserDeduction $model)
    {
        return $model->query()
            ->select('user.name as user_name','admin.name as admin_name','user_deductions.balance','user_deductions.notes','user_deductions.id','user_deductions.created_at')
            ->leftJoin('users as admin','admin.id','=','user_deductions.admin_id')
            ->leftJoin('users as user','user.id','=','user_deductions.user_id')
            ->latest();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('deductiondatatable-table')
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
            Column::make('user_name')->title('اسم الشخص'),
            Column::make('admin_name')->title('اسم المسئول'),
            Column::make('balance')->title('الخصم'),
            Column::make('notes')->title('السبب'),
//            Column::make('control')->title('التحكم')->orderable(false)->searchable(false),
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
