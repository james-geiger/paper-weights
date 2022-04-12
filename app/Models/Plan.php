<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use App\Models\Log;
use Auth;

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

    /**
     * Scope the query to only include the user's workout plans.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeAuthUser($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }

    /**
     * Scope the query to return workout plans in newest to oldest order.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeNewest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
