<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fee_type extends Model
{
    protected $guarded = [];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords( strtolower($value) );
    } 

    function fee_type_item()
    {
        return $this->hasMany(fee_type_item::class);
    }
}
