<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::where('is_show', 1)->get();
        return view('message.index', compact('messages'));
    }

    public function create()
    {
        return view('message.create');
    }

    public function store(Request $request)
    {
        $data['content'] = $request->input('content');
        $data['user_id'] = Auth::id();
        $data['is_show'] = 1;
        $create = Message::create($data);
        if ($create) {
            return redirect(route('home'))->with('success', '提交成功,管理员会定时查看');
        } else {
            return back()->with('success', '提交失败!!!系统出错');
        }
    }

    public function destroy($id)
    {
        $del = Message::destroy($id);
        if ($del) {
            return back()->with('success', '删除成功');
        } else {
            return back()->with('success', '删除失败!!!');
        }
    }
}
