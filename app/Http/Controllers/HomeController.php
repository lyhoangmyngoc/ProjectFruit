<?php

namespace App\Http\Controllers;

use App\Models\CategoriesModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request) {

        // SEO
        $meta_keywords = "trai cay phan thiet, trái cây phan thiết, trái cây";
        $meta_title = "PT Fruit - Trái cây Phan Thiết kính chào quý khách";
        $meta_desc = "Đơn vị chuyên phân phối sỉ và lẻ trái cây Phan Thiết với chất lượng và giá cả tốt nhất thị trường";
        $url_canonical = $request->url();
        // END SEO
        
        $category_product = CategoriesModel::where('category_status', 1)->orderBy('category_name', 'asc')->get();
        $list_product = ProductModel::where('product_status', 1)->orderBy('product_id', 'desc')->get();
        $product_viet = ProductModel::where('product_status', 1)->where('category_id', 30)->orderBy('product_id', 'desc')->get();
        $product_minhphuong = ProductModel::where('product_status', 1)->where('category_id', 27)->orderBy('product_id', 'desc')->get();
        $product_gio = ProductModel::where('product_status', 1)->where('category_id', 23)->orderBy('product_id', 'desc')->get();
        $product_hop = ProductModel::where('product_status', 1)->where('category_id', 24)->orderBy('product_id', 'desc')->get();
        $product_chuoi = ProductModel::where('product_status', 1)->where('category_id', 25)->orderBy('product_id', 'desc')->get();

        return view('home')->with(compact('meta_keywords', 'meta_title', 'meta_desc', 'url_canonical', 'list_product', 'category_product', 'product_viet', 'product_minhphuong', 'product_gio', 'product_hop', 'product_chuoi'));
    }

    

}
