<?php

namespace App\Http\Controllers;

use App\Models\CategoriesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
session_start();

class CartController extends Controller {

    

    public function AuthLogin() { // Kiểm tra đăng nhập

        $customer_id = Session::get('customer_id');
        if($customer_id) {
            return redirect('/');
        } else {
            return redirect('dang-nhap')->send();
        }
    }
    
    public function show_cart_qty() {

        $cart = count(Session::get('cart'));
        $output = '';
        $output.= '<a href="'.url('/gio-hang').'">
                        <img src="'.url('client/img/icon-cart.png').'" alt="Giỏ hàng" width="40">
                        <span class="num-cart">'.$cart.'</span>
                    </a>';
        echo $output;
    }

    public function show_cart(Request $request) {

        $this->AuthLogin(); //Gọi hàm kiểm tra đăng nhập
        $meta_desc = "Giỏ hàng PT Fruit - Thương hiệu trái cây miền Tây số 1 Việt Nam";
        $meta_keywords = "Giỏ hàng PT Fruit";
        $meta_title = "Giỏ hàng PT Fruit - Thương hiệu trái cây miền Tây số 1 Việt Nam";
        $url_canonical = $request->url();
        $category_product = CategoriesModel::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        return view('cart.show_cart')->with(compact('category_product', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical'));
    }
    public function add_to_cart(Request $request) {
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if ($cart==true) {
            $is_available = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_available++;
                    $cart[$key] = array(
                    'session_id' => $val['session_id'],
                    'product_name' => $val['product_name'],
                    'product_id' => $val['product_id'],
                    'product_image' => $val['product_image'],
                    'product_quantity' => $data['cart_product_quantity'],
                    'product_qty' => $val['product_qty']+ $data['cart_product_qty'],
                    'product_price' => $val['product_price'],
                    );
                    Session::put('cart', $cart);
                }
            }
            if ($is_available == 0) {
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_product_id'],
                    'product_image' => $data['cart_product_image'],
                    'product_quantity' => $data['cart_product_quantity'],
                    'product_qty' => $data['cart_product_qty'],
                    'product_price' => $data['cart_product_price'],
                );
                Session::put('cart', $cart);
            }
        } else {
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_quantity' => $data['cart_product_quantity'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
            );
            Session::put('cart', $cart);
        }
        Session::save();
    }
    public function add_to_cart_details(Request $request) {
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if ($cart==true) {
            $is_available = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_available++;
                    $cart[$key] = array(
                    'session_id' => $val['session_id'],
                    'product_name' => $val['product_name'],
                    'product_id' => $val['product_id'],
                    'product_image' => $val['product_image'],
                    'product_quantity' => $data['cart_product_quantity'],
                    'product_qty' => $val['product_qty']+ $data['cart_product_qty'],
                    'product_price' => $val['product_price'],
                    );
                    Session::put('cart', $cart);
                }
            }
            if ($is_available == 0) {
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_product_id'],
                    'product_image' => $data['cart_product_image'],
                    'product_quantity' => $data['cart_product_quantity'],
                    'product_qty' => $data['cart_product_qty'],
                    'product_price' => $data['cart_product_price'],
                );
                Session::put('cart', $cart);
            }
        } else {
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_quantity' => $data['cart_product_quantity'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
            );
            Session::put('cart', $cart);
        }
        Session::save();
    }
    public function del_product($session_id) {

        $this->AuthLogin(); //Gọi hàm kiểm tra đăng nhập

        $cart = Session::get('cart');
        if ($cart == true) {
            foreach ($cart as $key => $val) {
                if ($val['session_id'] == $session_id) {
                    unset($cart[$key]);
                }
            }
            Session::put('cart', $cart);
            return redirect()->back()->with('message', 'Xóa sản phẩm thành công!');
        } else {
            return redirect()->back()->with('message', 'Xóa sản phẩm thất bại!');
        }
    }
    public function update_cart(Request $request) {

        $this->AuthLogin(); //Gọi hàm kiểm tra đăng nhập

        $data = $request->all();
        $cart = Session::get('cart');
        if ($cart == true) {
            foreach ($data['cart_qty'] as $key => $qty) {
                foreach ($cart as $session => $val) {
                    if ($val['session_id'] == $key) {
                        $cart[$session]['product_qty'] = $qty;
                    }
                }
            }
            Session::put('cart', $cart);
            return redirect()->back()->with('message', 'Cập nhật số lượng thành công!');
        } else {
            return redirect()->back()->with('message', 'Cập nhật số lượng thất bại!');
        }
    }

    public function del_all_pro() {

        $this->AuthLogin(); //Gọi hàm kiểm tra đăng nhập

        $cart = Session::get('cart');
        if ($cart == true) {
            Session::forget('cart');
            Session::forget('coupon');
            return redirect()->back()->with('message', 'Xóa giỏ hàng thành công!');
        }
    }
    
}