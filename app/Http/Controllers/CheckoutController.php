<?php

namespace App\Http\Controllers;

use App\Models\CategoriesModel;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
session_start();
class CheckoutController extends Controller
{
    //
    public function AuthLogin() { //Kiểm tra đăng nhập
        
        $customer_id = Session::get('customer_id');
        if($customer_id) {
            return redirect('/');
        } else {
            return redirect('/dang-nhap')->send();
        }
    }

    
    public function login_checkout() {
        return view('checkout.logincheckout');
    }
    public function logout_checkout() {

        Session::flush();
        return redirect('/dang-nhap');
    }
    public function register() {
        return view('checkout.register');
    }
    public function login_customer(Request $request) {
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = CustomerModel::where('customer_email', $email)->where('customer_password', $password)->first();
        if ($result) {
            Session::put('customer_id', $result->customer_id);
            Session::put('customer_email', $result->customer_email);
            Session::put('customer_phone', $result->customer_phone);
            return redirect('/');
        } else {
            Session::put('message', 'Tên đăng nhập hoặc mật khẩu không chính xác!<br> Vui lòng kiểm tra lại!');
            return redirect('/dang-nhap');
        }

    }

    public function add_customer(Request $request) {


        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);

        $customer_id = CustomerModel::insertGetId($data);
        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);

        return redirect('/dang-nhap');
    }

    public function checkout(Request $request) {

        $this->AuthLogin(); //Gọi hàm kiểm tra đăng nhập

        // SEO
        $meta_desc = "Đơn vị chuyên phân phối sỉ và lẻ trái cây miền Tây với chất lượng và giá cả tốt nhất thị trường";
        $meta_keywords = "trai cay phan thiet, trái cây Phan Thiết, trái cây, fruit";
        $meta_title = "Thanh toán giỏ hàng - Fruit";
        $url_canonical = $request->url();

        // END SEO
        $category_product = CategoriesModel::where('category_status', '1')->orderBy('category_name', 'asc')->get();

        return view('checkout.show_checkout')->with(compact('category_product',
        'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical'));
    }

}
