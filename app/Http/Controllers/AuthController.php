<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Lang;
use Auth;
use Validator;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $rules = array(
            'email'     => 'required|email',
            'password'  => 'required',
        );
        $attributes = array(
            'email'     => Lang::get('messages.email'),
            'password'  => Lang::get('messages.password'),
        );
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only(['email','password']);

        if(Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        flashMessage('danger', Lang::get('messages.failed'), Lang::get('messages.sign_in_failed'));
        return redirect()->route('login');
    }

    public function createUser(Request $request)
    {
        $password_rule = Password::min(8)->mixedCase()->numbers()->uncompromised();
        $rules = array(
            'first_name' => ['required','max:30'],
            'last_name' => ['required','max:30'],
            'email' => ['required','max:50','email','unique:users'],
            'password' => ['required',$password_rule],
            'dob' => ['required'],
            'gender' => ['required'],
            'phone_number' => ['required','unique:users'],
            'address' => ['required'],
            'city' => ['required'],
        );

        $attributes = array(
            'first_name' => Lang::get('messages.first_name'),
            'last_name' => Lang::get('messages.last_name'),
            'email' => Lang::get('messages.email'),
            'password' => Lang::get('messages.password'),
            'dob' => Lang::get('messages.dob'),
            'phone_number' => Lang::get('messages.phone_number'),
            'address' => Lang::get('messages.address'),
            'city' => Lang::get('messages.city'),
        );
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->score = 30;
        try {
            $user->save();
        }
        catch(\Exception $e) {
            flashMessage('danger', Lang::get('messages.failed'), Lang::get('messages.sign_in_failed'));
            return back()->withInput();
        }

        $credentials = $request->only(['email','password']);

        if(Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }
        
        flashMessage('danger', Lang::get('messages.failed'), Lang::get('messages.sign_in_failed'));
        return back()->withInput();
    }

    /**
    * Reset Password of the User
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function resetPassword(Request $request)
    {
        if($request->isMethod("POST")) {
            $user = User::where('email',$request->email)->first();
            if($user == '') {
                flashMessage('danger', Lang::get('messages.failed'), Lang::get('messages.user_not_exists'));
                $redirect_url = route('register');
                return redirect($redirect_url);
            }
            
            resolveAndSendNotification("resetUserPassword",$user->id);
            flashMessage('success', Lang::get('messages.success'), Lang::get('messages.reset_link_sent_to_mail'));
            $redirect_url = route('login');
            return redirect($redirect_url);
        }
        $broker = app('auth.password.broker');
        $user = $broker->getUser($request->all());
        if($user == '') {
            flashMessage('danger', Lang::get('messages.failed'), Lang::get('messages.user_not_exists'));
            $redirect_url = route('register');
            return redirect($redirect_url);
        }
        if($broker->tokenExists($user,$request->token)) {
            $data['email'] = $request->email;
            $data['reset_token'] = $request->token;
            return view('set_password',$data);
        }
        flashMessage('danger', Lang::get('messages.failed'), Lang::get('messages.link_expired'));
        $redirect_url = route('login');
        return redirect($redirect_url);
    }

    /**
    * Update New Password to the User
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function setNewPassword(Request $request)
    {
        $password_rule = Password::min(8)->mixedCase()->numbers()->uncompromised();
        $rules = array(
            'password' => ['required',$password_rule,'confirmed'],
        );

        $request->validate($rules);
        
        $broker = app('auth.password.broker');
        $user = $broker->getUser($request->only(['email']));
        if(!$broker->tokenExists($user,$request->reset_token)) {
            flashMessage('danger', Lang::get('messages.failed'), Lang::get('messages.invalid_request'));
            $redirect_url = route('login');
            return redirect($redirect_url);
        }
        $user->password = $request->password;
        $user->save();
        
        $broker->deleteToken($user);

        Auth::LoginUsingId($user->id);

        flashMessage('success', Lang::get('messages.success'), Lang::get('messages.password_updated_successfully'));
        $redirect_url = route('dashboard');
        return redirect($redirect_url);
    }
}
