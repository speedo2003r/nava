<?php

namespace App\DataTables;

use App\Entities\Complaint;
use App\Entities\ContactUs;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RoomDatatable extends DataTable
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
                return 'admin.chats.destroy';
            })
            ->addColumn('data',function ($query){
                return $query;
            })
            ->addColumn('show',function ($query){
                return 'admin.chats.room';
            })
            ->editColumn('created_at',function ($query){
                return date('Y-m-d H:i a',strtotime($query['created_at']));
            })
            ->addColumn('control','admin.partial.ControlChat')
            ->rawColumns(['control','id']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ClientDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Room $model)
    {
        return $model->query()
            ->select('rooms.id','rooms.order_id','users.name','orders.order_num','rooms.created_at')
            ->leftJoin('users','users.id','=','rooms.other_user_id')
            ->leftJoin('orders','rooms.order_id','=','orders.id')
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
                    ->setTableId('roomdatatable-table')
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
            Column::make('order_num')->name('orders.order_num')->title('رقم الطلب'),
            Column::make('name')->name('users.name')->title('اسم العميل'),
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
