<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fee_discount extends Model
{
    protected $guarded = [];

    public function getDescriptionAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('D, M d, Y - h:ia', strtotime($value) );
    }
}
