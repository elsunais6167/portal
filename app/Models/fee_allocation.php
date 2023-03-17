<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fee_allocation extends Model
{
    protected $guarded = [];

    public function getCreatedAtAttribute($value)
    {
        return date('D, M d, Y - h:ia', strtotime($value) );
    }
    
}
