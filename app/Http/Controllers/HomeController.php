<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamMatch;
use App\Models\Guess;
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
    public function getMatches(Request $request)
    {
        if($request->type == 'upcoming') {
            $matches = TeamMatch::with('first_team','second_team')->upcomingMatches()->limit(4)->get();
        }
        else {
            $limit = Auth::check() ? 100 : 1;
            $already_predicted = Guess::where('user_id',Auth::id())->get()->pluck('match_id');
            $matches = TeamMatch::with('first_team','second_team')->whereNotIn('id',$already_predicted)->whereRaw('? between starting_at and ending_at', [date('Y-m-d H:i:s')])->limit($limit)->get();
        }

        $matches = $matches->map(function($match) {
            return [
                'id' => $match->id,
                'first_team_name' => $match->first_team->name,
                'first_team_formatted_name' => $match->first_team->short_name.' - '.$match->first_team->name,
                'first_team_image' => $match->first_team->image_src,
                'second_team_formatted_name' => $match->second_team->short_name.' - '.$match->first_team->name,
                'second_team_name' => $match->second_team->name,
                'second_team_image' => $match->second_team->image_src,
                'round' => $match->round,
                'duration' => $match->duration,
                'match_time' => $match->match_time,
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
            return response()->json([
                'status' => false,
                'status_title' => Lang::get('messages.failed'),
                'status_message' => Lang::get('messages.your_prediction_already_submitted'),
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
