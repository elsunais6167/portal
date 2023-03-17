<?php

namespace App\Models;

use App\Http\Controllers\Traits\SchoolTrait;
use Illuminate\Database\Eloquent\Model;

class subject_result extends Model
{
    use SchoolTrait;
    protected $guarded = [];

    function student_name( $student_id = '')
    {
        $student = $this->my_school(new User)->whereId( $student_id )->first();
        return $student ? $student->last_name.' '.$student->first_name.' '.$student->other_name : '';
    }
}
