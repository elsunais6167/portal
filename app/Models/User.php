<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\Traits\SchoolTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SchoolTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'remember_token', 'accountant', 'admin', 'staff', 'student'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function portal_url()
    {
        return "https://app.schoolportal360.com.ng/";
    }

    public function getLastNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getFirstNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getOtherNameAttribute($value)
    {
        return ucwords( strtolower($value));
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucwords(strtolower($value));
    } 

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucwords(strtolower($value));
    } 

    public function setOtherNameAttribute($value)
    {
        $this->attributes['other_name'] = ucwords(strtolower($value));
    }

    function school()
    {
        return $this->belongsTo(school::class);
    }

    function active_academic_session()
    {
        return $this->current_session();
    }

    function get_school_arms()
    {
        return $this->my_school(new arm)->get(); 
    }

    function get_school_classes()
    {
        return $this->my_school(new sch_class)->get();
    }

    function get_all_sessions()
    {
        return all_session::all();
    }

    function get_all_terms()
    {
        return all_term::all();
    }

    function get_all_fee_types()
    {
        return $this->fetch_fee_type();
    }

    function fetch_all_staff()
    {
        return $this->get_all_staff();
    }

    function is_sub_admin()
    {
        $status = false;
        if( $this->admin ) $status = true;
        if( $this->sub_admin ) $status = true;
        return $status;
    }

    function subject_records()
    {
        return $this->hasMany(subject_result::class, 'student_id')
                    ->whereTerm( request()->term )
                    ->whereSessions( request()->sessions)
                    ->select('student_id', 'classes', 'arms', 'subjects', 'exam_score', 'total_score', 'field1','field2','field3' , 'field4');
    }
}
