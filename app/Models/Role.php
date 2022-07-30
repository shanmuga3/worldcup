<?php

namespace App\Models;

use Shanmuga\LaravelEntrust\Models\EntrustRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends EntrustRole
{
	use HasFactory;
	
    /**
	* The attributes that aren't mass assignable.
	*
	* @var array
	*/
	protected $guarded = [];
}