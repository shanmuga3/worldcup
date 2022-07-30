<?php

namespace App\Services\AuthUser;

use App\Contracts\AuthInterface;
use App\Models\User;
use Auth;

class AuthViaEmail implements AuthInterface
{
    /**
     * Check user already exist or create new User
     *
     * @param Array $user_data
     * @return \App\Models\User $user
     */
    public function createOrGetUser(Array $user_data)
    {
        $user = User::create($user_data);
        $user_info = $user->user_information;
        $user_info->dob = $user_data['dob'];
        $user_info->save();
        
        resolveAndSendNotification("confirmUserEmail",$user->id);
        return $user;
    }

    /**
     * Authenticate
     *
     * @param Array $credentials
     * @param Boolean $remember_me
     * @return \Auth
     */
    public function attemptLogin(Array $credentials,bool $remember_me = false)
    {
    	return Auth::guard('user')->attempt($credentials,$remember_me);
    }

    /**
     * complete Verification
     *
     * @param String $user_id
     * @param String $auth_id
     * @return Void
     */
    public function completeVerification(string $user_id, string $auth_id)
    {
    	$user = User::find($user_id);
        $verification = $user->user_verification;
    	if($verification->email != 1) {
    		$verification->email = 1;
    		$verification->save();
    	}
    }

    /**
     * diconnect Verification
     *
     * @param String $user_id
     * @return Void
     */
    public function diconnectVerification(string $user_id)
    {
        $verification = UserVerification::find($user_id);
        $verification->email = 0;
        $verification->save();
    }
}