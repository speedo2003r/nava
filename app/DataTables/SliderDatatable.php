<?php

namespace App\DataTables;

use App\Entities\Slider;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SliderDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query,Request $request)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('id',function ($query){
                return '<label class="custom-control material-checkbox" style="margin: auto">
                            <input type="checkbox" class="material-control-input checkSingle" id="'.$query->id.'">
                            <span class="material-control-indicator"></span>
                        </label>';
            })
            ->editColumn('active',function ($query){
                return '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success" style="direction: ltr">
                            <input type="checkbox" onchange="changeActive('.$query->id.')" '.($query->active == 1 ? 'checked' : '') .' class="custom-control-input" id="customSwitch'.$query->id.'">
                            <label class="custom-control-label" id="status_label'.$query->id.'" for="customSwitch'.$query->id.'"></label>
                        </div>';
            })
            ->editColumn('image',function ($query){
                return '<div style="width: 140px;height: 140px"><a href="'.$query['image'].'"  data-fancybox data-caption="'.$query['image'].'" ><img src="'.$query['image'].'" style="border-radius: 50%;width: 100%;height: 100%"></a></div>';
            })
            ->addColumn('url',function ($query){
                return 'admin.sliders.destroy';
            })
            ->addColumn('data',function ($query){
                return $query;
            })
            ->addColumn('target',function ($query){
                return 'editModel';
            })
            ->editColumn('created_at',function ($query){
                return date('Y-m-d H:i a',strtotime($query['created_at']));
            })
            ->addColumn('control','admin.partial.ControlEditDel')
            ->rawColumns(['target','image','active','control','id']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SliderDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Slider $model)
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
                    ->setTableId('sliderdatatable-table')
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
            Column::make('title')->title('الاسم'),
            Column::make('image')->title('الصوره'),
            Column::make('active')->title('نشط / غير نشط'),
            Column::make('created_at')->title('تاريخ الاضافه'),
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
