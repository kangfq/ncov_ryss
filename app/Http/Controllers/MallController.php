<?php

namespace App\Http\Controllers;

use App\Mall;
use Illuminate\Http\Request;

class MallController extends Controller
{
    public function index()
    {
        $malls=Mall::all();
        return view('admin.mall.index',compact('malls'));
    }
}
