<?php

namespace App\Http\Controllers\Auth2;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SchoolTrait;
use App\Models\class_final_result;
use App\Models\grade;
use App\Models\sch_session;
use App\Models\subject;
use App\Models\subject_result;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    use SchoolTrait;

    function __construct()
    {
        // $this->middleware('guest')->except(['compute_result_page',
        //                                      'compute_subject_result',
        //                                      'view_result_page'
        //                                    ]);
    }

    function compute_result_page()
    {   $selected_student = null;
        $selected_student_uncomputed_subjects = null;
        $selected_student_computed_subjects = null;
        $students = $this->fetch_students_of_this_class();
        $subjects = $this->fetch_all_subjects( request()->classes );
        if( request()->has('compute') ):
            $subjects_array = $subjects->pluck('name')->toArray();
            $selected_student = User::whereId( request()->student_id )->with('subject_records')->first();
            $selected_student_computed_subjects = $selected_student->subject_records->pluck('subjects')->toArray();
            $selected_student_uncomputed_subjects = array_diff($subjects_array, $selected_student_computed_subjects );
        endif;
        return view("pages.compute_result" , 
                compact('students', 'subjects', 'selected_student', 
                        'selected_student_uncomputed_subjects', 'selected_student_computed_subjects') 
                    );
    }

    function compute_subject_result()
    {   
        $students = $this->fetch_students_of_this_class();
        $subjects = $this->fetch_all_subjects( request()->classes );
        return view("pages.subject_result_computation", compact('students', 'subjects') );
    }

    function view_result_page()
    {  
        $current = $this->current_session();
        $results = $this->my_school(new subject_result)
                        ->whereTerm( $current->term )
                        ->whereSessions( $current->sessions )
                        ->select('classes', 'arms')
                        ->groupBy('classes', 'arms')
                        ->get();
        return view("pages.view_results", compact('results', 'current'));
    }

    function subject_results()
    {  
        return $this->student_subject_results();
    }

    function view_class_broadsheet(Request $request)
    {
        $this->student_progress_report($request);
        $get_subjects = $this->query_school_data( new subject_result );
        $get_students = $this->query_school_data( new class_final_result );
        $get_subject  = $get_subjects->orderBy('subjects', 'asc')->groupBy('subjects')->pluck('subjects')->toArray();
        $students= $get_students->orderBy('class_position')->get();
        $subjects = $get_subject;
        return view('pages.class_broadsheet', compact('subjects', 'students'));
    }

    function student_progress_report(Request $request)
    {
        $user = auth()->user();
        if( request()->student_id && request()->g_req ){
            $academic_session = sch_session::whereTerm( request()->term)
                                           ->whereSessions( request()->sessions )
                                           ->first();
            if( is_null( $academic_session ) ) return back()->withErrors("Academic session not found !");
            if( ! $academic_session->result_published ) return back()->withErrors("Result Not Published !");
        }
        $results = $this->get_available_student_subject_results_with_student_id_for_this_request();
                   $this->compile_class_final_results($results);
                   $this->update_class_final_result_position($results);
        ( $_id   = $this->request_result_has_student_id() ) ? $student_id = $_id : $student_id = [] ;
        $student_results = $this->fetch_this_students_class_final_result($student_id)->get();    
        $grades = $this->my_school(new grade)->get()->sortBy('grade');
        $user_ = $this->current_user();
        return view('pages.student_progress_report', compact('student_results', 'grades', 'user_' )); 
    }

    function view_student_progress_report(Request $request)
    {
        return $this->student_progress_report($request);
    }

    function get_available_student_subject_results_with_student_id_for_this_request($student_id='')
    {
        $find = $this->subject_results()
                     ->select( DB::raw('sum(total_score) as total_score'), 
                               DB::raw('count(subjects) as total_subjects'), 
                               DB::raw('student_id as student_id'), 
                               DB::raw('classes as classes'), 
                               DB::raw('arms as arms') 
                               ) 
                     ->groupBy('student_id', 'classes', 'arms');
                      if($student_id) return $find->whereStudent_id($student_id)->first();
        return $find->get();
    }

    function compile_class_final_results($results)
    {
        $this->query_school_data( new class_final_result )->delete();
        foreach($results as &$student):
             ( $this->fetch_this_students_class_final_result([ $student->student_id  ])->count() ) 
                ? $this->update_class_final_result( $student->student_id, 'update' ) 
                : $this->update_class_final_result( $student->student_id, 'create' ) ;
        endforeach; 
        unset( $student );
    }

    function fetch_this_students_class_final_result( $student_id = [] )
    {
        $student_results = $this->query_school_data( new class_final_result );
        if( count( $student_id) ) $student_results = $student_results->whereIn( 'Student_id', $student_id );
        return $student_results;
    }

    function update_class_final_result_position( $results )
    {
        /// change average_scores to total_scores

        foreach($results as &$student):
            $total_scores = $this->my_school( new class_final_result )
                                   ->whereClasses($student->classes)
                                   ->whereArms($student->arms)
                                   ->whereTerm( request()->term )
                                   ->whereSessions( request()->sessions )
                                   ->get()
                                   ->sortByDesc('total_score')
                                   ->pluck('total_score')
                                   ->toArray();

            $total_score = floatval( $student->total_score );
            $position = array_search( $total_score, $total_scores ) + 1;
            $position = $this->ordinal( $position );
            $this->fetch_this_students_class_final_result([ $student->student_id ])->update(['class_position' => $position]);
        endforeach;
        unset($student); 
        return 1;
    }

    function update_class_final_result( $student_id = '', $type = 'create' )
    {
        $student= $this->get_available_student_subject_results_with_student_id_for_this_request( $student_id );
        $remarks = 'Satisfactory';
        $total_students = $this->subject_results()->whereArms( $student->arms )
                                                  ->select('student_id')
                                                  ->groupBy('student_id')
                                                  ->get()
                                                  ->count();

        $average_score = number_format( $student->total_score / $student->total_subjects, 2 );

        if($type != 'create'):
            $this->fetch_this_students_class_final_result([$student_id])
                 ->update([
                           'total_subjects' => $student->total_subjects,
                           'total_students' => $total_students,
                           'total_score'    => $student->total_score,
                           'average_score'  => $average_score,
                        ]);
        else:
            $store = new class_final_result();
            $store->school_id         = $this->school_id();
            $store->total_subjects    = $student->total_subjects;
            $store->total_students    = $total_students;
            $store->total_score       = $student->total_score;
            $store->average_score     = $average_score;
            $store->term              = request()->term;
            $store->sessions          = request()->sessions;
            $store->arms              = $student->arms;
            $store->classes           = $student->classes;
            $store->student_id        = $student->student_id;
            $store->principal_comment = $remarks;
            $store->save();
        endif;
        return 1;
    }

    function school_id()
    {
        return (request()->has('g_req')) ? request()->school_id : auth()->user()->school_id;
    }

    function request_result_has_student_id()
    {
        $id = [];
        ( $student_id = request()->student_id ) ? $id = explode(' ' , trim( $student_id ) ) : $id ;
        return array_map('trim', $id);
    }

    function subject_result()
    {
        $results = $this->student_subject_results()->whereSubjects( request()->subject )->orderBy("position")->get();
        return view("pages.subject_result", compact('results'));
    }

    function delete_subject_result()
    {
        $delete = $this->my_school(new subject_result)->whereId( request()->ref_id )->delete();
        return ! $delete ? back()->withErrors("Something went wrong... ") : back()->withSuccess("Success... ");
    }

    function fetch_students_of_this_class()
    {
        return $this->my_school( new User )->whereTarget_session( request()->sessions )
                                                ->whereTarget_arm( request()->arms )
                                                ->whereTarget_class( request()->classes )
                                                ->whereStudent(1)
                                                ->orderBy('last_name')
                                                ->select('last_name', 'first_name', 'other_name','id')
                                                ->get();
    }
    
    function store_students_result(Request $request)
    {
        /**
         * 1. check if this student result exists already and return error, else store the result
         * 2. using the student total_score, find the corresponding teacher's remark/comment, grading, grading comment,
         * 3. for each new record, update the entire Class_average, positions, lowest and highest scores
         */
       // if(! $this->validate_result_computation_requests($request->all() ) ) return $this->error_msg('All marked fields are required... ');
        if( $this->student_subject_results()->whereStudent_id(request()->student_id)->first() ){
           return $this->update_subject_result($request);
           // return $this->error_msg('Result exists already!');
        }
        if(! $this->store_this_result() ) return $this->error_msg('error!, please retry');
        if(! $this->assign_remarks_and_grading_to_this_result() ) return $this->error_msg('error!, please retry');
        if(! $this->update_class_average_lowest_and_highest_scores() ) return $this->error_msg('error!, please retry');
        if(! $this->update_student_subject_class_position() ) return $this->error_msg('error!, please retry');   
        return $this->success_msg();
    }
    
    function ordinal( $position ) 
    {
        $j = $position % 10;  
        $k = $position % 100; 
        $str = '';     
        if ($j == 1 && $k != 11) {
            $str = "st";
        } elseif ($j == 2 && $k != 12) {
            $str = "nd";
        } elseif ($j == 3 && $k != 13) {
            $str = "rd";
        } else {
            $str = "th";
        }
        return $position.$str;
    }

    function store_this_result()
    {
        return (! subject_result::create( request()->except('_token') ) ) ? 0 : 1 ; 
    }

    function assign_remarks_and_grading_to_this_result()
    {
        $grade = ''; $grade_comment = ''; 
        $remarks = '';
        $student= $this->student_subject_results()
                          ->whereStudent_id( request()->student_id)
                          ->first();

        $grades = $this->my_school(new grade)->get();
        foreach($grades as &$g):
            if($student->total_score >= $g->min_score && $student->total_score <= $g->max_score):
                $grade = $g->grade;
                $grade_comment = $g->comment;
            else:
                continue;
            endif;
        endforeach; 
        unset($g);

        $update = $student->update(['grade'=> $grade, 'comment' => $grade_comment]) ;
        return (! $update ) ? 0 : 1 ;
    }

    function update_class_average_lowest_and_highest_scores()
    {
            $students = $this->student_subject_results()->get();
            $total_scores = $students->pluck('total_score')->toArray();
            $total_number = $students->count();
            $class_average = array_sum($total_scores) / $total_number ;
            $lowest_score = $this->student_subject_results()->min('total_score');
            $highest_score = $this->student_subject_results()->max('total_score');
            $update = $this->student_subject_results()->update([
                      'class_average' => $class_average,
                      'lowest_score' =>  $lowest_score,
                      'highest_score' => $highest_score
                    ]);
            return ( ! $update ) ? 0 : 1;
    }

    function update_student_subject_class_position()
    {
        $students = $this->student_subject_results()->get();
        foreach($students->pluck('student_id')->toArray() as &$student_id):
            $student = $this->student_subject_results()->whereStudent_id($student_id)->first();
            $position = array_search($student->total_score, $students->sortByDesc('total_score')->pluck('total_score')->toArray() ) + 1 ;
            $position = $this->ordinal($position);
            $update = $student->update(['position' => $position ]);
            //if(! $update) return 0;
        endforeach; 
        unset($student_id); 
        return 1;
    }

    function update_subject_result( Request $request )
    {
        $find = $this->student_subject_results()->whereStudent_id(request()->student_id)->first();
        if( ! $find ) return back()->withErrors('Details Not Found... ');
        if(! $find->update( request()->all() ) ) return back()->withErrors( " Something went wrong... ");
        if(! $this->assign_remarks_and_grading_to_this_result() ) return back()->withErrors("Something went wrong...");
        if(! $this->update_class_average_lowest_and_highest_scores() )  return back()->withErrors(" Something went wrong... ");
        if(! $this->update_student_subject_class_position() )  return back()->withErrors( " Something went wrong... "); 

        return back()->withSuccess("Updated Successfully...");
    }

}
