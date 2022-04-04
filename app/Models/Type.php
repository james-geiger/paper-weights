<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Type extends Model
{
    use HasFactory, Uuids;

    protected $casts = [
        'columns' => 'json'
    ];

    /**
     * Scope the query to return workouts in newest to oldest order.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

}
