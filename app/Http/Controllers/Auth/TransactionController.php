<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SchoolTrait;
use App\Models\fee_allocation;
use App\Models\fee_discount;
use App\Models\fee_revenue;
use App\Models\fee_transaction_balance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use SchoolTrait;

    function index()
    {
        return view('pages.transactions');
    }

    function expected_fee_amount()
    {
        $current_session = $this->current_session();
        return $this->my_school(new fee_allocation)->whereTerm( $current_session->term )
                                                   ->whereSessions( $current_session->sessions )
                                                   ->whereClasses( request()->classes )
                                                   ->whereArms( request()->arms )
                                                   ->whereFee_type( request()->fee_type );
    }
    
    function fetch_allocated_fee_amount()
    {
        $current_session = $this->current_session();
        $discount_amount = $this->my_school(new fee_discount)->whereTerm( $current_session->term )
                                                             ->whereSessions( $current_session->sessions )
                                                             ->whereStudent_id( request()->student_id)
                                                             ->whereClasses( request()->classes )
                                                             ->whereArms( request()->arms )
                                                             ->whereFee_type( request()->fee_type )
                                                             ->first();

        
         $expected_amount = $this->expected_fee_amount()->pluck('amount')->sum();

        ($discount_amount) ? $discount_amount = $discount_amount->amount : $discount_amount = 0.00;
        if($expected_amount == 0) $expected_amount = '';
        $data = ['discount_amount' => $discount_amount, 'expected_amount' => $expected_amount];
        return response()->json($data);   
    }

    function store_fee_revenue()
    {
        $user = auth()->user();
        $status = 0;
        $current_session = $this->current_session();
        $amount_paid = request()->amount_paid;
        $amount_payable = request()->amount_payable;
        $expected_amount = request()->expected_amount;
        $discount_amount = request()->discount_amount;
        $student_id = request()->student_id;
        $student_name = request()->student_name;
        $class = request()->classes;
        $arm = request()->arms;
        $fee_type = request()->fee_type;
        $payment_mode = request()->payment_mode;
        $session = $current_session->sessions;
        $term = $current_session->term;
        $narration = request()->description;
        ($discount_amount != 0 ) ? $discount_status = 1 : $discount_status = 0;
        $trxn_ref_no = strtoupper( uniqid() );
        $balance = $amount_payable - $amount_paid ;
        $school_id = $user->school_id;
        $received_by = $user->last_name.' '.$user->first_name.' '.$user->other_name.' - '.$user->id;
        
        $store = fee_revenue::updateOrCreate([
            'sessions' => $session,
            'term' => $term,
            'amount_paid' => $amount_paid,
            'updated_amount' => $amount_paid,
            'expected_amount' => $expected_amount,
            'amount_due' => $amount_payable,
            'ref_no' => $trxn_ref_no,
            'discount_amount' => $discount_amount,
            'student_id' => $student_id,
            'student_name' => $student_name,
            'fee_type' => $fee_type,
            'classes' => $class,
            'arms' => $arm,
            'description' => $narration,
            'payment_mode' => $payment_mode,
            'discount_status' => $discount_status,
            'balance' => $balance,
            'school_id' => $school_id,
            'received_by' => $received_by
        ]);
        
        if(! $store ) return $this->error_msg();
        return $this->success_msg();
    }

    function get_total_transactions_for_today()
    {     
        return $this->my_school(new fee_revenue)->whereDeleted(0)->whereDate('created_at', Carbon::today() );
    }

    function get_total_updated_fee_transaction_balance_for_today()
    {
        return $this->my_school(new fee_transaction_balance)->whereDeleted(0)->whereDate('created_at', Carbon::today() );
    }

    function fetch_daily_total_transaction_amount()
    {
       $total_expected_amount = $total_amount_received = $total_outstanding_amount = $total_discount_amount = '0.00';
       $today_records = $this->get_total_transactions_for_today();
       $today_updated_transaction_records = $this->get_total_updated_fee_transaction_balance_for_today();
       $today_expected_updated_trxn_amount = $today_updated_transaction_records->pluck('new_amount_paid')->sum();
       $total_expected_amount    = $today_records->pluck('amount_due')->sum();
       $today_updated_trxn_amount_received = $today_updated_transaction_records->pluck('new_amount_paid')->sum();
       $total_amount_received    = $today_records->pluck('amount_paid')->sum();
       $total_discount_amount    = $today_records->pluck('discount_amount')->sum();
       $total_outstanding_amount = $today_records->where('balance', '>', 0)->pluck('balance')->sum();
       $total_transactions = $this->get_total_transactions_for_today()->count();
       $total_updated_balance_trxns = $this->get_total_updated_fee_transaction_balance_for_today()->count();
       $total_completed_transactions = $this->get_total_transactions_for_today()->where('balance', '==', 0)->count();
       $total_updated_balance_completed_trxns = $this->get_total_updated_fee_transaction_balance_for_today()->where('balance', '==', 0)->count();
       $total_incompleted_transactions = $total_transactions - $total_completed_transactions;
       $total_updated_balance_incompleted_trxns = $total_updated_balance_trxns - $total_updated_balance_completed_trxns;

       $data = [ 'total_expected_amount'    => number_format( $total_expected_amount + $today_expected_updated_trxn_amount),
                 'total_amount_received'    => number_format( $total_amount_received + $today_updated_trxn_amount_received),
                 'total_outstanding_amount' => number_format( $total_outstanding_amount ),
                 'total_discount_amount'    => number_format( $total_discount_amount ),
                 'total_transactions' => $total_transactions + $total_updated_balance_trxns,
                 'total_completed_transactions' => $total_completed_transactions + $total_updated_balance_completed_trxns,
                 'total_incompleted_transactions' => $total_incompleted_transactions + $total_updated_balance_incompleted_trxns
               ];
       return response()->json( $data ); 
    }

    function delete_transactions()
    {
        $array = request()->id;
        $user = auth()->user();
        $name = $user->last_name.' '.$user->first_name.' '.$user->other_name.' - '.$user->id;
        $delete = 0;
        foreach($array as &$id):
            $delete = $this->my_school(new fee_revenue)->whereId($id)->update([
                'deleted' => 1,
                'deleted_by' => $name
            ]);
            $this->delete_updated_transaction_balance( $id );
        endforeach;
        unset($id);
        return ( ! $delete ) ? $this->error_msg() : $this->success_msg();
    }

    function delete_updated_transaction_balance( $id = null)
    {
        if( $id ):
            $this->my_school(new fee_transaction_balance)->whereFee_revenue_id( $id )->update(['deleted' => 1]);
        endif;
    }

    function fetch_fee_transactions() 
    {
        $school = auth()->user()->school;
        $trxns = $this->get_total_transactions_for_today()->latest()->get();;
        return  datatables()->of( $trxns )
                            ->addColumn('checkbox', function($trxns){
                                return "<input type='checkbox' name='id[]' class='check_btn checkSingle' value='$trxns->id'>";
                            })
                            ->editColumn('amount_paid', function($trxns){
                                return number_format($trxns->amount_paid, 2);
                            })
                            ->addColumn('amount_due', function($trxns){
                                return number_format( $trxns->expected_amount - $trxns->discount_amount, 2 );
                             })
                            ->editColumn('classes', function($trxns){
                                return $trxns->classes.' '.$trxns->arms;
                              })
                            ->editColumn('expected_amount', function($trxns){
                                return number_format($trxns->expected_amount, 2);
                              })
                            ->editColumn('discount_amount', function($trxns){
                                return number_format($trxns->discount_amount, 2);
                              })
                            ->editColumn('balance', function($trxns){
                                return number_format($trxns->balance, 2);
                              })
                              ->addColumn('status', function($trxns){
                                $status = 'Over Paid';
                                if($trxns->balance == 0):
                                    $status = " Completed Transaction";
                                    elseif($trxns->balance > 0):
                                        $status = "  Incomplete Transaction";
                                    else:
                                        $status;
                                endif;
                                return $status;
                            })
                            ->addColumn('print_receipts', function($trxns) use ($school) {
                                return "<a target='_blank'
                                       href='".route("print_receipt", [ 'sid'=>$school->id, 'uid' => $trxns->student_id, 's' => $trxns->sessions,
                                                                        'tid' => $trxns->id, 'classes' => $trxns->classes, 'arms' =>  $trxns->arms,
                                                                        't' => $trxns->term, 'sn' => $school->name ] )
                                       ."' class='btn btn-sm btn-outline-primary'><i class='fa fa-print'></i> PRINT RECEIPT </a>";
                            })
                            ->rawColumns(['checkbox', 'amount_paid', 'expected_amount', 'balance', 'status', 'print_receipts', 'actions' ])
                            ->make(true);
    }

    function find_transaction()
    {
        return $this->my_school(new fee_revenue)->whereId( request()->id )->first();
    }

    function update_transaction() 
    {
        /**
         * 1. Update Transaction record with the balance fee brought
         * 2. Create a new balance trxn to show the balance trxn of the initial fee
         */
        $user = auth()->user();
        $id = request()->trxn_id;
        $student_id = request()->update_student_id;
        $student_name = request()->student_name;
        $classes = request()->update_classes;
        $arms = request()->update_arms;
        $term = request()->update_term;
        $sessions = request()->update_sessions;
        $expected_amount = request()->update_expected_amount;
        $prev_amount = request()->update_previous_amount;
        $amount_due = request()->update_amount_due;
        $amount_being_paid = request()->update_amount;
        $payment_mode = request()->update_payment_mode;
        $description = request()->update_description;
        $staff_name = $user->last_name.' '.$user->first_name.' '.$user->other_name.' - '.$user->id;
        $trxn_record = $this->my_school(new fee_revenue)->whereId( $id )->first();
        $updated_prev_trxn_bal = $this->get_updated_prev_trxn_balance( $trxn_record->id  );

        $initial_amount_paid =  $trxn_record->amount_paid;
        $updated_paid_amount = $initial_amount_paid + $updated_prev_trxn_bal + $amount_being_paid;
        $updated_balance = $trxn_record->amount_due - $updated_paid_amount;
        
        $update_transaction = $trxn_record->update([
            'balance' => $updated_balance,
            'balance_updated' => 1,
            'updated_amount' => $updated_paid_amount
        ]);
        if( ! $update_transaction ) return $this->error_msg();

        $store_trxn_balance = new fee_transaction_balance();
        $store_trxn_balance->fee_revenue_id = $id;
        $store_trxn_balance->school_id = $user->school_id;
        $store_trxn_balance->new_amount_paid = $amount_being_paid;
        $store_trxn_balance->initial_amount_paid = $initial_amount_paid + $updated_prev_trxn_bal;
        $store_trxn_balance->received_by = $staff_name;
        $store_trxn_balance->payment_mode = $payment_mode;
        $store_trxn_balance->description = $description;
        $store_trxn_balance->balance = $updated_balance;
        $store_trxn_balance->save();
        if( ! $store_trxn_balance ) return $this->error_msg();
        return $this->success_msg();
    }

    function fetch_updated_fee_transaction_balance_records()
    {
        /**
         **** Get records on Daily basis, if it exixts..
         **/
        $records = $this->my_school(new fee_transaction_balance)->with('fee_revenue')
                        ->whereDate('created_at', Carbon::today() )
                        ->whereDeleted(0)
                        ->latest()
                        ->get();

        return datatables()->of($records)
                           ->addColumn('student_id', function($records){
                               return $records->fee_revenue->student_id;
                           })
                           ->addColumn('trxn_id', function($records){
                               return $records->fee_revenue->id;
                           })
                           ->addColumn('student_name', function($records){
                               return $records->fee_revenue->student_name;
                           })
                           ->addColumn('classes', function($records){
                               return $records->fee_revenue->classes.' '.$records->fee_revenue->arms;
                           })
                           ->addColumn('fee_type', function($records){
                               return $records->fee_revenue->fee_type;
                           })
                           ->addColumn('amount_due', function($records){
                               return number_format( $records->fee_revenue->amount_due);
                           })
                           ->editColumn('new_amount_paid', function($records){
                               return number_format( $records->new_amount_paid );
                           })
                           ->editColumn('initial_amount_paid', function($records){
                               return number_format( $records->initial_amount_paid );
                           })
                           ->editColumn('balance', function($records){
                               return number_format( $records->balance );
                           })
                           ->addColumn('status', function($records){
                               $status = ' Over Paid';
                               if( $records->balance == 0):
                                $status = " Completed Transaction";
                               elseif($records->balance > 0):
                                $status = " Incomplete Transaction";
                               endif;
                               return $status;
                           })
                           ->make(true); 
    }

    function search_transaction_record()
    {   
        $trnx_id = request()->tid;
        $search = $this->my_school( new fee_revenue )->whereId( $trnx_id )->whereDeleted(0)->first();
        if( $search ):
            return redirect()->route('print_receipt', [
                'sid'=> $search->school_id,
                'tid' => $trnx_id,
                't' => $search->term,
                's' => $search->sessions,
                'classes' => $search->classes,
                'arms' => $search->arms
            ]);
        endif;
        return redirect()->route('print_receipt');
    }
}
