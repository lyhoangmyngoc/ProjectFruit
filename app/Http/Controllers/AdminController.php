<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\OrderModel;
use Carbon\Carbon;
use Illuminate\support\Facades\Redirect;
session_start();
class AdminController extends Controller
{
    public function AuthLogin() { //Kiểm tra đăng nhập Admin
        $admin_id = Auth::id();
        //chua xet phan quyền được
       
    }
    public function show_dashboard(Request $request) {
        $this->AuthLogin(); //Gọi hàm kiểm tra đăng nhập Admin
      
        //sử dụng Carbon để lấy thời gian hiện tại theo múi giờ 'Asia/Ho_Chi_Minh',
        $early_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $end_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $early_this_month = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $one_year = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        
        $product_count = ProductModel::all()->count();
        $customer_count = CustomerModel::count();
        return view('admin.dashboard')->with(compact(
         'product_count', 'customer_count'));
    }
}
