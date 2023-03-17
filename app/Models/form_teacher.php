<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class form_teacher extends Model
{
    protected $guarded = [];

    public function getCreatedAtAttribute($value)
    {
        return date("D, M d,  Y", strtotime($value) );
    }
}
