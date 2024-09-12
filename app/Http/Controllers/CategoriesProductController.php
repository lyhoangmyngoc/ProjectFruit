<?php

namespace App\Http\Controllers;

use App\Models\CategoriesModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
session_start();

class CategoriesProductController extends Controller
{
    public function AuthLogin() { //Kiểm tra đăng nhập Admin

        $admin_id = Auth::id();
        if($admin_id) {
            return redirect('admin');
        } else {
            return redirect('admin/dang-nhap')->send();
        }
    }

    public function add_category_product() {

        $this->AuthLogin(); //Gọi hàm kiểm tra đăng nhập

        return view('admin.category_product.add_category_product');
    }

    public function list_categories_product() {

        $this->AuthLogin();

        $list_categories_product = CategoriesModel::orderBy('category_id', 'desc')->get();
        return view('admin.category_product.list_category_product')->with(compact('list_categories_product'));
    }

    public function save_category_product(Request $request) {

        $this->AuthLogin();

        $data = $request->all();
        $category = new CategoriesModel();
        $category->category_name = $data['category_product_name'];
        $category->meta_keywords = $data['category_product_keywords'];
        $category->category_desc = $data['category_product_desc'];
        $category->category_status = $data['category_product_status'];
        $category->save();

        Session::put('message', 'Thêm danh mục sản phẩm thành công!');
        return redirect('/admin/danh-sach-danh-muc');
    }

    public function unactive_category_product($category_product_id) {

        $this->AuthLogin();

        CategoriesModel::where('category_id', $category_product_id)->update(['category_status'=>1]);
        Session::put('message', 'Đã hiển thị danh mục sản phẩm!');
        return redirect()->back();
    }

    public function active_category_product($category_product_id) {

        $this->AuthLogin();

        CategoriesModel::where('category_id', $category_product_id)->update(['category_status'=>0]);
        Session::put('message', 'Đã ẩn danh mục sản phẩm!');
        return redirect()->back();
    }

    public function edit_category_product($category_product_id) {
        $this->AuthLogin();

        $edit_category_product = CategoriesModel::where('category_id', $category_product_id)->get();
        return view('admin.category_product.edit_category_product')->with(compact('edit_category_product'));
    }

    public function update_category_product(Request $request, $category_product_id) {

        $this->AuthLogin();

        $data = $request->all();
        $category = CategoriesModel::find($category_product_id);
        $category->category_name = $data['category_product_name'];
        $category->meta_keywords = $data['category_product_keywords'];
        $category->category_desc = $data['category_product_desc'];
        $category->updated_at = $data['updated_at'];
        $category->save();

        Session::put('message', 'Cập nhật danh mục sản phẩm thành công!');
        return redirect('/admin/danh-sach-danh-muc');
    }

    public function delete_category_product($category_product_id) {

        $this->AuthLogin();

        $category_product = CategoriesModel::find($category_product_id);
        $category_product->delete();
        Session::put('message', 'Đã xóa danh mục sản phẩm!');
        return redirect()->back();
    }
    
    public function show_category_home(Request $request, $category_id) {

        $category_product = CategoriesModel::where('category_status', '1')->orderBy('category_name', 'desc')->get();
        $category_by_id = ProductModel::with('category_product')->where('product_status', 1)->where('category_id', $category_id)->orderBy('product_id', 'desc')->get();
        $category_name = CategoriesModel::where('category_id', $category_id)->limit(1)->get();
        
        foreach($category_name as $key => $val) {
            // SEO
            $meta_desc = $val->category_desc;
            $meta_keywords = $val->meta_keywords;
            $meta_title = $val->category_name;
            $url_canonical = $request->url();
            // END SEO
        }
        
        return view('categories.show_category')->with(compact('category_product', 'category_by_id', 'category_name', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical'));
    }
}
