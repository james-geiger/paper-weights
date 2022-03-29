<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Models\MuscleGroup;

class Muscle extends Model
{
    use HasFactory, Uuids;

    protected $with = ['muscle_group'];

    /**
     * Get the muscle group associated with the muscle.
     */
    public function muscle_group()
    {
        return $this->belongsTo(MuscleGroup::class);
    }
}
