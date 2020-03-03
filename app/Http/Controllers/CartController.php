<?php

namespace App\Http\Controllers;

use App\Aged;
use App\Cart;
use App\Mall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index($mall_id)
    {
        $ageds=Aged::all();
        $mall = Mall::find($mall_id);
        //购物车数量
        $carts = Cart::with('product')->where('user_id', Auth::id())->where('mall_id', $mall_id)->get();
        //购物车总金额
        $total_price = 0;
        foreach ($carts as $key => $value) {
            if (is_null($value->product)) {
                $total_price += 0;
            } else {
                $total_price += $value->product->money * $value->total_num;
            }
        }

        return view('home.cart.index', compact('mall', 'carts', 'total_price','ageds'));
    }

    public function store(Request $request)
    {
        $data['product_id'] = $request->input('product_id');
        $data['total_num'] = $request->input('num');
        $data['user_id'] = Auth::id();
        $data['mall_id'] = $request->input('mall_id');

        //看购物车是否有此商品
        $carts = Cart::where('user_id', Auth::id())->where('product_id', $data['product_id'])->first();
        if ($carts) {
            //改变之前商品的数量即可
            $num = $carts->total_num + $data['total_num'];
            $update = Cart::where('user_id', Auth::id())->where('product_id',
                $data['product_id'])->update(['total_num' => $num]);
            if ($update) {
                return redirect(route('cart.index', $data['mall_id']))->with('success', '加入购物车成功！');
            } else {
                return back()->with('success', '加入购物车失败！！！！');
            }
        } else {
            //直接创建新的数据
            $create = Cart::create($data);
            if ($create) {
                return redirect(route('cart.index', $data['mall_id']))->with('success', '加入购物车成功！');
            } else {
                return back()->with('success', '加入购物车失败！！！！');
            }
        }
    }

    public function destroy($id)
    {
        $del = Cart::destroy($id);
        if ($del) {
            return back()->with('success', '删除商品成功');
        } else {
            return back()->with('success', '删除商品失败!!!!!!!');
        }

    }

}
