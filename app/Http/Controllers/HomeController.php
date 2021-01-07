<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DatePeriod;
use DateInterval;
use DateTime;
use DB;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }
}
