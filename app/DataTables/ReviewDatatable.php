<?php

namespace App\DataTables;

use App\Entities\Report;
use App\Entities\ReviewRate;
use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReviewDatatable extends DataTable
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
            ->editColumn('rate',function ($query){
                return '<div class="Stars" style="--rating: '.($query['rate'] ?? 0).'"></div>';
            })
            ->addColumn('showModel',function (){
                return 'showModel';
            })
            ->addColumn('data',function ($query){
                return $query;
            })
            ->addColumn('control','admin.partial.ControlView')
            ->rawColumns(['control','rate']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ClientDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ReviewRate $model)
    {
        return $model->query()
            ->select('review_rates.id as id','review_rates.rate as rate','review_rates.comment as comment','review_rates.created_at as created_at','orders.order_num as order_num','users.name as name','users.phone as phone')
            ->leftJoin('orders','orders.id','review_rates.order_id')
            ->leftJoin('users',function ($in){
                $in->on('review_rates.rateable_id','users.id');
                $in->where('review_rates.rateable_type',User::class);
            })
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
                    ->setTableId('reviewdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
                    ->parameters([
                        'lengthMenu' => [
                            [10,25,50,100,-1],[10,25,50,100,'?????? ????????']
                        ],
                        'buttons' => [
                            ['extend' => 'excel','className' => 'btn btn-success' , 'text' => '?????? Excel'],
                            ['extend' => 'print','className' => 'btn btn-inverse' , 'text' => '??????????'],
                            ['extend' => 'copy','className' => 'btn btn-success' , 'text' => '??????'],
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
            Column::make('name')->name('users.name')->title('?????? ????????????'),
            Column::make('phone')->name('users.phone')->title('?????? ????????????'),
            Column::make('order_num')->name('orders.order_num')->title('?????? ??????????'),
            Column::make('rate')->name('review_rates.rate')->title('??????????????'),
            Column::make('created_at')->name('review_rates.created_at')->title('?????????? ??????????????'),
            Column::make('control')->title('????????????')->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Report_' . date('YmdHis');
    }
}
