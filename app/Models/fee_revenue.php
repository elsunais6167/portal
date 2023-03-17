<?php

namespace App\Models;

use App\Http\Controllers\Traits\SchoolTrait;
use Illuminate\Database\Eloquent\Model;

class fee_revenue extends Model
{
    use SchoolTrait;

    protected $guarded = [];

    public function getCreatedAtAttribute($value)
    {
        return date('D, M d, Y - h:ia', strtotime($value) );
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('D, M d, Y - h:ia', strtotime($value) );
    }

    function fee_transaction_balance()
    {
        return $this->hasMany( fee_transaction_balance::class ); 
    }

    function get_associated_fee_type_items( $fee_type )
    {
        return fee_allocation::whereSchool_id( request()->sid )
                             ->whereFee_type( $fee_type )
                             ->whereSessions( request()->s )
                             ->whereTerm( request()->t )
                             ->whereClasses( request()->classes )
                             ->whereArms( request()->arms )
                             ->select('fee_type_item', 'amount') 
                             ->get();
    }

    function get_associated_fee_type_items_total_amount($fee_type)
    {
        return $this->get_associated_fee_type_items($fee_type)->pluck('amount')->sum();
    }

    function get_total_fee_amount_paid($trxn_id, $trxn_amount)
    {
        return number_format( $trxn_amount + $this->get_updated_prev_trxn_balance( $trxn_id ) );
    }
}
