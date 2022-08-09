<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use App\Models\User;
use Lang;

class UsersDataTable extends DataTable
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
        ->addColumn('total',function($query) {
            $guess = \DB::Table('guesses')->where('user_id',$query->id)->count();
            return $guess;
        })
        ->addColumn('action',function($query) {
            $edit = auth()->guard('admin')->user()->can('update-users') ? '<a href="'.route('admin.users.edit',['id' => $query->id]).'" class=""> <i class="fa fa-edit"></i> </a>' : '';
            $delete = auth()->guard('admin')->user()->can('delete-users') ? '<a href="" data-action="'.route('admin.users.delete',['id' => $query->id]).'" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"> <i class="fa fa-times"></i> </a>' : '';
            return $edit." &nbsp; ".$delete;
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
                    ->orderBy(0)
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
            ['data' => 'first_name', 'name' => 'first_name', 'title' => Lang::get('admin_messages.fields.name')],
            ['data' => 'email', 'name' => 'email', 'title' => Lang::get('admin_messages.fields.email')],
            ['data' => 'phone_number', 'name' => 'phone_number', 'title' => Lang::get('admin_messages.fields.phone_number')],
            ['data' => 'total', 'name' => 'total', 'title' => Lang::get('messages.total')],
            ['data' => 'score', 'name' => 'score', 'title' => Lang::get('messages.score')],
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
        return 'users_' . date('YmdHis');
    }
}