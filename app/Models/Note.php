<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Note extends Model
{
    use HasFactory, SoftDeletes, Uuids;

    protected $fillable = [
        'body',
        'notable_type',
        'notable_id'
    ];

    /**
     * Get the parent notable model.
     */
    public function notable()
    {
        return $this->morphTo();
    }
}
