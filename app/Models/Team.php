<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Where the Files are stored
     *
     * @var string
     */
    public $filePath = "/images/teams";
}
