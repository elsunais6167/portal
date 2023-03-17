<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SchoolTrait;
use App\Models\fee_expense;
use App\Models\fee_revenue;
use Illuminate\Http\Request;

class TransactionHistoryController extends Controller
{
    use SchoolTrait;

    function index()
    {
        return view('pages.transaction_history_page');
    } 

    function fetch_transaction_history_total_amounts()
    {
        $total_amount_received = $this->get_total_transactions_record()->pluck('updated_amount')->sum();
        $total_expected_amount = $this->get_total_transactions_record()->pluck('expected_amount')->sum();
        $total_outstanding_payment = $this->get_total_transactions_record()->where('balance', '>', 0)->pluck('balance')->sum();
        $total_discount_amount = $this->get_total_transactions_record()->pluck('discount_amount')->sum();
        $data = [
            'total_amount_received' => number_format( $total_amount_received ),
            'total_expected_amount' => number_format( $total_expected_amount ),
            'total_outstanding_payment' => number_format( $total_outstanding_payment ),
            'total_discount_amount' => number_format( $total_discount_amount )
        ];
        return response()->json( $data );
    }

    function fetch_transaction_history()
    {
        $school = auth()->user()->school;
        $trxn = $this->get_total_transactions_record()->latest()->get();
        return datatables()->of( $trxn )
                           ->addColumn('checkbox', function( $trxn ){
                               return "<input name='id[]' value='$trxn->id' class='checkSingle check_btn' type='checkbox'>";
                           })
                           ->editColumn('amount_paid', function( $trxn ){
                               return number_format( $trxn->updated_amount );
                           })
                           ->editColumn('expected_amount', function( $trxn ){
                               return number_format( $trxn->expected_amount );
                           })
                           ->editColumn('discount_amount', function( $trxn ){
                               return number_format( $trxn->discount_amount );
                           })
                           ->editColumn('balance', function( $trxn ){
                               return number_format( $trxn->balance );
                           })
                           ->editColumn('classes', function( $trxn ){
                               return $trxn->classes.' '.$trxn->arms;
                           })
                           ->addColumn('sub_payments', function($trxn){
                               $count_trxn = $trxn->fee_transaction_balance()->count() + 1;
                               return ($count_trxn == 1)? " Once" : $count_trxn." times";
                           })
                            ->addColumn('print_receipts', function($trxns) use ($school) {
                                return "<a target='_blank'
                                       href='".route("print_receipt", [ 'sid'=>$school->id, 
                                                                        'uid' => $trxns->student_id, 's' => $trxns->sessions,
                                                                        'classes' => $trxns->classes, 'arms' =>  $trxns->arms,
                                                                        'tid' => $trxns->id, 't' => $trxns->term, 'sn' => $school->name ] )
                                       ."'class='btn btn-sm btn-warning'><i class='fa fa-print'></i> PRINT RECEIPT </a>";
                            })
                           ->rawColumns(['checkbox', 'print_receipts', 'view_sub_payments'])
                           ->make( true );
    }
}
