<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use App\Models\Log;
use App\Models\Unit;

class Set extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = ['log_id', 'order', 'sets', 'reps', 'weight', 'weight_assisted', 'duration', 'distance', 'unit_id'];

    protected $casts = [
        'reps' => 'float',
        'weight' => 'float'
    ];

    protected $with = ['unit'];

    protected $appends = ['human_readable_duration'];

    /**
     * Get the human-readable time of the workout.
     *
     *
     */
    public function getHumanReadableDurationAttribute() {
        if (!empty($this->duration)) {
            $hours = floor($this->duration/(60*60));
            $minutes = floor($this->duration/60);
            $seconds = $this->duration % 60;
            if ($hours > 1) {
                return $hours . ':' . $minutes . ':' . $seconds;
            } elseif ( $hours < 1 && $minutes > 1) {
                return $minutes . ':' . $seconds;
            } else {
                return $seconds . 's';
            }
        } else {
            return '';
        }
    }


    /**
     * Get the logs for the set.
     */
    public function log()
    {
        return $this->belongsTo(Log::class);
    }

    /**
     * Get the distance unit for the set.
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
