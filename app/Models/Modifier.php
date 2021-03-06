<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use App\Models\Log;

class Modifier extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    /**
     * The users that belong to the role.
     */
    public function logs()
    {
        return $this->belongsToMany(Log::class);
    }
}
