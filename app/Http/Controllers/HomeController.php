<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamMatch;
use App\Models\Guess;
use Illuminate\Validation\Rules\Password;
use Validator;
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

    /**
     * Update User Default settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json success
     */
    public function updatefavTeam(Request $request)
    {
        $user = \Auth::user();
        $user->team_id = $request->team;
        $user->save();

        return response()->json([
            'status' => true,
            'status_message' => Lang::get('messages.common.updated_successfully'),
        ]);
    }

    /**
     * Display User Dashboard
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $data['user'] = Auth::user();
        
        return view('user.dashboard',$data);
    }

    /**
     * Display User Dashboard
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function editProfile(Request $request)
    {
        $data['user'] = Auth::user();
        
        return view('user.profile',$data);
    }

    /**
     * Display User Dashboard
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $password_rule = Password::min(8)->mixedCase()->numbers()->uncompromised();
        if(env('SHOW_CREDENTIALS') == true) {
            $password_rule = Password::min(8);
        }

        $rules = array(
            'first_name' => ['required','max:30'],
            'last_name' => ['required','max:30'],
            'email' => ['required','max:50','email','unique:users,email,'.Auth::id()],
            'password' => ['nullable','confirmed',$password_rule],
            'dob' => ['required'],
            'gender' => ['required'],
            'phone_number' => ['required','unique:users','starts_with:05','digits:10'],
            'address' => ['required'],
            'city' => ['required'],
            'profile_picture' => ['nullable','file','max:1024'],
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

        $user = Auth::user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        if($request->password != '') {
            $user->password = $request->password;
        }

        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->phone_code = '05';
        $user->phone_number = substr($request->phone_number,2);
        $user->address = $request->address ?? '';
        $user->city = $request->city;
        $user->team_id = $request->fav_team;
        $user->status = 'active';

        try {
            $user->save();
        }
        catch(\Exception $e) {
            flashMessage('danger', Lang::get('messages.failed'), Lang::get('messages.failed_to_update_profile'));
            return back()->withInput();
        }

        if($request->file('profile_picture')) {
            $image_handler = resolve('App\Services\ImageHandlers\LocalImageHandler');
            $image_data['name_prefix'] = 'user_'.$user->id;
            $image_data['add_time'] = false;
            $image_data['target_dir'] = $user->getUploadPath();
            $image_data['image_size'] = $user->getImageSize();

            $upload_result = $image_handler->upload($request->file('profile_picture'),$image_data);
            
            if($upload_result['status']) {
                $user->src = $upload_result['file_name'];
                $user->photo_source = 'site';
                $user->upload_driver = $upload_result['upload_driver'];
                $user->save();
            }
        }
        
        flashMessage('success', Lang::get('messages.success'), Lang::get('messages.updated_successfully'));
        return back()->withInput();
    }

    /**
     * Display User Dashboard
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getMatches(Request $request)
    {
        date_default_timezone_set($request->timezone);
        if($request->type == 'upcoming') {
            $matches = TeamMatch::with('first_team','second_team')->upcomingMatches()->limit(4)->get();
        }
        else {
            $limit = Auth::check() ? 100 : 1;
            $already_predicted = Guess::where('user_id',Auth::id())->get()->pluck('match_id');
            $matches = TeamMatch::with('first_team','second_team')
                ->whereNotIn('id',$already_predicted)
                ->whereRaw('"'.date('Y-m-d H:i:s',strtotime('-1 day')).'"  >= starting_at')
                ->where('ending_at', '>',date('Y-m-d H:i:s'))
                ->limit($limit)
                ->get();
        }

        $matches = $matches->map(function($match) {
            return [
                'id' => $match->id,
                'first_team_name' => $match->first_team->name,
                'first_team_formatted_name' => $match->first_team->short_name.' - '.$match->first_team->name,
                'first_team_image' => $match->first_team->image_src,
                'second_team_formatted_name' => $match->second_team->short_name.' - '.$match->second_team->name,
                'second_team_name' => $match->second_team->name,
                'second_team_image' => $match->second_team->image_src,
                'round' => $match->round,
                'starting_at' => $match->starting_at,
                'ending_at' => $match->ending_at,
                'duration' => $match->duration,
                'match_time' => $match->match_time,
                'starting_in' => $match->starting_in,
            ];
        });
        
        return response()->json([
            'status' => true,
            'matches' => $matches,
        ]);
    }

    /**
     * predict Match Result
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function predictMatch(Request $request)
    {
        $rules = [
            'match_id' => 'required',
            'first_team_score' => 'required|numeric|min:0',
            'second_team_score' => 'required|numeric|min:0',
        ];

        $match = TeamMatch::find($request->match_id);
        
        if(optional($match)->round > 1 && $request->first_team_score != '' && $request->first_team_score == $request->second_team_score) {
            $rules['first_team_penalty'] = 'required|numeric|min:0';
            $rules['second_team_penalty'] = 'required|numeric|min:0';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'error_messages' => $validator->messages(),
            ]);
        }

        if($match == '') {
            return response()->json([
                'status' => false,
                'status_title' => Lang::get('messages.failed'),
                'status_message' => Lang::get('messages.your_prediction_already_submitted'),
            ]);
        }

        $user_id = Auth::id();
        $prev_count = Guess::where('user_id',$user_id)->where('match_id',$request->match_id)->count();
        if($prev_count > 0) {
            if($request->type != 'update') {
                return response()->json([
                    'status' => false,
                    'status_title' => Lang::get('messages.failed'),
                    'status_message' => Lang::get('messages.your_prediction_already_submitted'),
                ]);
            }

            $user_guess = Guess::where('user_id',$user_id)->find($request->guess_id);
            if($user_guess == '' || @!$user_guess->canEditScore()) {
                return response()->json([
                    'status' => false,
                    'status_action' => 'reload',
                    'status_title' => Lang::get('messages.failed'),
                    'status_message' => Lang::get('messages.your_prediction_already_submitted'),
                ]);
            }

            $user_guess->user_id = $user_id;
            $user_guess->match_id = $match->id;
            $user_guess->first_team_score = $request->first_team_score;
            $user_guess->second_team_score = $request->second_team_score;
            $user_guess->first_team_penalty = $user_guess->second_team_penalty = NULL;
            if($request->first_team_score != '' && $request->first_team_score == $request->second_team_score) {
                $user_guess->first_team_penalty = $request->first_team_penalty;
                $user_guess->second_team_penalty = $request->second_team_penalty;
            }
            $user_guess->round = $match->round;
            $user_guess->save();

            return response()->json([
                'status' => true,
                'status_title' => Lang::get('messages.success'),
                'status_message' => Lang::get('messages.prediction_has_been_submitted'),
            ]);
        }

        $user_guess = new Guess;
        $user_guess->user_id = $user_id;
        $user_guess->match_id = $match->id;
        $user_guess->first_team_score = $request->first_team_score;
        $user_guess->second_team_score = $request->second_team_score;
        if($request->first_team_score != '' && $request->first_team_score == $request->second_team_score) {
            $user_guess->first_team_penalty = $request->first_team_penalty;
            $user_guess->second_team_penalty = $request->second_team_penalty;
        }
        $user_guess->round = $match->round;
        $user_guess->save();
        
        return response()->json([
            'status' => true,
            'status_title' => Lang::get('messages.success'),
            'status_message' => Lang::get('messages.prediction_has_been_submitted'),
        ]);
    }

    /**
     * Display previous Guesses
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function previousGuesses(Request $request)
    {
        $data['user_guesses'] = Guess::with('match.first_team','match.second_team')->where('user_id',Auth::id())->get();
        return view('user.previous_guesses',$data);
    }

    public function getPreviousGuesses(Request $request)
    {
        date_default_timezone_set($request->timezone);
        $user_guesses = Guess::with('match.first_team','match.second_team')->where('user_id',Auth::id())->get();
        
        $guesses = $user_guesses->map(function($guess) {
            return [
                'id' => $guess->id,
                'match_id' => $guess->match_id,
                'first_team_name' => $guess->match->first_team->name,
                'first_team_formatted_name' => $guess->match->first_team->short_name.' - '.$guess->match->first_team->name,
                'first_team_image' => $guess->match->first_team->image_src,
                'second_team_formatted_name' => $guess->match->second_team->short_name.' - '.$guess->match->second_team->name,
                'second_team_name' => $guess->match->second_team->name,
                'second_team_image' => $guess->match->second_team->image_src,
                'first_team_score' => $guess->first_team_score,
                'second_team_score' => $guess->second_team_score,
                'first_team_penalty' => $guess->first_team_penalty,
                'second_team_penalty' => $guess->second_team_penalty,
                'round' => $guess->round,
                'score' => $guess->score,
                'answer' => $guess->answer,
                'can_edit_score' => $guess->canEditScore(),
                'starting_at' => $guess->match->starting_at,
                'starting_at_formatted' => getDateObject($guess->match->starting_at)->format('d/m/Y'),
                'ending_at' => $guess->match->ending_at,
                'ending_at_formatted' => getDateObject($guess->match->ending_at)->format('d/m/Y'),
                'result_published' => $guess->match->answer,
                'first_team_result' => $guess->match->first_team_score,
                'second_team_result' => $guess->match->second_team_score,
                'first_team_penalty_result' => $guess->match->first_team_penalty,
                'second_team_penalty_result' => $guess->match->second_team_penalty,
            ];
        });
        
        return response()->json([
            'status' => true,
            'user_guesses' => $guesses,
        ]);
    }

    /**
     * Display Static page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function staticPages(Request $request)
    {
        $page = \App\Models\StaticPage::where('slug',$request->slug)->firstOrFail();

        if($page->status == 0 && !\Auth::guard('admin')->check()) {
            abort(404);
        }

        $replace_keys = ['SITE_NAME','SITE_URL'];
        $replace_values = [SITE_NAME,url('/')];
        $data['content'] = \Str::of($page->content)->replace($replace_keys,$replace_values);
        $data['title'] = $page->name;
        
        return view('static_page',$data);
    }
}
