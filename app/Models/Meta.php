<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meta extends Model
{
    use HasFactory;

	/**
	 * The attributes that are Translatable
	 *
	 * @var array
	 */
	public $translatable = ['title', 'description'];
}
