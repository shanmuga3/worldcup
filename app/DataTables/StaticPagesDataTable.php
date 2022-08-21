<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use App\Models\StaticPage;
use Lang;

class StaticPagesDataTable extends DataTable
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
        ->addColumn('in_footer', function($query) {
            return getYesNoText($query->in_footer);
        })
        ->addColumn('action',function($query) {
            $preview = '<a href="'.route('static_page',['slug' => $query->slug]).'" target="_new"> <i class="fa fa-eye"></i> </a>';
            $edit = '<a href="'.route('admin.static_pages.edit',['id' => $query->id]).'" class=""> <i class="fa fa-edit"></i> </a>';
            $delete = '<a href="" data-action="'.route('admin.static_pages.delete',['id' => $query->id]).'" class="" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"> <i class="fa fa-times"></i> </a>';
            return $preview." &nbsp; ".$edit." &nbsp; ".$delete;
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param StaticPage $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(StaticPage $model)
    {
        return $model->get();
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
            ['data' => 'id', 'name' => 'id', 'title' => Lang::get('admin_messages.fields.id')],
            ['data' => 'name', 'name' => 'static_pages.name', 'title' => Lang::get('admin_messages.fields.name')],
            ['data' => 'in_footer', 'name' => 'in_footer', 'title' => Lang::get('admin_messages.fields.footer')],
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
        return 'pages_' . date('YmdHis');
    }
}