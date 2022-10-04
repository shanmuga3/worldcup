<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use App\Models\User;
use Lang;

class UsersDataTable extends DataTable
{
    protected $type = 'user';

    public function setFilter($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
        ->addColumn('guesses',function($query) {
            $guess = \DB::Table('guesses')->where('user_id',$query->id)->count();
            return $guess;
        })
        ->addColumn('correct',function($query) {
            $guess = \DB::Table('guesses')->where('answer',1)->where('score','>',0)->where('user_id',$query->id)->count();
            return $guess;
        })
        ->addColumn('wrong',function($query) {
            $guess = \DB::Table('guesses')->where('answer',1)->where('score',0)->where('user_id',$query->id)->count();
            return $guess;
        })
        ->addColumn('phone_number',function($query) {
            return $query->phone_code.ltrim($query->phone_number,'05');
        })
        ->addColumn('city',function($query) {
            return $query->city_name;
        })
        ->addColumn('action',function($query) {
            $edit = auth()->guard('admin')->user()->can('update-users') ? '<a href="'.route('admin.users.edit',['id' => $query->id]).'" class=""> <i class="fa fa-edit"></i> </a>' : '';
            $delete = auth()->guard('admin')->user()->can('delete-users') ? '<a href="" data-action="'.route('admin.users.delete',['id' => $query->id]).'" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"> <i class="fa fa-times"></i> </a>' : '';
            $login = auth()->guard('admin')->user()->can('update-users') ? '<a href="'.route('admin.users.login',['id' => $query->id]).'" target="_blank" class="'.(env('SHOW_CREDENTIALS') ? "":"d-none").'"> <i class="fa fas fa-sign-in-alt"></i> </a>' : '';
            return '<div class="d-flex"> '.$edit.' &nbsp; '.$delete.' &nbsp; '.$login.'</div>';
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
        if($this->type == 'ranking') {
            $query = $model->whereHas('guesses')->orderByDesc('score')->get();
            return $query;
        }
        return $model->select();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $order_col = $this->type == 'ranking' ? 5 : 0;
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction()
                    ->orderBy($order_col)
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $cols = [
            ['data' => 'id', 'name' => 'id', 'title' => Lang::get('admin_messages.fields.id')],
            ['data' => 'first_name', 'name' => 'first_name', 'title' => Lang::get('messages.name')],
            ['data' => 'email', 'name' => 'email', 'title' => Lang::get('messages.email')],
            ['data' => 'phone_number', 'name' => 'phone_number', 'title' => Lang::get('messages.phone_number')],
        ];

        if($this->type != 'ranking') {
            $cols[] = ['data' => 'city', 'name' => 'city', 'title' => Lang::get('messages.city')];
            $cols[] = ['data' => 'address', 'name' => 'address', 'title' => Lang::get('messages.address')];
            $cols[] = ['data' => 'gender', 'name' => 'gender', 'title' => Lang::get('messages.gender')];
            $cols[] = ['data' => 'dob', 'name' => 'dob', 'title' => Lang::get('messages.dob')];
        }

        $cols[] = ['data' => 'guesses', 'name' => 'guesses', 'title' => Lang::get('messages.guesses')];
        $cols[] = ['data' => 'score', 'name' => 'score', 'title' => Lang::get('messages.score')];

        if($this->type == 'ranking') {
            $cols[] = ['data' => 'correct', 'name' => 'correct', 'title' => Lang::get('messages.correct')];
            $cols[] = ['data' => 'wrong', 'name' => 'wrong', 'title' => Lang::get('messages.wrong')];
        }

        $cols[] = ['data' => 'status', 'name' => 'status', 'title' => Lang::get('admin_messages.fields.status')];
        return $cols;
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