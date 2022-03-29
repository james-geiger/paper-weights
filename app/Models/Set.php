<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use App\Models\Log;

class Set extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = ['log_id', 'order', 'reps', 'weight'];

    protected $casts = [
        'reps' => 'float',
        'weight' => 'float'
    ];

    /**
     * Get the logs for the workout.
     */
    public function log()
    {
        return $this->belongsTo(Log::class);
    }
}
