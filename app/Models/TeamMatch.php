<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamMatch extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'matches';

    /**
     * Join With Team Table
     *
     */
    public function first_team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Join With Team Table
     *
     */
    public function second_team()
    {
        return $this->belongsTo(Team::class);
    }
}
