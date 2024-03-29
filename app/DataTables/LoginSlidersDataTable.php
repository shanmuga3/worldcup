<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use App\Models\LoginSlider;
use Lang;

class LoginSlidersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
        ->addColumn('status', function($query) {
            return getStatusText($query->status);
        })
        ->addColumn('image', function ($query) {
            return '<img class="dt-thumb-image" src="'.$query->image_src.'">';
        })
        ->addColumn('action',function($query) {
            $edit = auth()->guard('admin')->user()->can('update-login_sliders') ? '<a href="'.route('admin.login_sliders.edit',['id' => $query->id]).'" class=""> <i class="fa fa-edit"></i> </a>' : '';
            $delete = auth()->guard('admin')->user()->can('delete-login_sliders') ? '<a href="" data-action="'.route('admin.login_sliders.delete',['id' => $query->id]).'" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"> <i class="fa fa-times"></i> </a>' : '';
            return $edit." &nbsp; ".$delete;
        })
        ->rawColumns(['image','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param LoginSlider $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LoginSlider $model)
    {
        return $model->select();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction()
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['data' => 'order_id', 'name' => 'order_id', 'title' => Lang::get('admin_messages.fields.order_id')],
            ['data' => 'image', 'name' => 'image', 'title' => Lang::get('admin_messages.fields.image'),'searchable' => false],
            ['data' => 'status', 'name' => 'status', 'title' => Lang::get('admin_messages.fields.status')],
        ];
    }

    /**
     * Get builder parameters.
     *
     * @return array
     */
    protected function getBuilderParameters()
    {
        return array(
            'dom' => config('datatables-buttons.parameters.dom'),
            'buttons' => config('datatables-buttons.parameters.buttons'),
        );
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'login_sliders_' . date('YmdHis');
    }
}