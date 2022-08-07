<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\MatchesDataTable;
use App\Models\Team;
use App\Models\TeamMatch;
use App\Models\Guess;
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
		$this->view_data['teams'] = Team::activeOnly()->get()->pluck('short_name','id');
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
		$match->round = $request->round;
		$match->match_time = $request->match_time;
		$match->first_team_score = $request->first_team_score;
		$match->second_team_score = $request->second_team_score;
		$match->first_team_penalty = $request->first_team_penalty;
		$match->second_team_penalty = $request->second_team_penalty;
		$match->starting_at = $request->starting_at;
		$match->ending_at = $request->ending_at;
		$match->answer = $request->answer;
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
		$this->view_data['teams'] = Team::activeOnly()->get()->pluck('short_name','id');
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
		if($match->answer != 0) {
			flashMessage('danger',Lang::get('admin_messages.common.failed'),Lang::get('admin_messages.errors.invalid_request'));
			return redirect()->route('admin.matches');
		}

		$match->first_team_id = $request->first_team;
		$match->second_team_id = $request->second_team;
		$match->round = $request->round;
		$match->match_time = $request->match_time;
		$match->first_team_score = $request->first_team_score;
		$match->second_team_score = $request->second_team_score;
		$match->first_team_penalty = $request->first_team_penalty;
		$match->second_team_penalty = $request->second_team_penalty;
		$match->starting_at = $request->starting_at;
		$match->ending_at = $request->ending_at;
		$match->answer = $request->answer;
		$match->save();

		$match = TeamMatch::findOrFail($id);
		if($match->answer == 1) {
			$guessess = Guess::with('user')->where('match_id',$match->id)->get();
			$guessess->each(function($guess) use($match) {
				$points = 0;
				if($match->first_team_score == $guess->first_team_score && $match->second_team_score == $guess->second_team_score) {
					if($match->first_team_penalty == $guess->first_team_penalty && $match->second_team_penalty == $guess->second_team_penalty) {
						if($match->round == '1') {
							$points = 10;
						}
						else if($match->round == '2') {
							$points = 20;
						}
						else if($match->round == '3') {
							$points = 30;
						}
						else if($match->round == '4') {
							$points = 50;
						}
						else if($match->round == '5') {
							$points = 100;
						}
					}
				}
				if($points > 0) {
					$user = $guess->user;
					$user->score += $points;
					$user->save();
				}
			});
		}
		
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
		$rules = array(
			'first_team' => 'required',
			'second_team' => 'required',
			'round' => 'required|min:1',
			'match_time' => 'required',
			'starting_at' => 'required',
			'ending_at' => 'required',
			'answer' => 'required|in:0,1',
		);
		$attributes = array(
			'first_team' => Lang::get('admin_messages.matches.first_team'),
			'second_team' => Lang::get('admin_messages.matches.second_team'),
			'round' => Lang::get('admin_messages.matches.round'),
			'match_time' => Lang::get('admin_messages.matches.match_time'),
			'first_team_score' => Lang::get('admin_messages.matches.first_team_score'),
			'second_team_score' => Lang::get('admin_messages.matches.second_team_score'),
			'first_team_penalty' => Lang::get('admin_messages.matches.first_team_penalty'),
			'second_team_penalty' => Lang::get('admin_messages.matches.second_team_penalty'),
			'starting_at' => Lang::get('admin_messages.matches.starting_at'),
			'ending_at' => Lang::get('admin_messages.matches.ending_at'),
			'answer' => Lang::get('admin_messages.matches.answer'),
		);

		if($request_data['answer'] == '1') {
			$rules['first_team_score'] = 'required|numeric|min:0';
			$rules['second_team_score'] = 'required|numeric|min:0';
			
			if($rules['first_team_score'] >= 0 && $request_data['first_team_score'] == $request_data['second_team_score']) {
				$rules['first_team_penalty'] = 'required|numeric|min:0';
				$rules['second_team_penalty'] = 'required|numeric|min:0';				
			}
		}

		$this->validate($request_data,$rules,[],$attributes);
	}
}