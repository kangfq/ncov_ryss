<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $address = Address::where('user_id', Auth::id())->first();
        return view('home.address.index',compact('address'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $address = Address::create($data);
        if ($address) {
            return redirect(route('home'))->with('success', '收货信息创建成功!');
        } else {
            return back()->with('success', '收货信息创建失败,请重试,多次失败请联系管理员!');
        }
    }

    public function destroy($id)
    {
        $del=Address::destroy($id);
        if ($del) {
            return back()->with('success', '删除用户收货信息成功。');
        } else {
            return back()->with('success', '删除用户收货信息失败！！！');
        }
    }


}
