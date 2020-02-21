<?php

namespace App\Http\Controllers;

use App\Mall;
use App\Order;
use App\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function create()
    {
        $malls=Mall::where('is_show',1)->get();
        return view('admin.create',compact('malls'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['description'] = '暂时没有描述';
        $create = Product::create($data);
        if ($create) {
            return redirect(route('admin.product'))->with('success', '添加成功');
        } else {
            return back()->with('success', '添加失败!!');
        }

    }

    public function edit($id)
    {
        $malls=Mall::where('is_show',1)->get();
        $product = Product::find($id);
        return view('admin.edit', compact('product','malls'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::whereId($id)->update($request->except('_token', '_method'));
        if ($product) {
            return redirect(route('admin.product'))->with('success', '更新成功');
        } else {
            return back()->with('success', '更新失败!！！!');
        }
    }

    public function destroy($id)
    {
        $product = Product::destroy($id);
        if ($product) {
            return redirect(route('admin.product'))->with('success', '删除成功');
        } else {
            return redirect(route('admin.product'))->with('success', '删除失败！！！！');
        }

    }

    public function pay(Request $request, $id)
    {
        $pay = Order::find($id)->update(['pay_time' => now()->toDateTimeString()]);
        if ($pay) {
            return back()->with('success', '操作付款成功');
        } else {
            return back()->with('success', '操作付款失败！！！！');
        }
    }

    public function pay_back(Request $request, $id)
    {
        $pay = Order::find($id)->update(['pay_time' => null]);
        if ($pay) {
            return back()->with('success', '取消付款成功');
        } else {
            return back()->with('success', '取消付款失败！！！！');
        }
    }

    public function product()
    {
        $products = Product::where('is_show', 1)->get();
        return view('admin.product',compact('products'));
    }


    //麦德龙订单管理
    public function order()
    {
        $orders = Order::with('mall')->where('mall_id',1)->get();
        foreach ($orders as $key => $value) {
            $pros = json_decode($value->products);
            foreach ($pros as $k => $val) {
                $orders[$key]['pro_text'] .= '['.$val->product->name.'×'.$val->total_num.']';
            }
        }
        return view('admin.order',compact('orders'));
    }

    public function zborder()
    {
        $orders = Order::with('mall')->where('mall_id',2)->get();
        foreach ($orders as $key => $value) {
            $pros = json_decode($value->products);
            foreach ($pros as $k => $val) {
                $orders[$key]['pro_text'] .= '['.$val->product->name.'×'.$val->total_num.']';
            }
        }
        return view('admin.order',compact('orders'));

    }
}
