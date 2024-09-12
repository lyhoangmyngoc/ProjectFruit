<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model {
    
    public $timestamps = false; //set time to false
    protected $fillable = [
        'category_id', 'product_name', 'product_quantity', 'product_sold', 'product_desc', 'product_content',
        'product_keywords', 'product_image', 'product_origin', 'product_unit', 'product_status'
    ];
    protected $primaryKey = 'product_id';
    protected $table = 'product';

    public function category_product() {
        return $this->belongsTo('App\Models\CategoriesModel', 'category_id');
    }

    public function comment() {
        return $this->hasMany('App\Models\CommentModel');
    }
}
