<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use App\Models\Credential;
use App\Models\User;
use App\Mail\Admin\CustomMail;

class EmailController extends Controller
{
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        if(request()->route() && request()->route()->getName() == 'admin.email_to_users') {
            $this->view_data['main_title']  = Lang::get('admin_messages.navigation.email_to_users');
            $this->view_data['active_menu'] = 'email_to_users';
            $this->view_data['sub_title']   = Lang::get('admin_messages.navigation.email_to_users');
        }
        else {
            $this->view_data['main_title']  = Lang::get('admin_messages.email_config.manage_email_config');
            $this->view_data['active_menu'] = 'email_configurations';
            $this->view_data['sub_title']   = Lang::get('admin_messages.email_config.manage_email_config');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.email_config.edit', $this->view_data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validateRequest($request);

        Credential::where(['site' => 'EmailConfig', 'name' => 'driver'])->update(['value' => $request->driver]);
        Credential::where(['site' => 'EmailConfig', 'name' => 'host'])->update(['value' => $request->host]);
        Credential::where(['site' => 'EmailConfig', 'name' => 'port'])->update(['value' => $request->port]);
        Credential::where(['site' => 'EmailConfig', 'name' => 'from_address'])->update(['value' => $request->from_address]);
        Credential::where(['site' => 'EmailConfig', 'name' => 'from_name'])->update(['value' => $request->from_name]);
        Credential::where(['site' => 'EmailConfig', 'name' => 'encryption'])->update(['value' => $request->encryption]);
        Credential::where(['site' => 'EmailConfig', 'name' => 'username'])->update(['value' => $request->username]);
        Credential::where(['site' => 'EmailConfig', 'name' => 'password'])->update(['value' => $request->app_password]);

        flashMessage('success',Lang::get('admin_messages.common.success'), Lang::get('admin_messages.common.successfully_updated'));
        return redirect()->route('admin.email_configurations');
    }

    /**
     * Check the specified resource Can be deleted or not.
     *
     * @param  Illuminate\Http\Request $request_data
     * @param  Int $id
     * @return Array
     */
    protected function validateRequest($request_data)
    {
        $valid_drivers = array_keys(MAIL_DRIVERS);
        $rules = array(
            'driver'       => 'required|in:'.implode(',',$valid_drivers),
            'host'         => 'required',
            'port'         => 'required',
            'from_address' => 'required',
            'from_name'    => 'required',
            'encryption'   => 'required',
            'username'     => 'required',
            'app_password' => 'required',
        );

        $attributes = array(
            'driver'       => Lang::get('admin_messages.email_config.driver'),
            'host'         => Lang::get('admin_messages.email_config.host'),
            'port'         => Lang::get('admin_messages.email_config.port'),
            'from_address' => Lang::get('admin_messages.email_config.from_address'),
            'from_name'    => Lang::get('admin_messages.email_config.from_name'),
            'encryption'   => Lang::get('admin_messages.email_config.encryption'),
            'username'     => Lang::get('admin_messages.email_config.username'),
            'app_password' => Lang::get('admin_messages.email_config.password'),
        );

        $this->validate($request_data,$rules,[],$attributes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMailToUsers(Request $request)
    {
        if($request->isMethod('POST')) {
            $rules = array(
                'mail_to' => 'required',
                'subject' => 'required',
                'content' => 'required',
            );

            if($request->mail_to == 'specific') {
                $rules['emails'] = 'required';
            }

            $this->validate($request,$rules);

            if($request->mail_to == 'all') {
                $user_emails = User::select('email')->get()->pluck('email')->toArray();
            }
            else {
                $user_emails = $request->emails;
            }

            $emails = array_filter(array_map('trim',$user_emails));

            $mail_data = array(
                'content'   => $request->content,
                'subject'   => $request->subject,
            );

            foreach ($emails as $email) {
                $user = User::where('email', $email)->first();
                if($user != '') {
                    $mail_data['name'] = $user->first_name;
                }
                else {
                    $mail_data['name'] = $email;
                }
                
                $user_data = [
                    'email' => $user->email,
                    'locale' => $user->user_language ?? global_settings('default_language'),
                ];

                resolveAndSendNotification("customMail",$mail_data,$user_data);
            }

            flashMessage('success',Lang::get('admin_messages.common.success'),Lang::get('admin_messages.email_to_users.email_sent_successfully'));
            return redirect()->route('admin.email_to_users');
        }

        $this->view_data['user_email_list'] = User::select('email','first_name')->get()->pluck('email','email');

        return view('admin.users.send_mails', $this->view_data);
    }
}
