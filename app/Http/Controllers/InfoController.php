<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function index()
    {
        return view('info.index');
    }

    public function buy()
    {
        return view('info.buy');
    }


}
