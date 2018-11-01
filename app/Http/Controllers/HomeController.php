<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->admin == true){
            return redirect(route('adminDashboard'));
        } elseif(Auth::user()->user == true){
            return redirect(route('userDashboard'));
        } else{
            return redirect(route('login'));
        }
    }
}
