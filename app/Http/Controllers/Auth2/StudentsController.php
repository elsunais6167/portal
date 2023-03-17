<?php

namespace App\Http\Controllers\Auth2;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SchoolTrait;
use App\Models\User;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    use SchoolTrait;

    function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $current = $this->current_session();
        $students = $this->my_school(new User)->whereStudent(1)->whereTarget_session( $current->sessions );
        if( request()->has('filter') ){
            $students = $students->whereTarget_class( request()->q );
            if( request()->a_ ) $students = $students->whereTarget_arm( request()->a_ );
        }
        $students = $students->latest()->get();
        return view('pages.students_management', compact('students') );
    }

    public function show($id)
    {
        $student = User::find($id);
        return view('pages.edit-student', compact('student') );
    }

    public function update(Request $request, $id) {
        $student = User::find($id);
        $data = request()->except('_token', 'image');
        if( request()->hasFile('image')){
            $data['photo'] = upload_file( request()->file('image') );
        }
        $udpate =  $student->update($data);
        if(! $udpate ) return back()->withErrors(' Failed, something went wrong... ');
        return redirect()->route('students_management')->withSuccess('Updated Successfully...');
    }
    
    function register_student()
    {
        $student_id = [];
        $student_id_ = request()->_student_id;

        if( request()->has('move_students__') ){
            $d = str_replace( "id[]=", '', $student_id_);
            $student_id_ = explode( '&' , $d ) ;
            foreach( $student_id_ as $id_ ){
                $student_id[] = floatval(str_replace('id[]=', '', $id_) );
            }
            unset( $id_ );
            return $this->move_students_to_a_new_class( $student_id );
        }
        //$data = request()->except('_token');
        //info(request());
        // $data['password'] = request()->last_name;
        $data = request()->except('_token', 'image');
        if( request()->hasFile('image')){
            $data['photo'] = upload_file( request()->file('image') );
        }
        $store = User::create($data);
        if(! $store ) return back()->withErrors(' Failed, something went wrong... ');
        return back()->withSuccess('Created Successfully...');
    }

    function move_students_to_a_new_class( $student_id = [] )
    {
        foreach( $student_id as $id )
        {
            User::whereId( $id )->update([
                'target_class' => request()->target_class,
                'target_arm' => request()->target_arm,
                'target_session' => request()->target_session,
            ]);
        }
        unset( $id );
        return back()->withSuccess( 'Students Moved successfully !' );
    }

    public function destroy($id) 
    {
        $student = User::find($id);
        $student->delete();
        return back()->withSuccess( 'Students deleted successfully !' );
    }

}
