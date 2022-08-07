<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use App\Models\Country;
use Lang;

class CountriesDataTable extends DataTable
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
        ->addColumn('action',function($query) {
            $edit = auth()->guard('admin')->user()->can('update-countries') ? '<a href="'.route('admin.countries.edit',['id' => $query->id]).'" class=""> <i class="fa fa-edit"></i> </a>' : '';
            $delete = auth()->guard('admin')->user()->can('delete-countries') ? '<a href="" data-action="'.route('admin.countries.delete',['id' => $query->id]).'" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"> <i class="fa fa-times"></i> </a>' : '';
            return $edit." &nbsp; ".$delete;
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Country $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Country $model)
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
            ['data' => 'id', 'name' => 'id', 'title' => Lang::get('admin_messages.id')],
            ['data' => 'name', 'name' => 'name', 'title' => Lang::get('admin_messages.name')],
            ['data' => 'full_name', 'name' => 'full_name', 'title' => Lang::get('admin_messages.full_name')],
            ['data' => 'iso3', 'name' => 'iso3', 'title' => Lang::get('admin_messages.iso3')],
            ['data' => 'phone_code', 'name' => 'phone_code', 'title' => Lang::get('admin_messages.phone_code')],
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
        return 'countries_' . date('YmdHis');
    }
}