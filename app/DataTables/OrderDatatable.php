<?php

namespace App\DataTables;

use App\Entities\Order;
use App\Enum\OrderStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
            ->addIndexColumn()
            ->editColumn('sid',function ($query){
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
                    $data .= $orderService['title'] ? ' - '.$orderService['title'] : ' - '.$orderService->service['title'];
                }
                return $data;
            })
            ->addColumn('data',function ($query){
                return $query;
            })
            ->editColumn('final_total',function ($query){
                return $query->price();
            })
            ->addColumn('control','admin.partial.ControlOrder')
            ->rawColumns(['services','status','control','sid']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ClientDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        $late45 = Carbon::now()->addMinute(45)->format('Y-m-d H:i');
        $late120 = Carbon::now()->addMinute(120)->format('Y-m-d H:i');
        return $model->query()
            ->where('status','!=',OrderStatus::REJECTED)
            ->whereHas('category')
            ->when(Route::currentRouteName() == 'admin.orders.index',function($q){
                $q->where('status',OrderStatus::CREATED);
                $q->where('technician_id',null);
            })
            ->when(Route::currentRouteName() == 'admin.orders.onWayOrders',function($q){
                $q->whereNotIn('status',[OrderStatus::CREATED,OrderStatus::FINISHED]);
                $q->where('technician_id','!=',null);
            })
            ->when(Route::currentRouteName() == 'admin.orders.finishedOrders',function($q){
                $q->where('status',OrderStatus::FINISHED);
                $q->where('technician_id','!=',null);
            })
            ->when(Route::currentRouteName() == 'admin.orders.canceledOrders',function($q){
                $q->where('status','user_cancel');
            })
            ->when(Route::currentRouteName() == 'admin.orders.delayedOrders',function($q){
                $q->where(function ($query) {
                    $query->where('created_date', '<', Carbon::now()->subMinutes(45)->toDateTimeString())->where('created_date', '>', Carbon::now()->subMinutes(120)->toDateTimeString());
                });
                $q->where('technician_id',null);
            })
            ->when(Route::currentRouteName() == 'admin.orders.timeOutOrders',function($q){
                $q->where(function ($query) {
                    $query->where('created_date', '<', Carbon::now()->subMinutes(120)->toDateTimeString());
                });
                $q->where('technician_id',null);
            })
            ->with(['orderServices','region','city','category','user'])
            ->where('live',1)
            ->orderBy('created_date','desc');


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
//            Column::make('sid')->title('')->orderable(false),
            Column::make('DT_RowIndex')->name('DT_RowIndex')->title('')->orderable(false),
            Column::make('order_num')->title('رقم الطلب'),
            Column::make('user.name')->title('اسم العميل'),
            Column::make('category.title.ar')->name('category.title->ar')->title('القسم'),
            Column::make('city.title.ar')->name('city.title->ar')->title('المدينه'),
            Column::make('region.title.ar')->name('region.title->ar')->title('المنطقه'),
            Column::make('date')->title('التاريخ'),
            Column::make('time')->title('الوقت'),
            Column::make('services')->title('الخدمات'),
            Column::make('final_total')->title('الاجمالي بالضريبه'),
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
