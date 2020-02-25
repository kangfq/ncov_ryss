<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $count=User::all()->count();
        $users = User::with('address')->paginate(10);
        return view('user.index', compact('users','count'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $update = User::where('id',$id)->update(['is_admin'=>$request->input('is_admin')]);
        if ($update) {
            return redirect(route('user.index'))->with('success', '更新成功');
        } else {
            return back()->with('success', '更新失败！！');
        }
    }
}
