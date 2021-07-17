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

class OrderProviderDatatable extends DataTable
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
            ->addColumn('control',function ($query){
                return '<a href="'.route('seller.showOrders',$query['id']).'" class="btn-table">'.awtTrans('عرض التفاصيل').'</a>';
            })
            ->addColumn('total',function ($query){
                return $query->_price();
            })
            ->addColumn('client_image',function ($query){
                if($query['client_image'] == '/default.png' || $query['client_image'] == null){
                    return  '<img src="'.dashboard_url('images/placeholder.png').'" >';
                }
                return  '<img src="'.dashboard_url('storage/images/users/'. $query['client_image']).'" >';
            })
            ->editColumn('pay_type',function ($query){
                return ($query['pay_type'] == 'online' ? awtTrans('أونلاين') : ($query['pay_type'] == 'cash' ? awtTrans('كاش') : '-'));
            })
            ->rawColumns(['client_image','total','control']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ClientDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        if(\Illuminate\Support\Facades\Route::currentRouteName() == 'seller.newOrders')
            return $model->query()->select('orders.*','providers.name as provider_name','clients.name as client_name','clients.avatar as client_image')
                ->join('users as clients','clients.id','=','orders.user_id')
                ->join('users as providers','providers.id','=','orders.provider_id')
                ->where('orders.status','confirmed')
                ->where('orders.provider_id',auth()->id())
                ->latest();
        elseif (\Illuminate\Support\Facades\Route::currentRouteName() == 'seller.acceptedOrders')
            return $model->query()->select('orders.*','providers.name as provider_name','clients.name as client_name','clients.avatar as client_image')
                ->join('users as clients','clients.id','=','orders.user_id')
                ->join('users as providers','providers.id','=','orders.provider_id')
                ->where('orders.status','approved')
                ->where('orders.provider_id',auth()->id())
                ->latest();
        elseif (\Illuminate\Support\Facades\Route::currentRouteName() == 'seller.onWorkOrders')
            return $model->query()->select('orders.*','providers.name as provider_name','clients.name as client_name','clients.avatar as client_image')
                ->join('users as clients','clients.id','=','orders.user_id')
                ->join('users as providers','providers.id','=','orders.provider_id')
                ->where('orders.status','under_work')
                ->latest();
        elseif (\Illuminate\Support\Facades\Route::currentRouteName() == 'seller.finishOrders')
            return $model->query()->select('orders.*','providers.name as provider_name','clients.name as client_name','clients.avatar as client_image')
                ->join('users as clients','clients.id','=','orders.user_id')
                ->join('users as providers','providers.id','=','orders.provider_id')
                ->where('orders.status','done')
                ->where('orders.provider_id',auth()->id())
                ->latest();
        elseif (\Illuminate\Support\Facades\Route::currentRouteName() == 'seller.cancelOrders')
            return $model->query()->select('orders.*','providers.name as provider_name','clients.name as client_name','clients.avatar as client_image')
                ->join('users as clients','clients.id','=','orders.user_id')
                ->join('users as providers','providers.id','=','orders.provider_id')
                ->where('orders.status','user_cancel')
                ->where('orders.provider_id',auth()->id())
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
                            [10,25,50,100],[10,25,50,100]
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
            Column::make('client_image')->title('صورة العميل'),
            Column::make('client_name')->title('اسم العميل'),
            Column::make('pay_type')->title('الدفع'),
            Column::make('total')->title('المبلغ'),
            Column::make('control')->title('التفاصيل')->orderable(false)->searchable(false),
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
