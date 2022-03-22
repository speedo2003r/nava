<?php

namespace App\DataTables;

use App\Entities\Order;
use App\Entities\OrderGuarantee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class GuaranteeDatatable extends DataTable
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
            ->addColumn('url',function ($query){
                return 'admin.orders.guaranteeDestroy';
            })
            ->addColumn('show',function ($query){
                return 'admin.orders.guaranteeShow';
            })
            ->addColumn('data',function ($query){
                return $query;
            })
            ->editColumn('solved',function ($query){
                if($query['solved'] == 1){
                    return awtTrans('تم الحل');
                }else{
                    return awtTrans('لم يتم الحل بعد');
                }
            })
            ->addColumn('control','admin.partial.ControlViewDel')
            ->rawColumns(['control']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ClientDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(OrderGuarantee $model)
    {
        return $model->query()->select('order_guarantees.id','order_guarantees.start_date','order_guarantees.end_date','order_guarantees.status','order_guarantees.solved','order_guarantees.updated_at','orders.order_num','users.name as name')
            ->leftJoin('orders','orders.id','=','order_guarantees.order_id')
            ->leftJoin('users','users.id','=','order_guarantees.technical_id')
            ->where('order_guarantees.status',1)
            ->where('order_guarantees.technical_id','!=',null)
            ->orderBy('updated_at','desc');

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
            Column::make('name')->title('اسم المندوب'),
            Column::make('start_date')->title('بداية الضمان'),
            Column::make('end_date')->title('نهاية الضمان'),
            Column::make('solved')->title('حل المشكله'),
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
