<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'dob',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

     /**
      * Default Guard Name of the Model
      *
      * @var array<int, string>
      */
    protected $guard = 'user';

    /**
     * Where the Files are stored
     *
     * @var string
     */
    public $filePath = "/images/users";

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [];

    /**
     * Get the verification URL for the given route.
     *
     * @param  mixed  $route
     * @return string
     */
    public function verificationUrl($route)
    {
        return \URL::temporarySignedRoute(
            $route,
            now()->addMinutes(60),
            [
                'id' => $this->getKey(),
                'hash' => sha1($this->getEmailForVerification()),
            ]
        );
    }

    /**
     * Get the Reset Password URL for the given route.
     *
     * @param  mixed  $route
     * @return string
     */
    public function resetPasswordUrl($route)
    {
        return url(route($route, [
            'token' => app('auth.password.broker')->createToken($this),
            'email' => $this->getEmailForPasswordReset(),
        ], false));
    }

    /**
     * Store the encrypted password to table.
     *
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Join With Team Match Table
     *
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get Current Image Handler
     *
     * @return ImageHandler
     */
    public function getImageHandler()
    {
        $upload_drivers = view()->shared('upload_drivers');
        $driver = $this->attributes['upload_driver'] ?? '0';
        $handler = resolve('App\Services\ImageHandlers\\'.$upload_drivers[$driver].'ImageHandler');
        return $handler;
    }

    /**
     * Get Upload File Path
     *
     * @return string
     */
    public function getUploadPath()
    {
        return $this->filePath.'/'.$this->id;
    }

    /**
     * Get Image Size
     *
     * @return String
     */
    public function getImageSize()
    {
        if(isset($this->imageSize)) {
            return $this->imageSize;
        }
        return ['height' => '','width' => ''];
    }

    /**
     * Delete Image From Storage
     *
     * @return String ImageUrl
     */
    public function deleteImageFile()
    {
        $handler = $this->getImageHandler();

        $image_data['name'] = 'src';
        $image_data['target_dir'] = $this->getUploadPath();

        return $handler->destroy($image_data);
    }

    // Local Scope of User

    /**
     * Get All Active Users Only
     *
     */
    public function scopeActiveOnly($query)
    {
        return $query->where('status','active');
    }

    // Relationships

    // Appends

    /**
     * Get Full name of current User
     *
     */
    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'].' '.$this->attributes['last_name'];
    }

    /**
     * Get Full name of current User
     *
     */
    public function getFormattedDobAttribute()
    {
        if(isset($this->attributes['dob'])) {
            return date(DATE_FORMAT,strtotime($this->attributes['dob']));
        }

        return '';
    }

    /**
     * Get City name of current User
     *
     */
    public function getCityNameAttribute()
    {
        $city = resolve("City")->where('id',$this->city)->first();
        return $city['name'] ?? '';
    }

    /**
     * Get Member Since Attribute
     *
     */
    public function getSinceAttribute()
    {
        return $this->created_at->format('Y');
    }

    /**
     * Get Profile Picture of the User
     *
     */
    public function getProfilePictureSrcAttribute()
    {
        $src = $this->attributes['src'] ?? '';
        if($src == '') {
            return asset('images/profile_picture.png');
        }

        if($this->attributes['photo_source'] == 'site') {
            $handler = $this->getImageHandler();
            $image_data['name'] = $src;
            $image_data['version_based'] = true;
            $image_data['path'] = $this->getUploadPath();

            $src = $handler->fetch($image_data);
        }
        return $src;
    }

    /**
     * Check User loing with Social Media or not
     *
     */
    public function getHasSignupWithEmailAttribute()
    {
        return $this->password != '';
    }

    /**
     * Check User loing with Social Media or not
     *
     */
    public function getTeamLogoAttribute()
    {
        return optional($this->team)->image_src;
    }
}
