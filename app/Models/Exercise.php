<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Laravel\Scout\Searchable;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;

use App\Traits\Uuids;
use App\Models\Muscle;
use App\Models\Type;

use Auth;

class Exercise extends Model
{
    use HasFactory, Uuids, Searchable, SoftDeletes;

    protected $fillable = ['user_id', 'type_id', 'name', 'force', 'mechanics', 'difficulty'];

    protected $with = ['equipment', 'muscles'];

    protected $casts = [
        'is_verified' => 'boolean'
    ];

    /**
     * Get the equipment associated with the exercise.
     */
    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'exercise_equipment');
    }

    /**
     * Get the muscles associated with the exercise.
     */
    public function muscles()
    {
        return $this->belongsToMany(Muscle::class, 'exercise_muscle')->withPivot('type')->as('relationships');
    }

    /**
     * Get the default type of logging that should be used for this exercise.
     */
    public function default_type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mechanics' => $this->mechanics,
            'force' => $this->force,
            'difficulty' => $this->difficulty
        ];
    }

    /**
     * Scope the query to only include the user's exercises.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeAuthUser($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }

}
