<?php

namespace App\DataTables;

use App\Entities\Item;
use App\Entities\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ServiceDatatable extends DataTable
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
                return 'admin.services.edit';
            })
            ->addColumn('item_id',function ($query){
                return $query['id'];
            })
            ->addColumn('delete_url',function ($query){
                return 'admin.services.destroy';
            })
            ->editColumn('created_at',function ($query){
                return date('Y-m-d H:i:s',strtotime($query['created_at']));
            })
            ->addColumn('data',function ($query){
                return $query;
            })
            ->addColumn('status',function ($query){
                return '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success" style="direction: ltr">
                            <input type="checkbox" onchange="changeItemStatus('.$query->id.')" '.($query->active == 1 ? 'checked' : '') .' class="custom-control-input" id="customSwitch'.$query->id.'">
                            <label class="custom-control-label" id="status_label'.$query->id.'" for="customSwitch'.$query->id.'"></label>
                        </div>';
            })
            ->addColumn('item',function ($query){
                return '<img class="lazy" style="width: 100px;height:100px" src="'.($query->image).'" alt="">
                        <a href="#">
                            <h4 class="blue">
                                '.$query['title'].'
                            </h4>
                        </a>
                        <form>
                            <input id="_token" type="hidden" name="_token" value="'.Session::token().'"/>
                            <button data-id="'.$query['id'].'" type="submit" class="changeStar">
                                <i class="star'.$query->id.' fa '.($query->star == 1?'fa-star':'fa-star-o').'"></i>
                            </button>
                        </form>
                        <p>'.($query->price) .'</p>';
            })
            ->addColumn('control','admin.partial.ControlPag')
            ->rawColumns(['status','item_id','item','control','id']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ClientDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Service $model,Request $request)
    {
        if($request->query('user_id') != null)
            return $model->query()->select('services.*','users.name as store_name')
                ->leftJoin('users','users.id','=','services.user_id')
                ->where('services.user_id',$request->query('user_id'))
                ->latest();
            else
                return $model->query()->select('services.*','users.name as store_name')
                    ->leftJoin('users','users.id','=','services.user_id')
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
                    ->setTableId('servicedatatable-table')
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
            Column::make('item_id')->title('ID'),
            Column::make('item')->title('الخدمه'),
            Column::make('status')->title('الحاله'),
            Column::make('store_name')->name('users.name')->title('البائع'),
            Column::make('created_at')->title('التاريخ'),
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
