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

    //麦德龙菜单
    public function mdl()
    {
        return view('info.mdl');
    }

    //中百菜单
    public function zb()
    {
        return view('info.zb');
    }


}
