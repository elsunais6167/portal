<?php
namespace App\Http\Controllers\Traits;

use Illuminate\Contracts\Support\MessageProvider;

trait validationsTrait{

    function validate_FeeType( $data )
    {
        $rules = ['name' => 'required'];
        $validate = validator()->make($data, $rules);
        return ( $validate->fails() ) ? 0: 1; 
    }

    function validate_FeeAllocation( $data )
    {
        $rules = ['sessions' => 'required', 'term' => 'required', 'classes' => 'required', 'type'=>'required', 'amount' => 'required'];
        $validate = validator()->make($data, $rules);
        return ( $validate->fails() ) ? 0: 1; 
    }

    function validate_FeeDiscount( $data )
    {
        $rules = ['sessions' => 'required', 'term' => 'required', 'student_id' => 'required', 'fee_type'=>'required', 
                  'amount' => 'required', 'student_name' => 'required'];
        $validate = validator()->make($data, $rules);
        return ( $validate->fails() ) ? 0: 1; 
    }

    function validate_FeeRevenue( $data )
    {
        $rules = ['student_id' => 'required','student_name' => 'required', 'fee_type' =>'required', 'received_by' =>'required',
                  'expected_amount' => 'required', 'discount_amount' => 'required', 'amount_paid' => 'required'];
        $validate = validator()->make($data, $rules);
        return ( $validate->fails() ) ? 0: 1; 
    }

    function validate_expenses($data)
    {      
        $rules = ['created_by' => 'required', 'term'   => 'required', 'receiver'    => 'required', 'school_id' => 'required',
                  'sessions'   => 'required', 'amount' => 'required', 'description' => 'required' ];
        $validate = validator()->make($data, $rules);
        return ( $validate->fails() ) ? 0: 1; 
    }

}
