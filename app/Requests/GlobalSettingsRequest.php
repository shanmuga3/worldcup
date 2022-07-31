<?php

/**
 * Global Settings validation
 *
 * @package     Hyra
 * @subpackage  Requests
 * @category    GlobalSettingsRequest
 * @author      Cron24 Technologies
 * @version     1.4
 * @link        https://cron24.com
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

class GlobalSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guard('admin')->user()->can('update-global_settings');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'site_name' => 'required|max:20',
            'version' => 'required',
            'app_version' => 'required',
            'force_update' => 'required',
            'admin_url' => 'required',
            'play_store' => 'nullable|url',
            'app_store' => 'nullable|url',
            'maintenance_mode' => 'required',
            'upload_driver' => 'required',
            'support_number' => 'required',
            'support_email' => 'required',
            'date_format' => 'required',
            'user_inactive_days' => 'required',
            'copyright_link' => 'url',
            'copyright_text' => 'required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'site_name' => Lang::get('admin_messages.global_settings.site_name'),
            'version' => Lang::get('admin_messages.global_settings.version'),
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
        ];
    }
}
