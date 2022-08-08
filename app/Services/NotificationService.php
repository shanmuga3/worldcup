<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Auth;
use Lang;

class NotificationService
{
	function __construct()
	{
		$this->default_locale = global_settings('default_language') ?? 'en';
		$this->currentDateTime = date(DATE_FORMAT);
	}

	/**
	 * Get User data
	 *
	 * @param  \App\Models\User $user
	 * @return Array
	 */
	protected function getUserData($user)
	{
		$user_data['user_name'] = $user->first_name;
		$user_data['since'] = $user->created_at->format('F Y');
		$user_data['user_profile_pic'] = $user->profile_picture_src;

		return $user_data;
	}

	/**
	 * Send Email Via Swift Mailer
	 *
	 * @param  \Illuminate\Mail\Mailable $mailable
	 * @param  string $email
	 * @param  string $first_name default empty
	 * @return Array
	 */
	public function sendEmail($mailable, $email,$locale = '')
	{
		try {
			if($locale == '') {
				$locale = $this->default_locale;
			}
			
			// return $mailable->locale($locale)->render();

			$result = Mail::to($email)->locale($locale)->queue($mailable);
			return [
				'status' => true,
				'status_message' => Lang::get('messages.home.mail_sent_successfully'),
			];
			
		}
		catch (\Exception $e) {
			return [
				'status' => false,
				'status_message' => Lang::get('messages.home.failed_to_send_mail'),
				'error_message' => $e->getMessage(),
			];
		}
	}

	/**
	 * Send Mail to All Primary Admins
	 *
	 * @param  \Illuminate\Mail\Mailable $mailable
	 */
	public function sendEmailToAdmins($mailable)
	{
		$admins = Admin::primaryUsers()->get();
		
		$result = [];
		$admins->each(function($admin) use($mailable,&$result) {
			$mailable = $mailable->mergeData(['admin_name' => $admin->username]);
			$result = $this->sendEmail($mailable,$admin->email);
		});

		return $result;
	}

	/**
	 * Send Custom Mail to Users
	 *
	 * @param  Array $mail_data
	 * @param  Array $user_data
	 */
	public function customMail($mail_data,$user_data)
	{
		$mailable = new \App\Mail\Admin\CustomMail($mail_data);

		$result = $this->sendEmail($mailable,$user_data['email'],$user_data['locale']);
		
		return $result;
	}

	/**
	 * Send Contact Us Mail to Admin
	 *
	 * @param  Array $contact_data
	 */
	public function contactAdmin($contact_data)
	{
		$mailable = new \App\Mail\Admin\ContactAdmin($contact_data);

		return $this->sendEmailToAdmins($mailable);
	}

	/**
	 * Send Confirmation Mail To User
	 *
	 * @param  Integer $user_id
	 */
	public function resetUserPassword($user_id)
	{
		$user = User::find($user_id);

		$mail_data['name'] = $user->first_name;
		$mail_data['reset_link'] = $user->resetPasswordUrl('reset_password');

		$mail_data['subject'] = Lang::get('messages.reset_your_password',[],$user->user_language);

		$mailable = new \App\Mail\ResetUserPassword($mail_data);
		$result = $this->sendEmail($mailable,$user->email,$user->user_language);
		
		return $result;
	}
}