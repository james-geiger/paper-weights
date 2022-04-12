<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use App\Models\Log;

class Plan extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    /**
     * Get the logs for the plan.
     */
    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }
}
