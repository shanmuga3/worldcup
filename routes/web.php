<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'dev'], function () {
    Route::get('mail', function() {
        return resolveAndSendNotification("welcomeMail",10001);
    });
    Route::get('show__l--log', function() {
        $contents = \File::get(storage_path('logs/laravel.log'));
        echo '<pre>'.$contents.'</pre>';
    });
    Route::get('clear__l--log', function() {
        file_put_contents(storage_path('logs/laravel.log'),'');
    });

    Route::get('users', function() {
        ini_set('max_execution_time', 0);
        $con = config('database.connections.mysql');
        $con['database'] = 'worldcup_live';
        $con = config(['database.connections.mysql_2' => $con]);

        $users = \DB::connection('mysql_2')->Table('users')
        ->where('email','!=','not defined from facebook')
        ->get();
        $users->each(function($user) {
            $name = explode(' ', $user->fullName);

            $new_user = new \App\Models\User;
            $new_user->first_name = $name[0];
            $new_user->last_name = $name[1] ?? '';
            $new_user->email = $user->email;
            $new_user->password = $user->password;
            $new_user->score = $user->score;
            if($user->mobile != 0) {
                $new_user->phone_number = $user->mobile;
            }
            if($user->birthDate != 'not defined from facebook') {
                try {
                    $date_obj = \Carbon\Carbon::createFromFormat('d/m/Y',$user->birthDate);
                    $new_user->dob = $date_obj->format('Y-m-d') != '1970-01-01' ? $date_obj->format('Y-m-d') : NULL;                    
                }
                catch(\Exception $e) {
                    $new_user->dob = NULL;
                }
            }
            if($user->city != 'not defined from facebook') {
                $new_user->city = $user->city;
            }
            
            if($user->fbId != 'not defined from facebook') {
                // $new_user->facebook_id = $user->fbId;
            }

            if($user->favTeem != '') {
                $team = explode('/', $user->favTeem);
                if(isset($team[1])) {
                    $team = explode('.', $team[1]);
                    $team = \App\Models\Team::where('short_name','like',$team)->first();
                    if($team != '') {
                        $user->team_id = $team->id;
                    }
                }
            }

            $new_user->gender = $user->gender == 'not defined from facebook' ? null : strtolower($user->gender);
            $new_user->user_language = 'ar';
            $new_user->status = $user->verify == 0 ? 'pending' : 'active';
            $new_user->save();
        });

        return response()->json([
            'status' => true,
            'status_message' => "Users Updated Successfully",
        ]);
    });

    Route::get('matches', function() {
        $con = config('database.connections.mysql');
        $con['database'] = 'worldcup_live';
        $con = config(['database.connections.mysql_2' => $con]);

        $matches = \DB::connection('mysql_2')->Table('matches')
        ->join('teams as team1', 'matches.firstTeamid', '=', 'team1.id')
        ->join('teams as team2', 'matches.secondTeamid', '=', 'team2.id')
        ->select(
            'matches.*',
            'team1.name as team1_name',
            'team2.name as team2_name',
        )
        ->get();

        $matches->each(function($match) {
            $team1 = substr(trim($match->team1_name), 0, 3);
            $team2 = substr(trim($match->team2_name), 0, 3);
            $team1 = \App\Models\Team::where('short_name','like',$team1)->first();
            $team2 = \App\Models\Team::where('short_name','like',$team2)->first();
            $new_match = new \App\Models\TeamMatch;
            $new_match->first_team_id = $team1->id;
            $new_match->second_team_id = $team2->id;
            $new_match->round = $match->round;
            $new_match->match_time = $match->matchTime;
            $new_match->first_team_score = $match->result1;
            $new_match->second_team_score = $match->result2;
            $new_match->first_team_penalty = $match->penalty1;
            $new_match->second_team_penalty = $match->penalty2;
            $new_match->starting_at = $match->startDate;
            $new_match->ending_at = $match->endDate;
            $new_match->answer = $match->answer;
            $new_match->created_at = $match->startDate;
            $new_match->updated_at = $match->startDate;
            $new_match->save();
        });

        return response()->json([
            'status' => true,
            'status_message' => "Match Updated Successfully",
        ]);
    });

    Route::get('guesses', function() {
        $con = config('database.connections.mysql');
        $con['database'] = 'worldcup_live';
        $con = config(['database.connections.mysql_2' => $con]);

        $guessess = \DB::connection('mysql_2')->Table('guesses')
        ->join('users', 'guesses.uId', '=', 'users.id')
        ->select(
            'guesses.*',
            'users.email as email',
        )
        ->where('email','!=','not defined from facebook')
        ->get();

        $guessess->each(function($guess) {
            $team1 = substr(trim($guess->firstTeam), 0, 3);
            $team2 = substr(trim($guess->secondTeam), 0, 3);
            $team1 = \App\Models\Team::where('short_name','like',$team1)->first();
            $team2 = \App\Models\Team::where('short_name','like',$team2)->first();
            $match = \App\Models\TeamMatch::where('id',$guess->matchId)->first();
            $user = \App\Models\User::where('email',$guess->email)->first();
            try {
                $new_guess = new \App\Models\Guess;
                $new_guess->user_id = $user->id;
                $new_guess->match_id = $match->id;
                $new_guess->first_team_score = $guess->firstTeamResult;
                $new_guess->second_team_score = $guess->secondTeamResult;
                $new_guess->first_team_penalty = $guess->firstTeamPenalty;
                $new_guess->second_team_penalty = $guess->secondTeamPenalty;
                $new_guess->round = $match->round;
                $new_guess->score = NULL;
                $new_guess->created_at = $guess->created_at;
                $new_guess->updated_at = $guess->created_at;
                $new_guess->save();
            }
            catch(\Exception $e) {
                logger($e->getMessage());
            }
        });

        return response()->json([
            'status' => true,
            'status_message' => "Match Updated Successfully",
        ]);
    });
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('update-user-default', [HomeController::class,'updateUserDefaults'])->name('update_user_default');

Route::group(['middleware' => ['guest']], function () {
    Route::view('login','auth.login')->name('login');
    Route::post('authenticate',[AuthController::class,'authenticate'])->name('authenticate');
    Route::view('register','auth.register')->name('register');
    Route::post('create_user',[AuthController::class,'createUser'])->name('create_user');
    Route::match(['GET','POST'],'reset-password', [AuthController::class,'resetPassword'])->name('reset_password');
    Route::post('set-password', [AuthController::class,'setNewPassword'])->name('set_password');
});

Route::post('get-matches',[HomeController::class,'getMatches'])->name('get_matches');

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard',[HomeController::class,'dashboard'])->name('dashboard');
    Route::get('edit_profile',[HomeController::class,'editProfile'])->name('edit_profile');
    Route::post('update_profile',[HomeController::class,'updateProfile'])->name('update_profile');
    Route::post('predict-match',[HomeController::class,'predictMatch'])->name('predict_match');
    Route::get('previous-guesses',[HomeController::class,'previousGuesses'])->name('previous_guesses');
    Route::post('get-previous-guesses',[HomeController::class,'getPreviousGuesses'])->name('get_previous_guesses');
    Route::post('update-favourite-team', [HomeController::class,'updatefavTeam'])->name('update_favourite_team');

    Route::get('logout', function () {
        session()->forget('url.intended');
        \Auth::logout();
        return redirect()->route('login');
    })->name('logout');
});

Route::get('{slug}', [HomeController::class,'staticPages'])->name('static_page');