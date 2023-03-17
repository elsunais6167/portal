<?php

namespace App\Models;

use App\Http\Controllers\Traits\SchoolTrait;
use Illuminate\Database\Eloquent\Model;

class class_final_result extends Model
{
    use SchoolTrait;

    protected $guarded = [];

    public function getTeachersCommentAttribute($value)
    {
        return ucfirst( strtolower($value) );
    }

    public function getPrincipalCommentAttribute($value)
    {
        return ucfirst( strtolower($value) );
    }

    public function school()
    {
        return $this->belongsTo( school::class );
    }
    
    function get_associated_subject_results($student_id)
    {
        return $this->student_subject_results()->whereStudent_id( $student_id )->get()->sortBy('subjects');
    }

    function profile($id)
    {
        return $this->my_school(new User)->whereId($id)->first();
    }

    function get_subject_score($subject = null, $student_id = '')
    {
        $get_subject_score = $this->my_school(new subject_result)->whereTerm( request()->term )
                                                                 ->whereSessions( request()->sessions )
                                                                 ->whereClasses( request()->classes ) 
                                                                 ->whereSubjects( $subject )
                                                                 ->whereStudent_id( $student_id );
        if(request()->arms) $get_subject_score = $get_subject_score->whereArms( request()->arms );
        $subject_score = $get_subject_score->first();

        return ( $subject_score ) ? $subject_score->total_score : '-';
    }

}

