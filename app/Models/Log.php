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
use App\Models\Type;

class Log extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $with = ['exercise', 'sets', 'modifiers', 'type'];

    protected $fillable = ['exercise_id', 'workout_id', 'order', 'user_id', 'type_id'];

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
     * Get the type of logging that should be used for this exercise.
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Get the modifiers associated with the log.
     */
    public function modifiers()
    {
        return $this->belongsToMany(Modifier::class, 'log_modifier');
    }

    /**
     * Get the parent model (workout or plan).
     */
    public function loggable()
    {
        return $this->morphTo();
    }

}
