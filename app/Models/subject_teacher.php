<?php

namespace App\Models;

use App\Http\Controllers\Traits\SchoolTrait;
use Illuminate\Database\Eloquent\Model;

class subject_teacher extends Model
{
    use SchoolTrait;
    protected $guarded = [];
}
