<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use App\Models\Exercise;
use App\Models\Workout;
use App\Models\Set;
use App\Models\Modifier;
use App\Models\Type;
use Auth;

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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('ordered', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });
    }

}
