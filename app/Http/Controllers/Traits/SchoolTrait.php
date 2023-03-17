<?php
namespace App\Http\Controllers\Traits;

use App\Models\fee_expense;
use App\Models\fee_net_revenue;
use App\Models\fee_revenue;
use App\Models\fee_transaction_balance;
use App\Models\fee_type;
use App\Models\grade;
use App\Models\sch_session;
use App\Models\subject;
use App\Models\subject_result;
use App\Models\User;
use Illuminate\Support\Facades\DB;

trait SchoolTrait{

    function my_school( $query )
    {
        ( request()->has('g_req')) ? $school_id = request()->school_id : $school_id =  auth()->user()->school_id;
        return $query->whereSchool_id($school_id);
    }

    function current_user()
    {
        if( request()->has('g_req')) {
            $user_id = request()->student_id;
        }else{
            $user_id = auth()->id();
        }
        return User::whereId( $user_id )->first();
    }

    function get_updated_prev_trxn_balance( $trxn_id )
    {
        return fee_transaction_balance::whereFee_revenue_id( $trxn_id )
                                      ->pluck('new_amount_paid')
                                      ->sum();
    }
    
    function current_session()
    {
       return ($c = $this->my_school(new sch_session)->whereActive(1) ) ? $c->latest('updated_at')->first() : null;
    }

    function error_msg($msg='Failed, an error Occured...')
    {
        return response()->json(['error'=> $msg]);
    }

    function success_msg($msg = 'Success...')
    {
        return response()->json(['success'=> $msg]);
    }

    function fetch_fee_type()
    {
        return $this->my_school(new fee_type)->whereDeleted(0)->latest()->get();
    }

    function get_total_transactions_record()
    {
        $current_session = $this->current_session();
        $session = $current_session->sessions;
        $term = $current_session->term;
        if( $ses = request()->sessions ) $session = $ses;
        if( $t   = request()->term ) $term = $t;
        $data = $this->my_school( new fee_revenue )->whereDeleted( 0 )
                                                   ->whereTerm( $term )
                                                   ->whereSessions( $session );
        if( $fee_type = request()->fee_type ) $data = $data->whereFee_type( $fee_type );
        if( request()->transaction_type == 'debtors' ) $data = $data->where('balance', '>', 0);
        if( request()->transaction_type == 'complete_payments' ) $data = $data->whereBalance(0);
        return $data;
    }

    function get_total_expenditures_record()
    {
        $current_session = $this->current_session();
        $session = $current_session->sessions;
        $term = $current_session->term;
        if( $ses = request()->sessions ) $session = $ses;
        if( $t = request()->term ) $term = $t;
        $data = $this->my_school(new fee_expense)->whereDeleted(0)
                                                 ->whereTerm( $term )
                                                 ->whereSessions( $session );
        return $data->get();
    }
    
    function fetch_total_revenue()
    {
        return $this->my_school(new fee_revenue)->whereDeleted(0)
                                                ->select(DB::raw('sum(updated_amount) as total_revenue_amount'),
                                                         DB::raw('sessions as revenue_sessions'),  
                                                         DB::raw('term as revenue_term'))
                                                ->groupBy('term', 'sessions')
                                                ->get();
    }

    function fetch_total_expenses()
    {
        return $this->my_school(new fee_expense)->whereDeleted(0)
                                                ->select(DB::raw('sum(amount) as total_expenses_amount'),
                                                         DB::raw('sessions as expenses_sessions'),  
                                                         DB::raw('term as expenses_term'))
                                                ->groupBy('term', 'sessions')
                                                ->get();
    }

    function fetch_all_subjects( $classes = '')
    {
        $data = $this->my_school(new subject);
        if($classes) $data->whereClasses( $classes );
        return $data->orderBy('name')->get();
    }

    function get_net_income()
    {
        $total_revenues  = $this->fetch_total_revenue();
        $total_expenses  = $this->fetch_total_expenses();
        //== First Update all initial records to zero first before creating/updating new ones ===///
        $this->update_expenditure_and_revenue_records_to_null_values();
         foreach($total_revenues as &$r):
            $revenue_records = $this->find_this_revenue_or_expenses_record( $r->revenue_term, $r->revenue_sessions );
            if( $revenue_records->exists() ):
                $this->update_net_revenue_record($r);
            else:
                $this->store_net_revenue($r);
            endif;
         endforeach;
         unset($r);

         foreach($total_expenses as &$e):
            $expenditure_records = $this->find_this_revenue_or_expenses_record( $e->expenses_term, $e->expenses_sessions );
            if( $expenditure_records->exists() ):
                $this->update_net_expenses_record($e);
            else:
                $this->store_net_expenses($e);
            endif;
         endforeach;
         unset($e); 

        return $this->my_school(new fee_net_revenue)->get();
    }

    function find_this_revenue_or_expenses_record( $term = '', $session = '' )
    {
        return $this->my_school(new fee_net_revenue)->whereTerm( $term )
                                                    ->whereSessions( $session );
    }

    function store_net_revenue($data)
    {
        $store = new fee_net_revenue();
        $store->total_revenue = $data->total_revenue_amount;
        $store->term = $data->revenue_term;
        $store->sessions = $data->revenue_sessions;
        $store->school_id = auth()->user()->school_id;
        $store->save();
    }

    function store_net_expenses($data)
    {
        $store = new fee_net_revenue();
        $store->total_expenses = $data->total_expenses_amount;
        $store->term = $data->expenses_term;
        $store->sessions = $data->expenses_sessions;
        $store->school_id = auth()->user()->school_id;
        $store->save();
    }

    function update_net_revenue_record($data)
    {
        $update_amount = $data->total_revenue_amount;
        $find = $this->find_this_revenue_or_expenses_record($data->revenue_term, $data->revenue_sessions)->first();
        $total_expenses = $find->total_expenses;
        $find->update([
                       'total_revenue' => $update_amount,
                       'net_revenue' => $update_amount - $total_expenses
                       ]);
    }

    function update_net_expenses_record($data)
    {
        $update_amount = $data->total_expenses_amount;
        $find = $this->find_this_revenue_or_expenses_record($data->expenses_term, $data->expenses_sessions)->first();
        $total_revenue = $find->total_revenue;
        $find->update([
                        'total_expenses' => $update_amount,
                        'net_revenue' => $total_revenue - $update_amount
                      ]);
    }

    function update_expenditure_and_revenue_records_to_null_values()
    {
        $this->my_school(new fee_net_revenue)->update([
                                             'total_revenue' => 0,
                                             'total_expenses' => 0,
                                             'net_revenue' => 0
                                        ]);
    }

    function get_all_staff()
    {
        return $this->my_school(new User)->whereStaff(1)->latest()->get();
    }

    function grading_format()
    {
        return $this->my_school( new grade )->get();
    }

    function student_subject_results()
    {
        $find_result = $this->my_school( new subject_result )->whereTerm( request()->term )
                                                             ->whereSessions( request()->sessions )
                                                             ->whereClasses( request()->classes );                                                     
        // if( request()->arms ) $find_result = $find_result->whereArms( request()->arms );
        if( request()->subjects ) $find_result = $find_result->whereSubjects( request()->subjects );
        return $find_result;
    }

    function query_school_data( $model )
    {
        $term = request()->term;
        $sessions = request()->sessions;
        $arms = request()->arms;
        $classes = request()->classes;

        $data = $this->my_school($model)->whereTerm( $term ) 
                                        ->whereSessions( $sessions )
                                        ->whereClasses( $classes );
        if( $arms != '' ) $data  = $data->whereArms( $arms );
        return $data;
    }

}

