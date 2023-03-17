<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sch_class extends Model
{
    protected $guarded = [];
    
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    } 
}
