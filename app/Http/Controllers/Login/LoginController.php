<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\fee_revenue;
use App\Models\sch_class;
use App\Models\arm;
use App\Models\subject_result;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function login_page()
    {
        return view('login');
    }

    function home_page()
    {
        $all_payments = [];
        $results = collect([]);
        if(request()->has('all_p')) $all_payments = $this->all_my_payments();
        $all_classes = sch_class::all()->sortBy('name');
        $all_arms = arm::all()->sortBy('name');
        if( request()->has('available_results') ) $results = $this->get_student_available_results();
        return view('homepage', compact('all_payments', 'all_classes', 'all_arms', 'results'));
    }

    function get_student_available_results()
    {
        $results =  subject_result::whereStudent_id( request()->student_id )
                                  ->select('classes', 'arms', 'sessions', 'term')
                                  ->groupBy('classes', 'arms', 'sessions', 'term')
                                  ->get();
        return $results;
    }

    function all_my_payments()
    {
        return fee_revenue::whereStudent_id( request()->student_id )->get();
    }

    public function register_page()
    {
        return view('register');
    }

    public function login_user(Request $request)
    {
        $this->validate($request, ['id'=> 'required', 'password' => 'required' ]);
        $confirm_user = auth()->attempt(request(['id', 'password']), true);
        if(! $confirm_user): return redirect()->back()->withInput()->withErrors('Invalid Login details...'); endif;
        return redirect()->route('dashboard');      
    }
    
}
