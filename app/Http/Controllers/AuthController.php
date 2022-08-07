<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        flashMessage('danger', Lang::get('messages.failed'), Lang::get('messages.login_failed'));
        return redirect()->route('login');
    }

    public function createUser(Request $request)
    {
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'dob' => 'required',
            'gender' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'city' => 'required',
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
        $user->name = $request->first_name.' '.$request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->save();

        $credentials = $request->only(['email','password']);

        if(Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }
        
        return back();
    }
}
