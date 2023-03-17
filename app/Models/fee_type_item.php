<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fee_type_item extends Model
{
    protected $guarded = [];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    } 

    function fee_type()
    {
        return $this->belongsTo(fee_type::class);
    }
}
