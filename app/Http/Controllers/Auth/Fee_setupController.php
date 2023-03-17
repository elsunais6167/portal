<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SchoolTrait;
use App\Http\Controllers\Traits\validationsTrait;
use App\Models\fee_allocation;
use App\Models\fee_discount;
use App\Models\fee_type;
use App\Models\fee_type_item;
use App\Models\User;
use Illuminate\Http\Request;

class Fee_setupController extends Controller
{
    use SchoolTrait;
    use validationsTrait;

    function index()
    {
        if(! $this->current_session()) return redirect()->route('settings');
        return view('pages.fee_setup');
    }

    function store_fee_type()
    {
       // if(! $this->validate_FeeType( request()->all() ) ) return $this->error_msg('Fee Title can not be empty... ') ;
        if(! fee_type::updateOrCreate( request()->except('_token') ) ) return $this->error_msg();
        return $this->success_msg();
    }

    function fetch_fee_types()
    {
        return $this->fetch_fee_type();
    }

    function store_fee_allocation()
    {
        //if(! $this->validate_FeeAllocation( request()->all() ) ) return $this->error_msg('All Marked fields are required... ') ;
        if(! fee_allocation::updateOrCreate( request()->except('_token'))) return $this->error_msg();
        return $this->success_msg();
    }

    function fetch_fee_allocation() 
    {
        $current = $this->current_session();
        return $this->my_school(new fee_allocation)->whereSessions($current->sessions)
                                                   ->whereTerm($current->term)
                                                   ->latest()
                                                   ->get();
    }

    function delete_fee_types()
    {
        foreach( request()->id as $id ):
          $find = $this->my_school(new fee_type)->whereId($id)->first();
          $find->update(['deleted' => 1]);
          $this->my_school(new fee_type_item)->whereFee_type( $find->name )->update(['deleted' => 1]);
        endforeach;
        return $this->success_msg();
    }

    function delete_fee_allocation()
    {
        $delete = fee_allocation::destroy( request()->id );
        return (! $delete ) ? $this->error_msg() : $this->success_msg();
    }

    function store_fee_discount()
    {
        if(! $this->validate_FeeDiscount( request()->all() ) ) return $this->error_msg('All Marked Fields are required... ') ;
        if(! fee_discount::updateOrCreate( request()->except('_token') )) return $this->error_msg();
        return $this->success_msg();
    }

    function fetch_fee_discount()
    {
        $current_session = $this->current_session();
        return $this->my_school(new fee_discount)->whereSessions( $current_session->sessions )
                                                 ->whereTerm(  $current_session->term )
                                                 ->latest()
                                                 ->get();
    }

    function fetch_student_details()
    {
        return $this->my_school(new User)
                    ->whereStudent(1)
                    ->whereTarget_session( $this->current_session()->sessions )
                    ->whereId( request()->student_id )
                    ->first();
    }

    function delete_fee_discount()
    {
        $delete = fee_discount::destroy( request()->id );
        return (! $delete ) ? $this->error_msg() : $this->success_msg();
    }

    function store_fee_item()
    {
        $store = fee_type_item::updateOrCreate( request()->except('_token') );
        if(! $store ) return $this->error_msg();
        return $this->success_msg();
    }

    function delete_fee_items()
    {
        foreach( request()->id as $id ):
          $this->my_school(new fee_type_item)->whereId($id)->update(['deleted' => 1] );
        endforeach;
        return $this->success_msg();
    }

    function fetch_fee_item()
    {
        return $this->my_school(new fee_type_item)->whereDeleted(0)->latest()->get();
    }

    function get_fee_type_item_options()
    {
        return $this->my_school(new fee_type_item)->whereFee_type( request()->fee_type )->latest()->get();
    }
}
