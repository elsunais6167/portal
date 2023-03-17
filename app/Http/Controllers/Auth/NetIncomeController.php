<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SchoolTrait;
use Illuminate\Http\Request;

class NetIncomeController extends Controller
{
    use SchoolTrait;

    function index()
    {
        $net_incomes = $this->get_net_income();
        return view('pages.net_revenue', compact('net_incomes'));  
    }
}
