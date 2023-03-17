<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SchoolTrait;
use App\Models\fee_revenue;
use App\Models\fee_transaction_balance;
use Illuminate\Http\Request;

class DeletedTransactionController extends Controller
{
    use SchoolTrait;

    function deleted_transactions_page()
    {
        return view('pages.deleted_transactions_page');
    }

    function fetch_trashed_transaction()
    {
        $records = $this->my_school(new fee_revenue)->whereDeleted(1)->latest('updated_at')->get();
        return datatables()->of($records)
                           ->addColumn('checkbox', function($records){
                               return "<input type='checkbox' name='id[]' value='$records->id' class='check_btn checkSingle'>";
                           })
                           ->editColumn('classes', function($records){
                            return $records->classes.' '.$records->arms;
                          })
                          ->rawColumns(['checkbox'])
                           ->make(true);
    }
 
    function undo_trashed_transaction()
    {
        $trxn_id = request()->id;
        foreach($trxn_id as &$id):
            $update = $this->my_school(new fee_revenue)->whereId( $id )->update([ 'deleted' => 0 ]);
            $this->undo_delete_updated_transaction_balance( $id);
        endforeach;
        return (! $update) ? $this->error_msg() : $this->success_msg();
    }

    function undo_delete_updated_transaction_balance( $id = null)
    {
        if( $id ):
            $this->my_school(new fee_transaction_balance)->whereFee_revenue_id( $id )->update(['deleted' => 0]);
        endif;
    }
}
