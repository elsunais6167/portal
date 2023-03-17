<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\SchoolTrait;
use App\Models\fee_revenue;
use App\Models\school;
use Illuminate\Http\Request;

class ReceiptController extends Controller 
{
    use SchoolTrait;

    function index()
    {
        $receipt = fee_revenue::whereSchool_id( request()->sid )
                              ->whereId( request()->tid );
        if( request()->uid ) $receipt = $receipt->whereStudent_id( request()->uid );
        $receipt = $receipt->with( 'fee_transaction_balance' )
                           ->first();
        if( ! $receipt) return back()->withErrors('Transaction Not Found...');
        $school = school::find( $receipt->school_id );
        return view('pages.receipt', compact('receipt', 'school') );
    }
}
