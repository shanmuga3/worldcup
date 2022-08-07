<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Scope to get Translatable Languages Only
     *
     */
    public function scopeTranslatable($query)
    {
        return $query->where('is_translatable', '1');
    }
}
