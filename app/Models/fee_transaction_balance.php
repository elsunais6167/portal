<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fee_transaction_balance extends Model
{
    protected $guarded = [];

    public function getCreatedAtAttribute($value)
    {
        return date('D, M d, Y - h:ia', strtotime($value) );
    }

    function fee_revenue()
    {
        return $this->belongsTo(fee_revenue::class);
    }
}
