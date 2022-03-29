<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use App\Models\Exercise;
use App\Models\Workout;
use App\Models\Set;
use App\Models\Modifier;

class Log extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $with = ['exercise', 'sets', 'modifiers'];

    protected $fillable = ['exercise_id', 'workout_id', 'order', 'user_id'];

    /**
     * Get the workout for the log.
     */
    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }

    /**
     * Get the exercises for the log.
     */
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    /**
     * Get the sets for the workout.
     */
    public function sets()
    {
        return $this->hasMany(Set::class);
    }

    /**
     * Get the modifiers associated with the log.
     */
    public function modifiers()
    {
        return $this->belongsToMany(Modifier::class, 'log_modifier');
    }

}
