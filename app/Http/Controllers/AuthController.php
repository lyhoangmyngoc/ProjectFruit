<?php

namespace App\Http\Controllers;

use App\Models\LoginModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller {
    
    public function login_auth() {
        return view('admin.login');
    }
    public function login(Request $request) {

        $email = $request->admin_email;
        $password = md5($request->admin_password);
        $result = LoginModel::where('admin_user', $email)->where('admin_password', $password)->first();
        if ($result) {
            Session::put('admin_id', $result->admin_id);
            Session::put('admin_user', $result->admin_user);
            Session::put('admin_name', $result->admin_name);
            return redirect('/admin');
        } else {
            Session::put('message', 'Tên đăng nhập hoặc mật khẩu không chính xác!<br> Vui lòng kiểm tra lại!');
            return redirect('/admin/dang-nhap');
        }
    }

    public function logout() {
        
        Auth::logout();
        return redirect('/admin/dang-nhap');
    }
}
