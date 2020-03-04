<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Mall;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminController extends Controller
{
    //管理首页
    public function index()
    {
        $malls = Mall::all();
        return view('admin.index', compact('malls'));
    }

    //添加商品
    public function create($mall_id)
    {
        $mall = Mall::find($mall_id);
        return view('admin.create', compact('mall'));
    }

    //添加商品
    public function store(Request $request)
    {
        $mall_id = $request->input('mall_id');

        $data = $request->all();
        $create = Product::create($data);
        if ($create) {
            return redirect(route('admin.product', $mall_id))->with('success', '添加成功');
        } else {
            return back()->with('success', '添加失败!!');
        }

    }

    //编辑商品
    public function edit($mall_id, $id)
    {
        $mall = Mall::find($mall_id);
        $product = Product::find($id);
        return view('admin.edit', compact('product', 'mall'));
    }

    //更新商品
    public function update(Request $request, $id)
    {
        $mall_id = $request->input('mall_id');
        $product = Product::whereId($id)->update($request->except('_token', '_method'));
        if ($product) {
            return redirect(route('admin.product', $mall_id))->with('success', '更新成功');
        } else {
            return back()->with('success', '更新失败!！！!');
        }
    }

    //删除商品
    public function destroy(Request $request, $id)
    {
        $mall_id = $request->input('mall_id');
        $product = Product::destroy($id);
        //删除商品的时候 删除用户购物车中的对应商品
        Cart::where('product_id', $id)->delete();
        if ($product) {
            return redirect(route('admin.product', $mall_id))->with('success', '删除成功');
        } else {
            return back()->with('success', '删除失败！！！！');
        }

    }

    //确认收款
    public function pay(Request $request)
    {
        $id = $request->input('id');
        $pay = Order::find($id)->update(['pay_time' => now()->toDateTimeString()]);
        if ($pay) {
            return $info = ['state' => 1, 'msg' => '收款成功,表格下方的汇总信息需要刷新页面才会变更,请注意!'];
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
            return $info = ['state' => 1, 'msg' => '取消成功,表格下方的汇总信息需要刷新页面才会变更,请注意!'];
        } else {
            return $info = ['state' => 0, 'msg' => '取消失败'];
        }
    }

    //商品管理
    public function product($mall_id)
    {
        $mall = Mall::find($mall_id);
        $products = Product::where('is_show', 1)->where('mall_id', $mall_id)->get();
        return view('admin.product', compact('products', 'mall_id', 'mall'));
    }


    //订单管理
    public function order(Request $request, $mall_id)
    {
        $mall = Mall::find($mall_id);
        $s_id = array();
        if ($request->input('s_id') != '') {
            $s_id = function ($query) use ($request) {
                $query->where('id',$request->input('s_id'));
            };
        }
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
        $orders = Order::with('mall')
            ->where('mall_id', $mall_id)
            ->where($c_time)
            ->where($p_time)
            ->where($p_state)
            ->where($success)
            ->where($s_id)
            ->paginate(10);

        //汇总信息
        $orders_count = Order::with('mall', 'user')->where('mall_id', $mall_id)
            ->where($c_time)
            ->where($p_time)
            ->where($p_state)
            ->where($success)
            ->where($s_id)
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

        return view('admin.order', compact('orders', 'mall', 'base'));
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

    //对商超的数据报表
    public function total_order(Request $request, $mall_id)
    {
        $mall_name = Mall::find($mall_id)->name;
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        if (strtotime($end_date) - strtotime($start_date) < 0) {
            return back()->with('success', '结束日期不能小于开始日期，请重新查询！');
        }

        if (is_null($start_date) || is_null($end_date)) {
            $today = date_format(now(), 'Y-m-d');
            $start_date = $today;
            $end_date = $today;
        }

        $orders = Order::where('mall_id', $mall_id)->whereNotNull('pay_time')->whereDate('pay_time', '>=',
            $start_date)->whereDate('pay_time', '<=', $end_date)->get();

        //将序列化的商品取出来
        $products_arr = array();
        foreach ($orders as $key => $value) {
            $products_arr[] = json_decode($value->products, true);
        }
        unset($key, $value);

        //将所有商品信息重装数组
        $new_products_arr = array();
        foreach ($products_arr as $key => $value) {
            foreach ($value as $k => $v) {
                $new_products_arr[] = $v;
            }
        }
        unset($key, $value, $k, $v);

        //组装商品id和数量的数组
        $products = array();
        foreach ($new_products_arr as $key => $value) {
            $products[$key]['product_id'] = $value['product']['id'];
            $products[$key]['product_name'] = $value['product']['name'];
            $products[$key]['product_price'] = $value['product']['money'];
            $products[$key]['product_num'] = $value['total_num'];
        }
        unset($key, $value);

        //相同的ID合并 汇总数量
        $final_products = array();
        //商品id 去重复
        $product_ids = array_unique(array_column($products, 'product_id'));
        foreach ($product_ids as $key => $value) {
            $num = 0;
            $name = '';
            $price = '';
            foreach ($products as $k => $v) {
                if ($value == $v['product_id']) {
                    $num += $v['product_num'];
                    $name = $v['product_name'];
                    $price = $v['product_price'];
                }
            }
            $final_products[$key]['product_id'] = $value;
            $final_products[$key]['product_name'] = $name;
            $final_products[$key]['product_price'] = $price;
            $final_products[$key]['product_num'] = $num;
        }
        unset($key, $value, $k, $v);

        $products_total_money = 0;
        $products_total_num = array_sum(array_column($final_products, 'product_num'));
        foreach ($final_products as $key => $value) {
            $products_total_money += $value['product_num'] * $value['product_price'];
        }

        return view('admin.total_order',
            compact('mall_id', 'mall_name', 'final_products', 'products_total_money', 'products_total_num'));
    }

    //购买排行
    public function buytop(Request $request)
    {
        $perPage = 10;
        $page = $request->input("page", 1) - 1;
        $count = User::all()->count();

        $users = User::all()->sortByDesc('total_money')->values()->skip($page * $perPage)->take($perPage);
        $users = new LengthAwarePaginator($users, $count, $perPage);
        $users->withPath("buytop");
        return view('admin.buytop', compact('users'));
    }

    public function findpassword(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('admin.findpassword');
        }
        if ($request->method() == 'POST') {
            $password = $request->input('password');
            dump(bcrypt($password));
        }
    }
}
