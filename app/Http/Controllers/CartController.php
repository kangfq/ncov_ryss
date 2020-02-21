<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
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
                return back()->with('success', '加入购物车成功！');
            } else {
                return back()->with('success', '加入购物车失败！！！！');
            }
        } else {
            //直接创建新的数据
            $create = Cart::create($data);
            if ($create) {
                return back()->with('success', '加入购物车成功！');
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
