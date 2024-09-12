<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\CustomerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UserController extends Controller {

    public function AuthLogin() { //Kiểm tra đăng nhập Admin

        $customer_id = Auth::id();
    }

    public function index() {

        $this->AuthLogin(); //Gọi hàm kiểm tra đăng nhập Admin

        $customer = CustomerModel::orderby('customer_id', 'desc')->get();
        return view('admin.users.list_user')->with(compact('customer'));
    }

    public function add_user() {

        $this->AuthLogin(); //Gọi hàm kiểm tra đăng nhập Admin

        return view('admin.users.add_user');
    }

    
    public function store_users(Request $request) {

        
        $customer = new CustomerModel();
        $customer->customer_name = $request->customer_name;
        $customer->customer_phone = $request->customer_phone;
        $customer->customer_email = $request->customer_email;
        $customer->customer_password = md5($request->customer_password); // Mã hóa mật khẩu
        $customer->save();
        Session::put('message', 'Thêm người dùng thành công!');
        return redirect('/admin/nguoi-dung');
    }

    public function edit_users($customer_id) {
        $customer = CustomerModel::find($customer_id);
        return view('admin.users.edit_user')->with(['customer'=> $customer]);
    }
    public function update_users(Request $request, $customer_id) {
        $customer = CustomerModel::find($customer_id);
        $customer->customer_name = $request->customer_name;
        $customer->customer_phone = $request->customer_phone;
        $customer->customer_email = $request->customer_email;
        $customer->customer_password = md5($request->customer_password); // Mã hóa mật khẩu
        $customer->save();

        Session::put('message', 'Cập nhật người dùng thành công!');
        return redirect('/admin/nguoi-dung');
    }
  

    public function delete_user($customer_id) {

        $this->AuthLogin(); //Gọi hàm kiểm tra đăng nhập

        $customer = CustomerModel::find($customer_id);
        if($customer) {
            $customer->delete();
        }
        return redirect()->back()->with('message', 'Đã xóa người dùng!');
    }
}
