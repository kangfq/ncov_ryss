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

    }

    public function edit($id)
    {

    }

    public function update(Request $reques, $id)
    {

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
