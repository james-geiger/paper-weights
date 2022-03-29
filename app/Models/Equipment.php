<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Uuids;

class Equipment extends Model
{
    use HasFactory, Uuids, SoftDeletes;

}
