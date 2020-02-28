<?php

namespace App\Http\Controllers;

use App\Address;
use App\Cart;
use App\Mall;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->paginate(10);
        foreach ($orders as $key => $value) {
            $products = json_decode($value->products);
            foreach ($products as $k => $val) {
                $orders[$key]['pro_text'] .= '['.$val->product->name.'×'.$val->total_num.']';
            }
        }
        return view('home.order.index', compact('orders'));
    }

    //选购界面
    public function create($mall_id)
    {
        $mall = Mall::find($mall_id);
        $address = Address::where('user_id', Auth::id())->first();
        if (is_null($address)) {
            return redirect(route('address.index'))->with('success', '请先添加姓名和电话再订菜');
        }

        //商品
        $products = Product::where('is_show', 1)->where('mall_id', $mall_id)->get();
        return view('home.order.create', compact('products', 'mall'));
    }

    //提交订单
    public function store(Request $request)
    {
        $mall_id = $request->input('mall_id');
        $is_show = Mall::find($mall_id)->is_show;
        if (!$is_show) {
            return back()->with('success', '系统已经关闭,订单提交失败!!!');
        }
        $carts = Cart::where('user_id', Auth::id())->where('mall_id', $mall_id)->get();
        if ($carts->count() == 0) {
            return back()->with('success', '购物车为空,订单提交失败!!!');
        }

        //购物车总金额
        try {
            $total_price = 0;
            foreach ($carts as $key => $value) {
                $total_price += $value->product->money * $value->total_num;
            }
        } catch (\Exception $exception) {
            return back()->with('success', '您的购物车中有失效的商品,请删除后重新提交订单!!!');
        }

        $address = Address::where('user_id', Auth::id())->first();
        $data['user_id'] = Auth::id();
        $data['name'] = $address->name;
        $data['tel'] = $address->tel;
        $data['products'] = json_encode($carts->toArray());
        $data['total_money'] = $total_price;
        $data['total_num'] = array_sum($carts->pluck('total_num')->toArray());
        $data['mall_id'] = $mall_id;
        try {
            $order = DB::transaction(function () use ($data, $mall_id, $carts) {
                //创建订单
                $order = Order::create($data);
                //减商品对应的库存
                foreach ($carts as $cart) {
                    $product = Product::lockForUpdate()->find($cart->product_id);
                    //如果库存为负数则抛出异常
                    if ($product->stock - $cart->total_mum < 0) {
                        throw new \Exception('当前商品'.$product->name.'库存不足，提交订单失败!');
                    }
                    $product->decrement('stock', $cart->total_num);
                }
                //清空购物车
                Cart::where('user_id', Auth::id())->where('mall_id', $mall_id)->delete();
                return $order;
            }, 5);
        } catch (\Exception $exception) {
            return back()->with('success', '提交订单失败!!!!!'.$exception->getMessage());
        }
        return redirect(route('order.show', $order->id))->with('pay_success', '提交订单成功');
    }

    //显示订单
    public function show($id)
    {
        $order = Order::with('mall')->where('user_id', Auth::id())->where('id', $id)->first();
        $products = json_decode($order->products);
        $pro_text = null;
        foreach ($products as $key => $value) {
            $pro_text .= '['.$value->product->name.'×'.$value->total_num.']';
        }
        return view('home.order.show', compact('order', 'pro_text'));
    }

    //确认收货
    public function success(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->where('id', $id)->first();
        if (is_null($order->pay_time)) {
            return back()->with('success', '确认收货失败！此订单未付款。如果您已经付款，请联系商家确认收款！');
        }
        $update = $order->update(['is_success' => 1]);
        if ($update) {
            return back()->with('success', '确认收货成功!');
        } else {
            return back()->with('success', '确认收货失败!!!!!');
        }
    }

    //删除订单
    public function destroy(Request $request, $id)
    {
        //判断是否从后台发起删除请求
        $is_admin = $request->input('is_admin');
        $order = Order::find($id);
        if (is_null($order)) {
            return back()->with('success', '订单不存在,可能已经被删除了!!!!');
        }
        if (is_null($order->pay_time) && $order->is_success === 0) {
            $del = Order::destroy($id);
            if ($del) {
                if ($is_admin) {
                    return back()->with('success', '订单删除成功!');
                }
                return redirect(route('order.index'))->with('success', '订单删除成功!');
            } else {
                return back()->with('success', '订单删除失败!!!!!');
            }
        } else {
            return back()->with('success', '订单已经支付或者已经收货，无法删除！！！');
        }
    }

    //导出订单
    public function export_order(Request $request, $id)
    {
        $mall_id = $id;

        $c_time = array();
        if ($request->input('created_at') != '') {
            $c_date = str_replace(' ', '', $request->input('created_at'));
            $start_c_date = explode('~', $c_date)[0];
            $end_c_date = explode('~', $c_date)[1];
            $c_time = function ($query) use ($start_c_date, $end_c_date) {
                $query->whereDate('created_at', '>=', $start_c_date)->whereDate('created_at', '<=', $end_c_date);
            };
        }
        $p_time = array();
        if ($request->input('pay_date') != '') {
            $p_date = str_replace(' ', '', $request->input('pay_date'));
            $start_p_date = explode('~', $p_date)[0];
            $end_p_date = explode('~', $p_date)[1];
            $p_time = function ($query) use ($start_p_date, $end_p_date) {
                $query->whereDate('pay_time', '>=', $start_p_date)->whereDate('pay_time', '<=', $end_p_date);
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
        $orders = Order::with('mall')->where('mall_id', $mall_id)
            ->where($c_time)
            ->where($p_time)
            ->where($p_state)
            ->where($success)
            ->get();

        foreach ($orders as $key => $value) {
            $pros = json_decode($value->products);
            foreach ($pros as $k => $val) {
                $orders[$key]['pro_text'] .= '['.$val->product->name.'×'.$val->total_num.']';
                $orders[$key]['mall_name'] = $value->mall->name;
            }
            unset ($value['mall'], $value['products'], $value['user_id'], $value['deleted_at'], $value['updated_at'], $value['mall_id']);
        }
        return Excel::download(new OrderExport($orders->toArray()), 'order_'.time().'.xlsx');
    }
}
