<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use App\Models\LoginSlider;
use App\Models\Team;
use App\Models\TeamMatch;
use App\Models\Guess;
use Carbon\Carbon;
use Lang;
use Auth;

class HomeController extends Controller
{
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->view_data['main_title'] = Lang::get('admin_messages.navigation.dashboard');
        $this->view_data['active_menu'] = 'dashboard';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['sliders'] = LoginSlider::activeOnly()->ordered()->get()->pluck('image_src');
        return view('admin.login',$data);
    }

    /**
     * Authenticate admin user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $rules = array(
            'username' => 'required',
            'password' => 'required',
        );

        $attributes = array(
            'username' => Lang::get('messages.fields.username'),
            'password' => Lang::get('messages.fields.password'),
        );

        $this->validate($request,$rules,[],$attributes);

        $remember = ($request->remember == 'on');

        if (Auth::guard('admin')->attempt($request->only('username','password'),$remember)) {
            $admin = Admin::where('username', $request->username)->first();
            
            if(!$admin->status) {
                Auth::guard('admin')->logout();
                flashMessage('danger',Lang::get('admin_messages.errors.failed_to_login'),Lang::get('admin_messages.errors.blocked_by_admin'));
                return redirect()->route('admin.login');
            }

            $intented_url = session('url.intended');
            $has_admin_url = \Str::contains($intented_url,global_settings('admin_url'));
            if($intented_url != '' && $has_admin_url) {
                return redirect($intented_url);
            }

            return redirect()->route('admin.dashboard');
        }
        else {
            flashMessage('danger',Lang::get('admin_messages.errors.failed_to_login'),Lang::get('admin_messages.errors.invalid_credentials'));
        }
        return redirect()->route('admin.login');        
    }

    /**
     * Log out current admin user.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        session()->forget('url.intended');
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    /**
     * Display a Admin Dashboard with total consolidated data
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        if($request->isMethod("POST")) {
            return $this->getDashboardData($request->year);
        }
        $this->view_data['dashboard_data'] = $this->getDashboardData(date('Y'));

        $users = User::latest()->limit(5)->get();
        $this->view_data['recent_users'] = $users->map(function($user) {
            return [
                'id' => $user->id,
                'link' => route('admin.users.edit',['id' => $user->id]),
                'profile_picture' => $user->profile_picture_src,
                'name' => $user->full_name,
                'email' => $user->email,
                'score' => $user->score,
            ];
        });

        $users = User::orderByDesc('score')->limit(4)->get();
        $this->view_data['top_users'] = $users->map(function($user) {
            return [
                'id' => $user->id,
                'link' => route('admin.users.edit',['id' => $user->id]),
                'profile_picture' => $user->profile_picture_src,
                'name' => $user->full_name,
                'email' => $user->email,
                'score' => $user->score,
            ];
        });

        $matches = TeamMatch::with('first_team','second_team')->whereRaw('? between starting_at and ending_at', [date('Y-m-d H:i:s')])->orderByDesc('id')->limit(5)->get();

        $this->view_data['today_matches'] = $matches->map(function($match) {
            return [
                'id' => $match->id,
                'first_team_name' => $match->first_team->name,
                'first_team_formatted_name' => $match->first_team->short_name.' - '.$match->first_team->name,
                'first_team_image' => $match->first_team->image_src,
                'second_team_formatted_name' => $match->second_team->short_name.' - '.$match->second_team->name,
                'second_team_name' => $match->second_team->name,
                'second_team_image' => $match->second_team->image_src,
                'round' => $match->round,
                'duration' => $match->duration,
                'match_time' => $match->match_time,
            ];
        });

        return view('admin.dashboard',$this->view_data);
    }

    /**
     * Get Dashboard Data for the Given Year
     *
     * @return Array
     */
    public function getDashboardData($year)
    {
        if($year == '') {
            return ['status' => false, 'status_message' => Lang::get('messages.errors.invalid_request')];
        }

        if(date("Y") == $year) {
            $today = now()->format('Y-m-d');
            $today_users = User::whereDate('created_at',$today)->count();
            $today_matches = TeamMatch::whereDate('created_at',$today)->count();
            $today_teams = Team::whereDate('created_at',$today)->count();
            $today_guesses = Guess::whereDate('created_at',$today)->count();
        }

        $statistics_data = [
            "users" => [
                "count" => User::count(),
                "new" => $today_users ?? 0,
                "colors" => ['#f1f1f1', '#FF9E27'],
                "value" => 100,
            ],
            "teams" => [
                "count" => Team::count(),
                "new" => $today_teams ?? 0,
                "colors" => ['#f1f1f1', '#FF9E27'],
                "value" => 100,
            ],
            "matches" => [
                "count" => TeamMatch::count(),
                "new" => $today_matches ?? 0,
                "colors" => ['#f1f1f1', '#FF9E27'],
                "value" => 100,
            ],
            "guesses" => [
                "count" => Guess::count(),
                "new" => $today_guesses ?? 0,
                "colors" => ['#f1f1f1', '#FF9E27'],
                "value" => 100,
            ],
        ];
        $data['statistics_data'] = $statistics_data;
        $data['status'] = true;
        
        return $data;
    }

    /**
     * Upload Image to Server
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadImage(Request $request)
    {
        if (!$request->hasFile('file')) {
            return ['status' => false];
        }

        $image_handler = resolve('App\Contracts\ImageHandleInterface');
        $image_data['name_prefix'] = 'media_'.rand(100,999);
        $image_data['add_time'] = true;
        $image_data['target_dir'] = "/images/uploads";
        
        $upload_result = $image_handler->upload($request->file('file'),$image_data);
        
        return $upload_result;
    }
}
