<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Test extends Controller
{
    function index()
    {
        return view('chairperson.commmentanddiscussion');
    }
    function test()
    {
        return view('employee.dashboard');
    }
    function test2()
    {
        return view('employee.settings');
    }
    function test3()
    {
        return view('employee.notifications');
    }
    function test4()
    {
        return view('employee.taskcalendar');
    }

}
