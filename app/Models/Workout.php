<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Set;
use App\Models\Modifier;
use App\Traits\Uuids;

class Workout extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = ['user_id', 'name', 'date', 'time'];

    protected $appends = ['human_readable_date', 'human_readable_time'];

    /**
     * Get the human-readable date of the workout.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function humanReadableDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => (new Carbon($attributes['date']))->format('F j, Y'),
        );
    }

    /**
     * Get the human-readable time of the workout.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function humanReadableTime(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => (array_key_exists('time', $attributes)) ? (new Carbon($attributes['time']))->format('g:i A') : ''
        );
    }

    /**
     * Get the logs for the workout.
     */
    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    /**
     * Get all of the sets for the workout.
     */
    public function sets()
    {
        return $this->hasManyThrough(Set::class, Log::class);
    }

    /**
     * Get all of the modifiers for the workout.
     */
    public function modifiers()
    {
        return $this->hasManyThrough(Modifier::class, Log::class);
    }

    /**
     * Scope the query to only include the user's workouts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeAuthUser($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }

    /**
     * Scope the query to return workouts in newest to oldest order.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeNewest($query)
    {
        return $query->orderBy('date', 'desc');
    }
}
