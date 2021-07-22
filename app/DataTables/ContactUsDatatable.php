<?php

namespace App\DataTables;

use App\Entities\ContactUs;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ContactUsDatatable extends DataTable
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
            ->addColumn('url',function ($query){
                return 'admin.contacts.destroy';
            })
            ->addColumn('data',function ($query){
                return $query;
            })
            ->editColumn('created_at',function ($query){
                return date('Y-m-d H:i a',strtotime($query['created_at']));
            })
            ->addColumn('control','admin.partial.ControlContact')
            ->rawColumns(['control','id']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ClientDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ContactUs $model)
    {
        return $model->query()->latest();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('contactusdatatable-table')
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
            Column::make('email')->title('البريد الالكتروني'),
            Column::make('seen')->title('حالة الرسالة'),
            Column::make('created_at')->title('وقت التسجيل'),
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
        return 'ContactUs_' . date('YmdHis');
    }
}
