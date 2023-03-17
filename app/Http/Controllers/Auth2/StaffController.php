<?php

namespace App\Http\Controllers\Auth2;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SchoolTrait;
use App\Models\form_teacher;
use App\Models\subject;
use App\Models\subject_teacher;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    use SchoolTrait;

    function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $staff_members = $this->get_all_staff();
        return view('pages.staff_management', compact('staff_members'));
    }

    function register_staff()
    {
        $data = request()->except('_token');
        $data['password'] = request()->last_name;
        $store = User::create( $data );
        if(! $store ) return back()->withErrors('Failed, something went wrong...');
        return back()->withSuccess('Created Successfully...');
    }

    function remove_staff_as_admin()
    {
        $update = $this->my_school(new User)->whereStaff(1)->whereIn('id', request()->id )->update(['admin' => 0]);
        return (! $update ) ? $this->error_msg() : $this->success_msg();
    }

    function remove_staff_as_accountant() 
    {
        $update = $this->my_school(new User)->whereStaff(1)->whereIn('id', request()->id )->update(['accountant' => 0]);
        return (! $update ) ? $this->error_msg() : $this->success_msg();
    }

    function remove_staff_as_sub_admin() 
    {
        $update = $this->my_school(new User)->whereStaff(1)->whereIn('id', request()->id )->update(['sub_admin' => 0]);
        return (! $update ) ? $this->error_msg() : $this->success_msg();
    }

    function make_staff_admin()
    {
        $update = $this->my_school( new User )->whereStaff(1)->whereIn('id', request()->id )->update(['admin' => 1]);
        return (! $update ) ? $this->error_msg() : $this->success_msg();
    }

    function make_staff_accountant()
    {
        $update = $this->my_school( new User )->whereStaff(1)->whereIn('id', request()->id )->update(['accountant' => 1]);
        return (! $update ) ? $this->error_msg() : $this->success_msg();
    }

    function make_staff_sub_admin()
    {
        $update = $this->my_school( new User )->whereStaff(1)->whereIn('id', request()->id )->update(['sub_admin' => 1]);
        return (! $update ) ? $this->error_msg() : $this->success_msg();
    }

    function my_form_class()
    {
        $my_form_classes = $this->my_school( new form_teacher );
        if( ! current_user()->is_sub_admin() ) $my_form_classes = $my_form_classes->whereUser_id( current_user()->id ); 
        $my_form_classes = $my_form_classes->latest()->get();
        $subjects = $this->fetch_all_subjects();
        $subject_teacher_classes = $this->my_school(new subject_teacher)->whereUser_id(auth()->id())->latest()->get(); 
        return view("pages.my_form_class", compact('my_form_classes', 'subjects', 'subject_teacher_classes'));
    }

    function form_teachers()
    {
        $form_teachers = $this->my_school(new form_teacher)->latest()->get();
        return view("pages.form_teachers", compact("form_teachers"));
    }

    function subject_teachers()
    {
        if( request()->has('get_available_subjects') ){
            $subjects = $this->my_school(new subject)->whereClasses( request()->classes )->get()->pluck('name');
            return response()->json(['subjects' => $subjects]);
        }
        $subject_teachers = $this->my_school(new subject_teacher)->latest()->get();
        return view("pages.subject_teachers", compact("subject_teachers"));
    }

    function remove_form_teacher()
    {
        $delete = $this->my_school(new form_teacher)->whereId( request()->u_id )->delete();
        return ! $delete ? back()->withErrors("Failed...") : back()->withSuccess("Removed Successfully...");
    }

    function remove_subject_teacher()
    {
        $delete = $this->my_school(new subject_teacher)->whereId( request()->u_id )->delete();
        return ! $delete ? back()->withErrors("Failed...") : back()->withSuccess("Removed Successfully...");
    }
    
    function register_new_form_teacher()
    {
         //cHECK IF THIS CLASS HAS BEEN ASSIGNED TO A STAFF ALREADY //
        $check =  $this->my_school(new form_teacher)->whereClasses( request()->classes )
                                                    ->whereArms( request()->arms)
                                                    ->first();
        if($check) return back()->withErrors('This Class has been Assigned already... ') ; 
        $staff_id = explode('/', request()->user_id)[0];
        $staff_name = explode('/', request()->user_id)[1];
        $store = form_teacher::create([
            'school_id' => auth()->user()->school_id,
            'user_id' => $staff_id,
            'name' => $staff_name,
            'classes' => request()->classes,
            'arms' => request()->arms
        ]);
        return ! $store ? back()->withErrors("Failed... ") : back()->withSuccess("Added Successfully...");
    }

    function register_new_subject_teacher()
    {
         //cHECK IF THIS CLASS HAS BEEN ASSIGNED TO A STAFF ALREADY //
        $check =  $this->my_school(new subject_teacher)->whereClasses( request()->classes )
                                                       ->whereArms( request()->arms)
                                                       ->whereSubject( request()->subject )
                                                       ->first();
        if($check) return back()->withErrors('This Subject and Class has been Assigned already... ') ; 
        $staff_id = explode('/', request()->user_id)[0];
        $staff_name = explode('/', request()->user_id)[1];
        $store = subject_teacher::create([
            'school_id' => auth()->user()->school_id,
            'user_id' => $staff_id,
            'name' => $staff_name,
            'classes' => request()->classes,
            'subject' => request()->subject,
            'arms' => request()->arms
        ]);
        return ! $store ? back()->withErrors("Failed... ") : back()->withSuccess("Added Successfully...");
    }

    public function show($id)
    {
        $staff = User::find($id);
        return view('pages.change-staff-password', compact('staff') );
    }

    public function update(Request $request, $id) {
        $staff = User::find($id);
        $udpate =  $staff->update([
            'password' => $request->new_password
        ]);
        if(!$udpate) {
            return back()->withErrors(' Failed, something went wrong... ');
        } else {
            return back()->withSuccess('Updated Successfully...');
        }
       
    }

}
