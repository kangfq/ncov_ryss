<?php

namespace App\Http\Controllers;

use App\Aged;
use Illuminate\Http\Request;

class AgedController extends Controller
{
    public function index()
    {
        $ageds = Aged::Paginate(10);
        return view('admin.aged.index', compact('ageds'));

    }

    public function create()
    {
        return view('admin.aged.create');
    }

    public function store(Request $request)
    {
        $create = Aged::create($request->all());
        if ($create) {
            return back()->with('success', '新建成功');
        } else {
            return back()->with('success', '新建失败!!!');
        }

    }

    public function edit($id)
    {
        $aged = Aged::find($id);
        return view('admin.aged.edit', compact('aged'));
    }

    public function update(Request $request, $id)
    {
        $update=Aged::find($id)->update($request->all());
        if ($update) {
            return redirect(route('admin.aged.index'))->with('success', '更新成功');
        } else {
            return back()->with('success', '更新失败');
        }

    }

    public function destroy($id)
    {
        $del = Aged::destroy($id);
        if ($del) {
            return back()->with('success', '删除成功');
        } else {
            return back()->with('success', '删除失败');
        }

    }
}
