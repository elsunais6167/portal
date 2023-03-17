<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SchoolTrait;
use App\Models\fee_expense;
use App\Models\fee_net_revenue;
use App\Models\fee_revenue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use SchoolTrait;

    function index()
    {
        if( ! auth()->user()->admin ) return redirect()->route('my_form_class');
        
        $current = $this->current_session();
        if(! $current ) return redirect()->route('settings');
        $this->get_net_income();
        $net_revenue = $this->my_school(new fee_net_revenue)
                            ->whereSessions( $current->sessions )
                            ->whereTerm( $current->term )
                            ->pluck('net_revenue')
                            ->sum();
                            
        $last_5_trxns = $this->get_total_transactions_record()->latest()->get()->take(5);
        $last_5_expenses = $this->get_total_expenditures_record()->take(5);
        $total_revenues = $this->my_school(new fee_revenue)
                               ->whereDeleted(0)
                               ->whereSessions( $current->sessions )
                               ->whereTerm( $current->term )
                               ->pluck('updated_amount')
                               ->sum();

        $total_expenses = $this->my_school(new fee_expense)
                               ->whereSessions( $current->sessions )
                               ->whereDeleted(0)
                               ->whereTerm( $current->term )
                               ->pluck('amount')
                               ->sum();

        return view('pages.dashboard', compact('net_revenue', 'last_5_trxns', 'last_5_expenses', 'total_revenues', 'total_expenses') );
    }

}




