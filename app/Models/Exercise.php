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

class Exercise extends Model
{
    use HasFactory, Uuids, Searchable, SoftDeletes;

    protected $with = ['equipment', 'muscles'];

    /**
     * Get the equipment associated with the exercise.
     */
    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'exercises_equipment');
    }

    /**
     * Get the muscles associated with the exercise.
     */
    public function muscles()
    {
        return $this->belongsToMany(Muscle::class, 'exercises_muscles')->withPivot('type')->as('relationships');
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

}
