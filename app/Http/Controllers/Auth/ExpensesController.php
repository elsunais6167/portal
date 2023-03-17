<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SchoolTrait;
use App\Http\Controllers\Traits\validationsTrait;
use App\Models\fee_expense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    use SchoolTrait;
    use validationsTrait;

    function index()
    {
        return view('pages.manage_expenses_page');
    }

    function store_expenses(Request $request) 
    {
        if( ! $this->validate_expenses( $request->all() ) ) return $this->error_msg(' Please, Ensure all Fields are correctly filled... ');
        $store = fee_expense::updateOrCreate( $request->except('_token') );
        if( ! $store ) return $this->error_msg();
        return $this->success_msg();
    }

    function fetch_total_expenditure_amount()
    {
        $total_amount = $this->get_total_expenditures_record()->pluck('amount')->sum();
        $total = $this->get_total_expenditures_record()->count();
        $data = ['total_amount' => number_format($total_amount), 'total' => $total ];
        return response()->json( $data );
    }

    function fetch_all_expenditures()
    {
        $data = $this->get_total_expenditures_record();
        return datatables()->of( $data )
                           ->addColumn('checkbox', function($data){
                               return "<input type='checkbox' name='id[]' value='$data->id' class='check_btn checkSingle' >";
                           })
                           ->editColumn('amount', function( $data ) {
                               return number_format( $data->amount, 2 );
                           })
                           ->rawColumns(['checkbox'])
                           ->make( true );
    }

    function delete_expenditures()
    {
        $delete = fee_expense::destroy( request()->id );
        return ( ! $delete ) ? $this->error_msg() : $this->success_msg();
    }

    function update_expenses()
    {
        $update = $this->my_school(new fee_expense)->update( request()->all() );
        if( ! $update ) return $this->error_msg();
        return $this->success_msg();
    }
    
}
