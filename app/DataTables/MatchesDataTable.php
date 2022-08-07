<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use App\Models\TeamMatch;
use Lang;

class MatchesDataTable extends DataTable
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
        ->addColumn('first_team', function($query) {
            return '<a href="'.route('admin.teams.edit',['id' => $query->first_team_id]).'" class="link" target="_blank"> '.$query->first_team->short_name.' </a>';
        })
        ->addColumn('second_team', function($query) {
            return '<a href="'.route('admin.teams.edit',['id' => $query->second_team_id]).'" class="link" target="_blank"> '.$query->second_team->short_name.' </a>';
        })
        ->addColumn('answer', function($query) {
            return getYesNoText($query->answer);
        })
        ->addColumn('action',function($query) {
            $edit = auth()->guard('admin')->user()->can('update-matches') ? '<a href="'.route('admin.matches.edit',['id' => $query->id]).'" class=""> <i class="fa fa-edit"></i> </a>' : '';
            $delete = auth()->guard('admin')->user()->can('delete-matches') ? '<a href="" data-action="'.route('admin.matches.delete',['id' => $query->id]).'" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"> <i class="fa fa-times"></i> </a>' : '';
            return $edit." &nbsp; ".$delete;
        })
        ->rawColumns(['first_team','second_team','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param TeamMatch $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TeamMatch $model)
    {
        return $model->with('first_team','second_team')->select();
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
            ['data' => 'first_team', 'name' => 'first_team', 'title' => Lang::get('admin_messages.matches.first_team')],
            ['data' => 'second_team', 'name' => 'second_team', 'title' => Lang::get('admin_messages.matches.second_team')],
            ['data' => 'round', 'name' => 'round', 'title' => Lang::get('admin_messages.matches.round')],
            ['data' => 'match_time', 'name' => 'match_time', 'title' => Lang::get('admin_messages.matches.match_time')],
            ['data' => 'starting_at', 'name' => 'starting_at', 'title' => Lang::get('admin_messages.matches.starting_at')],
            ['data' => 'ending_at', 'name' => 'ending_at', 'title' => Lang::get('admin_messages.matches.ending_at')],
            ['data' => 'answer', 'name' => 'answer', 'title' => Lang::get('admin_messages.matches.answer')],
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
        return 'matches_' . date('YmdHis');
    }
}