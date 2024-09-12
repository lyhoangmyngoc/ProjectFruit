<?php

namespace App\Http\Controllers;

use App\Models\GalleryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
session_start();

class GalleryController extends Controller {

    public function AuthLogin() { //Kiểm tra đăng nhập Admin

        $admin_id = Auth::id();
        
    }

    public function add_gallery($product_id) {

        $this->AuthLogin(); //Gọi hàm kiểm tra đăng nhập Admin

        $pro_id = $product_id;
        return view('admin.gallery.add_gallery')->with(compact('pro_id'));
    }

    public function insert_gallery(Request $request, $pro_id) {

        $this->AuthLogin(); //Gọi hàm kiểm tra đăng nhập Admin

        $get_image = $request->file('file');
        if($get_image) {
            foreach($get_image as $image) {
                $get_name_image = $image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image.rand(0,99).'.'.$image->getClientOriginalExtension();
                $image->move('uploads/gallery', $new_image);
                $data['product_image'] = $new_image;
                $gallery = new GalleryModel();
                $gallery->gallery_name = $new_image;
                $gallery->gallery_image = $new_image;
                $gallery->product_id = $pro_id;
                $gallery->save();
            }
        }
        
        Session::put('message', 'Thêm thư viện ảnh sản phẩm thành công!');
        return redirect()->back();
    }
    public function update_gallery_name(Request $request) {

        $this->AuthLogin(); //Gọi hàm kiểm tra đăng nhập Admin

        $gal_id = $request->gal_id;
        $gal_text = $request->gal_text;
        $gallery = GalleryModel::find($gal_id);
        $gallery->gallery_name = $gal_text;
        $gallery->save();
    }

    public function delete_gallery(Request $request) {

        $this->AuthLogin(); //Gọi hàm kiểm tra đăng nhập Admin

        $gal_id = $request->gal_id;
        $gallery = GalleryModel::find($gal_id);
        unlink('uploads/gallery/'.$gallery->gallery_image);
        $gallery->delete();
    }
}
