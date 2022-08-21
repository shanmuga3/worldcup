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

    // Local Scope of Match

    /**
     * Get All Active Users Only
     *
     */
    public function scopeUpcomingMatches($query)
    {
        return $query->where('starting_at','>=',date('Y-m-d H:i:s'));
    }

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

    public function getDurationAttribute()
    {
        return $this->formatted_starting_at.' - '.$this->formatted_ending_at;
    }

    public function getFormattedStartingAtAttribute()
    {
        $starting_at = getDateObject($this->attributes['starting_at']);
        return $starting_at->format(DATE_FORMAT.' '.TIME_FORMAT);
    }

    public function getFormattedEndingAtAttribute()
    {
        $ending_at = getDateObject($this->attributes['ending_at']);
        return $ending_at->format(DATE_FORMAT.' '.TIME_FORMAT);
    }

    public function getStartingInAttribute()
    {
        $starting_at = getDateObject($this->attributes['starting_at']);
        return $starting_at->format('Y-m-d H:i:s');
    }
}
