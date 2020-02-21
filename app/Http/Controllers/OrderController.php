<?php

namespace App\Http\Controllers;

use App\Address;
use App\Cart;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        foreach ($orders as $key => $value) {
            $products = json_decode($value->products);
            foreach ($products as $k => $val) {
                $orders[$key]['pro_text'] .= '['.$val->product->name.'×'.$val->total_num.']';
            }
        }
        return view('home.order.index', compact('orders'));
    }

    public function create()
    {
        $address = Address::where('user_id', Auth::id())->first();
        if (is_null($address)) {
            return redirect(route('address.index'))->with('success', '请先添加姓名和电话再订菜');
        }
        //购物车数量
        $carts = Cart::where('user_id', Auth::id())->get();
        //购物车总金额
        $total_price = 0;
        foreach ($carts as $key => $value) {
            $total_price += $value->product->money * $value->total_num;
        }
        //添加商品
        $products = Product::where('is_show', 1)->get();
        return view('home.order.create', compact('products', 'carts', 'total_price'));
    }

    public function store(Request $request)
    {
        $carts = Cart::where('user_id', Auth::id())->get();

        //购物车总金额
        $total_price = 0;
        foreach ($carts as $key => $value) {
            $total_price += $value->product->money * $value->total_num;
        }

        $address = Address::where('user_id', Auth::id())->first();
        $data['user_id'] = Auth::id();
        $data['name'] = $address->name;
        $data['tel'] = $address->tel;
        $data['products'] = json_encode($carts->toArray());
        $data['total_money'] = $total_price;
        $data['total_num'] = array_sum($carts->pluck('total_num')->toArray());

        $order = Order::create($data);

        if ($order) {
            Cart::where('user_id', Auth::id())->delete();
            return redirect(route('order.show', $order->id))->with('success', '提交订单成功,请联系志愿者进行转账。');
        } else {
            return back()->with('success', '提交订单失败!!!!!');
        }
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())->where('id', $id)->first();
        $products = json_decode($order->products);
        $pro_text = null;
        foreach ($products as $key => $value) {
            $pro_text .= '['.$value->product->name.'×'.$value->total_num.']';
        }
        return view('home.order.show', compact('order', 'pro_text'));
    }

    public function edit()
    {
        return '编辑';
    }

    //确认收货
    public function success(Request $request,$id)
    {
        $order = Order::where('user_id', Auth::id())->where('id', $id)->first();
        if (is_null($order->pay_time)) {
            return back()->with('success', '确认收货失败！！因为没有付钱。如果您已经支付，请联系卖家在后台确认收钱！');
        }
        $update = $order->update(['is_success' => 1]);
        if ($update) {
            return back()->with('success', '确认收货成功!');
        } else {
            return back()->with('success', '确认收货失败!!!!!');
        }
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if (is_null($order->pay_time) && $order->is_success === 0) {
            $del = Order::destroy($id);
            if ($del) {
                return redirect(route('order.index'))->with('success', '订单删除成功!');
            } else {
                return back()->with('success', '订单删除失败!!!!!');
            }
        } else {
            return back()->with('success', '订单已经支付或者已经收货，无法删除！！！');
        }
    }

}
