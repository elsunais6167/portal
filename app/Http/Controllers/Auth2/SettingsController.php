<?php

namespace App\Http\Controllers\Auth2;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SchoolTrait;
use App\Models\arm;
use App\Models\grade;
use App\Models\sch_class;
use App\Models\sch_session;
use App\Models\subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SettingsController extends Controller
{
    use SchoolTrait;
    
    function __construct()
    {
        $this->middleware('auth');
    }
    
    function change_password(Request $request)
    {
        $user = auth()->User();
        $user->password = $request->new_password;
        $data = $user->update();
        
        return ! $data ? back()->withErrors("Failed...") : back()->withSuccess("Password changed Successfully...");
    }
    
    function change_password_page()
    {
        return view('pages.settings.change_password');
    }

    function show_academic_settings_page()
    {
        $academic_sessions = $this->my_school( new sch_session )->latest('updated_at')->get();
        $academic_arms = $this->my_school( new arm )->latest('updated_at')->get();
        $academic_classes = $this->my_school( new sch_class )->latest('updated_at')->get();
        return view('pages.settings.academic_settings', compact('academic_sessions', 'academic_arms', 'academic_classes') );
    }

    function show_grade_settings_page()
    {
        $grades = $this->grading_format();
        return view("pages.settings.grade", compact('grades') );
    }

    function show_class_arm_settings_page()
    {
        $classes = $this->my_school(new sch_class)->latest()->get();
        $arms = $this->my_school(new arm)->latest()->get();
        return view("pages.settings.class_arm", compact('classes', 'arms') );
    }

    function show_subject_settings_page()
    {
        $subjects = $this->my_school(new subject)->latest()->get();
        return view("pages.settings.subject", compact('subjects') );
    }

    function store_class_()
    {
        $save = sch_class::create( request()->except("_token") );
        return ! $save ? back()->withErrors('Something went wrong... ') : back()->withSuccess(" Success... ");
    }

    function delete_class_()
    {
        $delete = $this->my_school(new sch_class)->whereId( request()->ref_id )->delete();
        return ! $delete ? back()->withErrors('Something went wrong... ') : back()->withSuccess(" Success... ");
    }
    
    function store_arm_()
    {
        $save = arm::create( request()->except("_token") );
        return ! $save ? back()->withErrors('Something went wrong... ') : back()->withSuccess(" Success... ");
    }

    function delete_arm_()
    {
        $delete = $this->my_school(new arm)->whereId( request()->ref_id )->delete();
        return ! $delete ? back()->withErrors('Something went wrong... ') : back()->withSuccess(" Success... ");
    } 

    function store_grade()
    {
        $save = grade::create( request()->except("_token") );
        return ! $save ? back()->withErrors('Something went wrong... ') : back()->withSuccess(" Success... ");
    }

    function delete_grade()
    {
        $delete = $this->my_school(new grade)->whereId( request()->ref_id )->delete();
        return ! $delete ? back()->withErrors('Something went wrong... ') : back()->withSuccess(" Success... ");
    }   

    function store_subject()
    {
        $save = subject::create( request()->except("_token") );
        return ! $save ? back()->withErrors('Something went wrong... ') : back()->withSuccess(" Success... ");
    }

    function delete_subject()
    {
        $delete = $this->my_school(new subject)->whereId( request()->ref_id )->delete();
        return ! $delete ? back()->withErrors('Something went wrong... ') : back()->withSuccess(" Success... ");
    }

    function register_academic_session()
    {
        $store = sch_session::updateOrCreate( request()->except('_token'));
        if(! $store) return back()->withErrors('Failed, Something Went Wrong... ');
        return back()->withSuccess('Academic session created succesfully...');
    }

    function de_activate_academic_session()
    {
        $update = $this->my_school( new sch_session )->whereIn('id', request()->id )->update(['active' => 0 ]);
        return (! $update ) ? $this->error_msg() : $this->success_msg();
    }

    function activate_academic_session()
    {
        $update = $this->my_school( new sch_session )->whereIn('id', request()->id )->update(['active' => 1 ]);
        return (! $update ) ? $this->error_msg() : $this->success_msg();
    }

    function delete_academic_session()
    {
        $update = sch_session::destroy( request()->id );
        return (! $update ) ? $this->error_msg() : $this->success_msg();
    }

    function register_classes()
    {
        $store = sch_class::updateOrCreate( request()->except('_token') );
        if(! $store) return back()->withErrors('Failed, Something Went Wrong... ');
        return back()->withSuccess('Class created succesfully...');
    }

    function register_arms()
    {
        $store = arm::updateOrCreate( request()->except('_token') );
        if(! $store) return back()->withErrors('Failed, Something Went Wrong... ');
        return back()->withSuccess('Arm created succesfully... ');
    }

    function delete_class()
    {
        $delete = sch_class::destroy( request()->id );
        if(! $delete) return back()->withErrors('Failed, Something Went Wrong... ');
        return back()->withSuccess('Deleted succesfully...');
    }

    function delete_arms()
    {
        $delete = arm::destroy( request()->id );
        if(! $delete) return back()->withErrors('Failed, Something Went Wrong... ');
        return back()->withSuccess('Deleted succesfully...');
    }

    function undo_published_result()
    {
        $update = $this->my_school( new sch_session )->whereIn('id', request()->id )->update(['result_published' => 0 ]);
        return (! $update ) ? $this->error_msg() : $this->success_msg();
    }

    function publish_result()
    {
        $update = $this->my_school( new sch_session )->whereIn('id', request()->id )->update(['result_published' => 1]);
        return (! $update ) ? $this->error_msg() : $this->success_msg();
    }

}

