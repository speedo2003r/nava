<?php

namespace App\DataTables;

use App\Entities\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderDatatable extends DataTable
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
                return 'admin.orders.destroy';
            })
            ->addColumn('show',function ($query){
                return 'admin.orders.show';
            })
            ->addColumn('services',function ($query){
                $data = '';
                foreach ($query->orderServices as $orderService){
                    $data .= $orderService['title'] ? $orderService['title'] : $orderService->service['title'];
                }
                return $data;
            })
            ->addColumn('data',function ($query){
                return $query;
            })
            ->editColumn('final_total',function ($query){
                return $query->_price();
            })
            ->addColumn('control','admin.partial.ControlOrder')
            ->rawColumns(['services','status','control','id']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ClientDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        return $model->query()
            ->select('orders.*','users.name','cities.title->ar as city_title','regions.title->ar as region_title')
            ->leftJoin('users','users.id','=','orders.user_id')
            ->leftJoin('cities','cities.id','=','orders.city_id')
            ->leftJoin('regions','regions.id','=','orders.region_id')
            ->with('orderServices')
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
                    ->setTableId('orderdatatable-table')
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
            Column::make('order_num')->title('رقم الطلب'),
            Column::make('name')->name('users.name')->title('اسم العميل'),
            Column::make('city_title')->name('city_title')->title('المدينه'),
            Column::make('region_title')->name('region_title')->title('المنطقه'),
            Column::make('services')->title('الخدمات'),
            Column::make('final_total')->title('الاجمالي بدون الضريبه'),
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
