<?php

namespace App\Http\Controllers;

use App\Mall;
use App\Order;
use Illuminate\Http\Request;

class OrderRecycleController extends Controller
{
    //回收站主页
    public function index($mall_id)
    {
        $mall_name = Mall::find($mall_id)->name;
        $orders = Order::onlyTrashed()->where('mall_id', $mall_id)->paginate(10);
        foreach ($orders as $key => $value) {
            $pros = json_decode($value->products);
            foreach ($pros as $k => $val) {
                $orders[$key]['pro_text'] .= '['.$val->product->name.'×'.$val->total_num.']';
            }
        }
        return view('admin.recycle.index', compact('mall_id', 'mall_name', 'orders'));
    }

    //恢复订单
    public function back_order(Request $request)
    {
        $order_id = $request->input('order_id');
        $back = Order::onlyTrashed()->find($order_id)->restore();
        if ($back) {
            return back()->with('success', '恢复成功.');
        } else {
            return back()->with('success', '恢复失败!!!');
        }
    }

    //删除超过15天的订单
    public function destroy()
    {
        $del = Order::onlyTrashed()->where('deleted_at', '<', now()->subDay(15))->delete();
        if ($del) {
            return back()->with('success', '删除超过15天的订单成功');
        } else {
            return back()->with('success', '没有过期订单被删除!!');
        }

    }
}
