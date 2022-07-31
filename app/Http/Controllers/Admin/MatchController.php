<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\MatchesDataTable;
use App\Models\Team;
use App\Models\TeamMatch;
use Lang;

class MatchController extends Controller
{
	/**
	* Constructor
	*
	*/
	public function __construct()
	{
		$this->view_data['main_title'] = Lang::get('admin_messages.matches.manage_matches');
		$this->view_data['sub_title'] = Lang::get('admin_messages.navigation.matches');
		$this->view_data['active_menu'] = 'matches';
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(MatchesDataTable $dataTable)
	{
		return $dataTable->render('admin.matches.view',$this->view_data);
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$this->view_data['sub_title'] = Lang::get('admin_messages.matches.add_match');
		$this->view_data['teams'] = Team::activeOnly()->get()->pluck('name','id');
		$this->view_data['result'] = $result = new TeamMatch;
		return view('admin.matches.add', $this->view_data);
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{
		$this->validateRequest($request);

		$match = new TeamMatch;
		$match->first_team_id = $request->first_team;
		$match->second_team_id = $request->second_team;
		$match->status = $request->status;
		$match->save();

		flashMessage('success',Lang::get('admin_messages.common.success'),Lang::get('admin_messages.common.successfully_added'));
		return redirect()->route('admin.matches');
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$this->view_data['sub_title'] = Lang::get('admin_messages.matches.edit_match');
		$this->view_data['teams'] = Team::activeOnly()->get()->pluck('name','id');
		$this->view_data['result'] = $result = TeamMatch::findOrFail($id);
		return view('admin.matches.edit', $this->view_data);
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, $id)
	{
		$this->validateRequest($request, $id);

		$match = TeamMatch::findOrFail($id);
		$match->first_team_id = $request->first_team;
		$match->second_team_id = $request->second_team;
		$match->status = $request->status;
		$match->save();
		
		flashMessage('success',Lang::get('admin_messages.common.success'),Lang::get('admin_messages.common.successfully_updated'));
		return redirect()->route('admin.matches');
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id)
	{
		$match = TeamMatch::findOrFail($id);
		$can_destroy = $this->canDestroy($id);
		if($can_destroy['status']) {
			$match->deleteImageFile();
			$match->delete();
		}

		flashMessage('success',Lang::get('admin_messages.common.success'),Lang::get('admin_messages.common.successfully_deleted'));
		
		return redirect()->route('admin.matches');
	}

	/**
	* Check the specified resource Can be deleted or not.
	*
	* @param  int  $id
	* @return Array
	*/
	protected function canDestroy($id)
	{
		return ['status' => true,'status_message' => ''];
	}

	/**
	* Check the specified resource Can be deleted or not.
	*
	* @param  Illuminate\Http\Request $request_data
	* @param  Int $id
	* @return Array
	*/
	protected function validateRequest($request_data, $id = '')
	{
		$image_rule = ($id == '') ? 'required|':'';
		$rules = array(
			'order_id'		=> 'required|integer|min:1',
			'image'			=> $image_rule.'mimes:'.view()->shared('valid_mimes'),
			'status'		=> 'required',
		);
		$attributes = array(
			'order_id'		=> Lang::get('admin_messages.fields.order_id'),
			'image'			=> Lang::get('admin_messages.fields.image'),
			'status'		=> Lang::get('admin_messages.fields.status'),
		);

		$this->validate($request_data,$rules,[],$attributes);
	}
}