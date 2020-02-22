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
        $malls = Mall::all();
        return view('admin.create', compact('malls'));
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
        $malls = Mall::all();
        $product = Product::find($id);
        return view('admin.edit', compact('product', 'malls'));
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

    //删除商品
    public function destroy($id)
    {
        $product = Product::destroy($id);
        if ($product) {
            return redirect(route('admin.product'))->with('success', '删除成功');
        } else {
            return redirect(route('admin.product'))->with('success', '删除失败！！！！');
        }

    }

    //确认收款
    public function pay(Request $request)
    {
        $id = $request->input('id');
        $pay = Order::find($id)->update(['pay_time' => now()->toDateTimeString()]);
        if ($pay) {
            return $info = ['state' => 1, 'msg' => '收款成功'];
        } else {
            return $info = ['state' => 0, 'msg' => '收款失败'];
        }
    }

    //取消确认收款
    public function pay_back(Request $request)
    {
        $id = $request->input('id');
        $pay = Order::find($id)->update(['pay_time' => null]);
        if ($pay) {
            return $info = ['state' => 1, 'msg' => '取消成功'];
        } else {
            return $info = ['state' => 0, 'msg' => '取消失败'];
        }
    }

    public function product()
    {
        $products = Product::where('is_show', 1)->get();
        return view('admin.product', compact('products'));
    }


    //麦德龙订单管理
    public function order(Request $request)
    {
        $state = Mall::find(1)->is_show;
        $c_time = array();
        if ($request->input('created_at') != '') {
            $c_time = function ($query) use ($request) {
                $query->whereDate('created_at', '=', $request->input('created_at'));
            };
        }
        $p_time = array();
        if ($request->input('pay_date') != '') {
            $p_time = function ($query) use ($request) {
                $query->whereDate('pay_time', '=', $request->input('pay_date'));
            };
        }
        $p_state = array();
        if ($request->input('pay_state') == 'y') {
            $p_state = function ($query) use ($request) {
                $query->whereNotNull('pay_time');
            };
        }
        if ($request->input('pay_state') == 'n') {
            $p_state = function ($query) use ($request) {
                $query->whereNull('pay_time');
            };
        }
        $success = array();
        if ($request->input('is_success') == 'y') {
            $success = function ($query) use ($request) {
                $query->where('is_success', '=', 1);
            };
        }
        if ($request->input('is_success') == 'n') {
            $success = function ($query) use ($request) {
                $query->where('is_success', '=', 0);
            };
        }
        $mall_id = 1;
        $orders = Order::with('mall')
            ->where('mall_id', 1)
            ->where($c_time)
            ->where($p_time)
            ->where($p_state)
            ->where($success)
            ->paginate(15);

        //汇总信息
        $orders_count = Order::with('mall')->where('mall_id', 2)
            ->where($c_time)
            ->where($p_time)
            ->where($p_state)
            ->where($success)
            ->get();
        $base['total_num'] = array_sum($orders_count->pluck('total_num')->toArray());
        $base['total_money'] = array_sum($orders_count->pluck('total_money')->toArray());
        $base['total_pay_money'] = 0;
        $pay_moneys = $orders_count->pluck('total_money', 'pay_time')->toArray();
        foreach ($pay_moneys as $k => $v) {
            if ($k != '') {
                $base['total_pay_money'] += $v;
            }
        }
        $base['success_y'] = array_sum($orders_count->pluck('is_success')->toArray());
        $base['success_n'] = $orders_count->count() - $base['success_y'];
        $base['count'] = $orders_count->count();

        foreach ($orders as $key => $value) {
            $pros = json_decode($value->products);
            foreach ($pros as $k => $val) {
                $orders[$key]['pro_text'] .= '['.$val->product->name.'×'.$val->total_num.']';
            }
        }

        return view('admin.order', compact('orders', 'mall_id', 'base', 'state'));
    }

    public function zborder(Request $request)
    {
        $state = Mall::find(2)->is_show;
        $c_time = array();
        if ($request->input('created_at') != '') {
            $c_time = function ($query) use ($request) {
                $query->whereDate('created_at', '=', $request->input('created_at'));
            };
        }
        $p_time = array();
        if ($request->input('pay_date') != '') {
            $p_time = function ($query) use ($request) {
                $query->whereDate('pay_time', '=', $request->input('pay_date'));
            };
        }
        $p_state = array();
        if ($request->input('pay_state') == 'y') {
            $p_state = function ($query) use ($request) {
                $query->whereNotNull('pay_time');
            };
        }
        if ($request->input('pay_state') == 'n') {
            $p_state = function ($query) use ($request) {
                $query->whereNull('pay_time');
            };
        }
        $success = array();
        if ($request->input('is_success') == 'y') {
            $success = function ($query) use ($request) {
                $query->where('is_success', '=', 1);
            };
        }
        if ($request->input('is_success') == 'n') {
            $success = function ($query) use ($request) {
                $query->where('is_success', '=', 0);
            };
        }
        $mall_id = 2;
        $orders = Order::with('mall')->where('mall_id', 2)
            ->where($c_time)
            ->where($p_time)
            ->where($p_state)
            ->where($success)
            ->paginate(10);
        //汇总信息
        $orders_count = Order::with('mall')->where('mall_id', 2)
            ->where($c_time)
            ->where($p_time)
            ->where($p_state)
            ->where($success)
            ->get();
        $base['total_num'] = array_sum($orders_count->pluck('total_num')->toArray());
        $base['total_money'] = array_sum($orders_count->pluck('total_money')->toArray());
        $base['total_pay_money'] = 0;
        $pay_moneys = $orders_count->pluck('total_money', 'pay_time')->toArray();
        foreach ($pay_moneys as $k => $v) {
            if ($k != '') {
                $base['total_pay_money'] += $v;
            }
        }
        $base['success_y'] = array_sum($orders_count->pluck('is_success')->toArray());
        $base['success_n'] = $orders_count->count() - $base['success_y'];
        $base['count'] = $orders_count->count();

        foreach ($orders as $key => $value) {
            $pros = json_decode($value->products);
            foreach ($pros as $k => $val) {
                $orders[$key]['pro_text'] .= '['.$val->product->name.'×'.$val->total_num.']';
            }
        }
        return view('admin.order', compact('orders', 'mall_id', 'base', 'base', 'state'));
    }

    //切换某商超是否开始接单
    public function trigger(Request $request, $id)
    {
        $mall = Mall::find($id)->update(['is_show' => $request->state]);
        if ($mall) {
            return back()->with('success', '改变接单状态成功');
        } else {
            return back()->with('success', '改变接单状态失败！！！！');
        }
    }
}
