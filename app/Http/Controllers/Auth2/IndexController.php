<?php

namespace App\Http\Controllers\Auth2;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SchoolTrait;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    use SchoolTrait;

    function __construct()
    {
        $this->middleware('auth');
    }

    function delete_users()
    {
        $delete = User::destroy( request()->id );
        if(! $delete ) return back()->withErrors('Failed, Something went Wrong...');
        return back()->withSuccess('Deleted Successfully...');
    }
}
