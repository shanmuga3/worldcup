<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTranslations;

class Team extends Model
{
    use HasFactory,HasTranslations, SoftDeletes;

    /**
     * The attributes that are Translatable
     *
     * @var array
     */
    public $translatable = ['name'];

    /**
     * Where the Files are stored
     *
     * @var string
     */
    public $filePath = "/images/teams";
}
