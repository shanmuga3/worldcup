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
            return redirect()->route('home');
        }
        return back();
    }

    public function createUser(Request $request)
    {
        $rules = array(
            'name'     => 'required',
            'email'     => 'required|email',
            'password'  => 'required|confirmed',
        );
        $attributes = array(
            'name'     => Lang::get('messages.name'),
            'email'     => Lang::get('messages.email'),
            'password'  => Lang::get('messages.password'),
        );
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $credentials = $request->only(['email','password']);

        if(Auth::attempt($credentials)) {
            return redirect()->route('home');
        }
        return back();
    }
}
