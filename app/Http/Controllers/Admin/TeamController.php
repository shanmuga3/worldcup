<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\TeamsDataTable;
use App\Models\Team;
use Lang;

class TeamController extends Controller
{
	/**
	* Constructor
	*
	*/
	public function __construct()
	{
		$this->view_data['main_title'] = Lang::get('admin_messages.teams.manage_teams');
		$this->view_data['sub_title'] = Lang::get('admin_messages.navigation.teams');
		$this->view_data['active_menu'] = 'teams';
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(TeamsDataTable $dataTable)
	{
		return $dataTable->render('admin.teams.view',$this->view_data);
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$this->view_data['sub_title'] = Lang::get('admin_messages.teams.add_slider');
		$this->view_data['result'] = $result = new Team;
		return view('admin.teams.add', $this->view_data);
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

		$login_slider = new Team;

		$upload_result = $this->uploadImage($request->file('image'),$login_slider->getUploadPath());
		if(!$upload_result['status']) {
			flashMessage('danger',Lang::get('admin_messages.common.failed'),Lang::get('admin_messages.errors.failed_to_upload_image'));
			return redirect()->route('admin.teams');
		}

		$login_slider->order_id = $request->order_id;
		$login_slider->image = $upload_result['file_name'];
		$login_slider->upload_driver = $upload_result['upload_driver'];
		$login_slider->status = $request->status;

		$login_slider->save();

		flashMessage('success',Lang::get('admin_messages.common.success'),Lang::get('admin_messages.common.successfully_added'));
		return redirect()->route('admin.teams');
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$this->view_data['sub_title'] = Lang::get('admin_messages.teams.edit_slider');
		$this->view_data['result'] = $result = Team::findOrFail($id);
		return view('admin.teams.edit', $this->view_data);
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

		$login_slider = Team::findOrFail($id);
		$login_slider->order_id = $request->order_id;
		$login_slider->status = $request->status;
		
		if($request->hasFile('image')) {
			$login_slider->deleteImageFile();

			$upload_result = $this->uploadImage($request->file('image'),$login_slider->filePath);
			if(!$upload_result['status']) {
				flashMessage('danger',Lang::get('admin_messages.common.failed'),Lang::get('admin_messages.errors.failed_to_upload_image'));
				return redirect()->route('admin.teams');
			}

			$login_slider->image = $upload_result['file_name'];
			$login_slider->upload_driver = $upload_result['upload_driver'];
		}

		$login_slider->save();
		
		flashMessage('success',Lang::get('admin_messages.common.success'),Lang::get('admin_messages.common.successfully_updated'));
		return redirect()->route('admin.teams');
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id)
	{
		$login_slider = Team::findOrFail($id);
		$can_destroy = $this->canDestroy($id);
		if($can_destroy['status']) {
			$login_slider->deleteImageFile();
			$login_slider->delete();
		}

		flashMessage('success',Lang::get('admin_messages.common.success'),Lang::get('admin_messages.common.successfully_deleted'));
		
		return redirect()->route('admin.teams');
	}

	/**
	 * Upload Given Image to Server
	 *
	 * @return Array Upload Result
	 */
	protected function uploadImage($image,$target_dir)
	{
		$image_handler = resolve('App\Contracts\ImageHandleInterface');
		$image_data = array();
		$image_data['name_prefix'] = 'admin_slider_';
		$image_data['add_time'] = true;
		$image_data['target_dir'] = $target_dir;

		return $image_handler->upload($image,$image_data);
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