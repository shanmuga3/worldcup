<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlobalSetting;
use Illuminate\Support\Facades\Artisan;
use Validator;
use Lang;

class GlobalSettingController extends Controller
{
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->view_data['main_title']  = Lang::get('admin_messages.global_settings.manage_global_settings');
        $this->view_data['active_menu'] = 'global_settings';
        $this->view_data['sub_title'] = Lang::get('admin_messages.global_settings.global_settings');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->view_data['maintenance_mode'] = (\App::isDownForMaintenance()) ? 'down' : 'up';
        $this->view_data['date_formats'] = resolve("DateFormat")->pluck('display_format','id');
        $this->view_data['backup_period_array'] = array(
            'never' => Lang::get('admin_messages.global_settings.never'),
            'daily' => Lang::get('admin_messages.global_settings.daily'),
            'weekly' => Lang::get('admin_messages.global_settings.weekly'),
            'twiceMonthly' => Lang::get('admin_messages.global_settings.twice_month'),
            'monthly' => Lang::get('admin_messages.global_settings.monthly'),
        );

        return view('admin.global_settings.edit', $this->view_data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = array(
            'site_name' => 'required|max:20',
            'about' => 'nullable|max:500',
            'admin_url' => 'required',
            'maintenance_mode' => 'required',
            'upload_driver' => 'required',
            'support_number' => 'required',
            'support_email' => 'required',
            'date_format' => 'required',
            'copyright_link' => 'nullable|url',
            'copyright_text' => 'required',
        );
        $attributes = array(
            'site_name' => Lang::get('admin_messages.global_settings.site_name'),
            'about' => Lang::get('admin_messages.global_settings.about'),
            'admin_url' => Lang::get('admin_messages.global_settings.admin_url'),
            'is_locale_based' => Lang::get('admin_messages.global_settings.is_locale_based'),
            'maintenance_mode' => Lang::get('admin_messages.global_settings.maintenance_mode'),
            'app_maintenance_mode' => Lang::get('admin_messages.global_settings.app_maintenance_mode'),
            'upload_driver' => Lang::get('admin_messages.global_settings.upload_driver'),
            'support_number' => Lang::get('admin_messages.global_settings.support_number'),
            'support_email' => Lang::get('admin_messages.global_settings.support_email'),
            'date_format' => Lang::get('admin_messages.global_settings.date_format'),
            'timezone' => Lang::get('admin_messages.global_settings.timezone'),
            'copyright_link' => Lang::get('admin_messages.global_settings.copyright_link'),
            'copyright_text' => Lang::get('admin_messages.global_settings.copyright_text'),
        );
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $site_name = GlobalSetting::where(['name' => 'site_name'])->first();
        $site_name = json_decode($site_name->value,true);
        $site_name['ar'] = $request->site_name;
        GlobalSetting::where(['name' => 'site_name'])->update(['value' => json_encode($site_name)]);

        $about = GlobalSetting::where(['name' => 'about'])->first();
        $about = json_decode($about->value,true);
        $about['ar'] = $request->about;
        GlobalSetting::where(['name' => 'about'])->update(['value' => json_encode($about)]);

        GlobalSetting::where(['name' => 'version'])->update(['value' => $request->version]);
        GlobalSetting::where(['name' => 'admin_url'])->update(['value' => $request->admin_url]);
        GlobalSetting::where(['name' => 'auto_payout'])->update(['value' => $request->auto_payout]);
        GlobalSetting::where(['name' => 'referral_enabled'])->update(['value' => $request->referral_enabled]);
        GlobalSetting::where(['name' => 'host_can_add_coupon'])->update(['value' => $request->host_can_add_coupon]);
        GlobalSetting::where(['name' => 'is_locale_based'])->update(['value' => $request->is_locale_based]);
        GlobalSetting::where(['name' => 'upload_driver'])->update(['value' => $request->upload_driver]);
        GlobalSetting::where(['name' => 'support_number'])->update(['value' => $request->support_number]);
        GlobalSetting::where(['name' => 'support_email'])->update(['value' => $request->support_email]);
        GlobalSetting::where(['name' => 'default_currency'])->update(['value' => $request->default_currency]);
        GlobalSetting::where(['name' => 'default_language'])->update(['value' => $request->default_language ?? 'ar']);
        GlobalSetting::where(['name' => 'date_format'])->update(['value' => $request->date_format]);
        GlobalSetting::where(['name' => 'timezone'])->update(['value' => $request->timezone]);
        GlobalSetting::where(['name' => 'copyright_link'])->update(['value' => $request->copyright_link]);
        GlobalSetting::where(['name' => 'copyright_text'])->update(['value' => $request->copyright_text]);
        GlobalSetting::where(['name' => 'default_user_status'])->update(['value' => $request->default_user_status]);
        GlobalSetting::where(['name' => 'default_listing_status'])->update(['value' => $request->default_listing_status]);
        GlobalSetting::where(['name' => 'backup_period'])->update(['value' => $request->backup_period]);
        GlobalSetting::where(['name' => 'min_price'])->update(['value' => $request->min_price]);
        GlobalSetting::where(['name' => 'max_price'])->update(['value' => $request->max_price]);
        
        GlobalSetting::where(['name' => 'head_code'])->update(['value' => $request->head_code]);
        GlobalSetting::where(['name' => 'foot_code'])->update(['value' => $request->foot_code]);

        $maintenance_mode = (\App::isDownForMaintenance()) ? 'down' : 'up';
        if($maintenance_mode != $request->maintenance_mode) {
            $args = [];
            if($request->maintenance_mode == 'down') {
                $uuid = \Str::uuid()->toString();
                GlobalSetting::where(['name' => 'maintenance_mode_secret'])->update(['value' => $uuid]);
                $args = ['--secret' => $uuid];
            }
            else {
                GlobalSetting::where(['name' => 'maintenance_mode_secret'])->update(['value' => '']);
            }
            Artisan::call($request->maintenance_mode,$args);
        }

        $image_handler = resolve('App\Contracts\ImageHandleInterface');
        $global_settings = new GlobalSetting;
        
        // Upload Primary logo
        if($request->hasFile('primary_logo')) {
            $upload_result = $this->uploadImage($request->file('primary_logo'),$global_settings->filePath,'logo');
            if($upload_result['status']) {
                GlobalSetting::where(['name' => 'logo'])->update(['value' => $upload_result['file_name']]);
                GlobalSetting::where(['name' => 'logo_driver'])->update(['value' => $upload_result['upload_driver']]);
            }
            else {
                $upload_failed = true;
            }
        }

        // Upload Secondary logo
        if($request->hasFile('secondary_logo')) {
            $upload_result = $this->uploadImage($request->file('secondary_logo'),$global_settings->filePath,'secondary_logo');
            if($upload_result['status']) {
                GlobalSetting::where(['name' => 'secondary_logo'])->update(['value' => $upload_result['file_name']]);
                GlobalSetting::where(['name' => 'secondary_logo_driver'])->update(['value' => $upload_result['upload_driver']]);
            }
            else {
                $upload_failed = true;
            }
        }

        // Upload fav icon
        if($request->hasFile('favicon')) {
            $upload_result = $this->uploadImage($request->file('favicon'),$global_settings->filePath,'favicon');
            if($upload_result['status']) {
                GlobalSetting::where(['name' => 'favicon'])->update(['value' => $upload_result['file_name']]);
                GlobalSetting::where(['name' => 'favicon_driver'])->update(['value' => $upload_result['upload_driver']]);
            }
            else {
                $upload_failed = true;
            }
        }

        if(isset($upload_failed)) {
            flashMessage('danger',Lang::get('admin_messages.common.failed'),Lang::get('admin_messages.errors.failed_to_upload_image'));
        }
        else {
            flashMessage('success',Lang::get('admin_messages.common.success'),Lang::get('admin_messages.common.successfully_updated'));
        }

        if($request->admin_url != global_settings('admin_url')) {
            return redirect(url($request->admin_url.'/global-settings'));
        }
        return redirect()->route('admin.global_settings');
    }

    /**
     * Upload Given Image to Server
     *
     * @return Object Upload Result
     */
    protected function uploadImage($image,$target_dir,$name_prefix)
    {
        $image_handler = resolve('App\Contracts\ImageHandleInterface');

        $image_data['name_prefix'] = $name_prefix;
        $image_data['target_dir'] = $target_dir;

        return $image_handler->upload($image,$image_data);
    }
}