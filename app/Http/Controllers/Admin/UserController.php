<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;
use App\DataTables\UsersDataTable;
use App\Models\User;
use Lang;

class UserController extends Controller
{
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->view_data['main_title'] = Lang::get('admin_messages.navigation.manage_users');
        $this->view_data['sub_title'] = Lang::get('admin_messages.navigation.users');
        $this->view_data['active_menu'] = 'users';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('admin.users.view',$this->view_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->view_data['sub_title'] = Lang::get('admin_messages.users.add_user');
        $this->view_data['result'] = new User;
        $this->view_data['countries'] = resolve("Country")->map(function($country) {
            return [
                'name' => $country->name,
                'value' => $country->full_name.' (+'.$country->phone_code.')',
            ];
        })->pluck('value','name');
        return view('admin.users.add', $this->view_data);
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

        $validated = $request->only(['first_name', 'last_name', 'password', 'phone_number','email', 'status']);
        $validated['country_code'] = $request->country_code ?? '';
        $user = User::create($validated);

        if($request->hasFile('profile_picture')) {
            $image_handler = resolve('App\Contracts\ImageHandleInterface');
            $image_data['name_prefix'] = 'user_'.$user->id;
            $image_data['add_time'] = false;
            $image_data['target_dir'] = $user->getUploadPath();
            $image_data['image_size'] = $user->getImageSize();

            if(DELETE_STORAGE && $user->src != '' && $user->photo_source == 'Site') {
                $image_data['name'] = $user->src;
                $handler = $user->getImageHandler();
                $handler->destroy($image_data);
            }

            $upload_result = $image_handler->upload($request->file('profile_picture'),$image_data);
            if(!$upload_result['status']) {
                flashMessage('danger',Lang::get('admin_messages.common.failed'),Lang::get('admin_messages.errors.failed_to_upload_image'));
                return redirect()->route('admin.users');
            }
            $user->src = $upload_result['file_name'];
            $user->photo_source = 'Site';
            $user->upload_driver = $upload_result['upload_driver'];
        }

        $user->save();
        $user_info = $user->user_information;
        $user_info->dob = $request->dob;
        $user_info->gender = $request->gender;
        $user_info->save();

        flashMessage('success',Lang::get('admin_messages.common.success'),Lang::get('admin_messages.common.successfully_added'));
        return redirect()->route('admin.users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->view_data['sub_title'] = Lang::get('admin_messages.users.edit_user');
        $this->view_data['result'] = User::findOrFail($id);
        $this->view_data['countries'] = resolve("Country")->map(function($country) {
            return [
                'name' => $country->name,
                'value' => $country->full_name.' (+'.$country->phone_code.')',
            ];
        })->pluck('value','name');
        return view('admin.users.edit', $this->view_data);
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

        $user = User::Find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        if($request->filled('password')) {
            $user->password = $request->password;
        }
        $user->country_code = $request->country_code ?? '';
        $user->phone_number = $request->phone_number;
        $user->status = $request->status;
        $user->save();

        if($request->hasFile('profile_picture')) {
            $image_handler = resolve('App\Contracts\ImageHandleInterface');
            $image_data['name_prefix'] = 'user_'.$user->id;
            $image_data['add_time'] = false;
            $image_data['target_dir'] = $user->getUploadPath();
            $image_data['image_size'] = $user->getImageSize();

            if(DELETE_STORAGE && $user->src != '' && $user->photo_source == 'Site') {
                $image_data['name'] = $user->src;
                $handler = $user->getImageHandler();
                $handler->destroy($image_data);
            }

            $upload_result = $image_handler->upload($request->file('profile_picture'),$image_data);
            if(!$upload_result['status']) {
                flashMessage('danger',Lang::get('admin_messages.common.failed'),Lang::get('admin_messages.errors.failed_to_upload_image'));
                return redirect()->route('admin.users');
            }
            $user->src = $upload_result['file_name'];
            $user->photo_source = 'Site';
            $user->upload_driver = $upload_result['upload_driver'];
        }
        $user->verification_status = $request->verification_status;
        if($user->verification_status == 'resubmit') {
            $user->resubmit_reason = $request->resubmit_reason;
        }
        $user->save();

        $user_info = $user->user_information;
        $user_info->dob = $request->dob;
        $user_info->gender = $request->gender;
        $user_info->save();

        if($user->phone_number == '') {
            $user_verification = $user->user_verification;
            $user_verification->phone_number = 0;
            $user_verification->save();
        }

        flashMessage('success',Lang::get('admin_messages.common.success'),Lang::get('admin_messages.common.successfully_updated'));
        return redirect()->route('admin.users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $can_destroy = $this->canDestroy($id);
        
        if(!$can_destroy['status']) {
            flashMessage('danger',Lang::get('admin_messages.common.failed'),$can_destroy['status_message']);
            return redirect()->route('admin.users');
        }
        
        try {
            User::find($id)->delete();
            flashMessage('success',Lang::get('admin_messages.common.success'),Lang::get('admin_messages.common.successfully_deleted'));
        }
        catch (\Exception $e) {
            flashMessage('danger',Lang::get('admin_messages.common.failed'),$e->getMessage());            
        }
        return redirect()->route('admin.users');
    }

    /**
     * Check the specified resource Can be deleted or not.
     *
     * @param  int  $id
     * @return Array
     */
    protected function canDestroy($id)
    {
        $reservation_count = \App\Models\Reservation::where(function($query) use($id) {
            $query->where('user_id',$id)->orWhere('host_id',$id);
        })->count();
        if($reservation_count > 0) {
            return ['status' => false,'status_message' => Lang::get('admin_messages.errors.this_user_has_some_reservation')];    
        }
        
        $room_count = \App\Models\Room::where('user_id',$id)->count();
        if($room_count > 0) {
            return ['status' => false,'status_message' => Lang::get('admin_messages.errors.this_user_has_some_reservation')];
        }

        $referral_count = \App\Models\ReferralUser::where('user_id',$id)->orWhere('referral_user_id',$id)->count();
        if($referral_count > 0) {
            return ['status' => false,'status_message' => Lang::get('admin_messages.errors.this_user_has_some_referral')];
        }
        
        return ['status' => true,'status_message' => Lang::get('admin_messages.common.success')];
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
        $password_rule = Password::min(8)->mixedCase()->numbers()->uncompromised();
        $rules = array(
            'first_name' => ['required','max:20'],
            'last_name' => ['required','max:20'],
            'email' => ['required','email','unique:users,email,'.$id],
            'password' => ['required',$password_rule],
            'country_code' => ['nullable','exists:countries,name'],
            'phone_number' => ['nullable','numeric','unique:users,phone_number,'.$id],
            'dob' => ['required'],
            'gender' => ['required'],
            'profile_picture' => ['mimes:'.view()->shared('valid_mimes')],
            'status' => ['required'],
        );

        if($id != '') {
            $rules['password'] = ['nullable',$password_rule];
        }

        $attributes = array(
            'first_name' => Lang::get('admin_messages.fields.first_name'),
            'last_name' => Lang::get('admin_messages.fields.last_name'),
            'email' => Lang::get('admin_messages.fields.email'),
            'password' => Lang::get('admin_messages.fields.password'),
            'country_code' => Lang::get('admin_messages.fields.country_code'),
            'phone_number' => Lang::get('admin_messages.fields.phone_number'),
            'dob' => Lang::get('admin_messages.fields.dob'),
            'gender' => Lang::get('admin_messages.fields.gender'),
            'profile_picture' => Lang::get('admin_messages.fields.profile_picture'),
            'status' => Lang::get('admin_messages.fields.status'),
        );

        $this->validate($request_data,$rules,[],$attributes);
    }
}