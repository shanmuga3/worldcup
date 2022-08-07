<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guess extends Model
{
    use HasFactory;

    /**
     * Join With Team User Table
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Join With Team Match Table
     *
     */
    public function match()
    {
        return $this->belongsTo(TeamMatch::class);
    }
}
