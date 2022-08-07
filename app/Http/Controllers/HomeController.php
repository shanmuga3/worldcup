<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Lang;
use Auth;

class HomeController extends Controller
{
    /**
     * Update User Default settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json success
     */
    public function updateUserDefaults(Request $request)
    {
        $user_language = $request->language;

        if(\Auth::check()) {
            $user = \Auth::user();
            $user->user_language = $user_language;
            $user->save();
        }

        session(['language' => $user_language]);

        return response()->json([
            'status' => true,
            'status_message' => Lang::get('messages.common.updated_successfully'),
        ]);
    }

    public function dashboard(Request $request)
    {
        $data['user'] = Auth::user();
        
        return view('dashboard',$data);
    }
}
