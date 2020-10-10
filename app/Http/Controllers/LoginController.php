<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    function  index(Request $request)
    {
        // if ($request->session()->has('data')) {
        $request->session()->put('data', $request->input()['user']);
        // }

        return redirect('/');
    }

    function exit(Request $request)
    {
        session()->forget('data');
        // $request->session()->put('data', $request->input());


        return redirect('/');
    }
}
