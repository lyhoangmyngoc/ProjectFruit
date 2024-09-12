<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesModel extends Model {
    public $timestamps = true; //set time to false
    protected $fillable = [
        'category_name', 'meta_keywords', 'category_desc', 'category_status'
    ];
    protected $primaryKey = 'category_id';
    protected $table = 'categories_product';
    public function product() {
        return $this->hasMany('App\Models\ProductModel');
    }
}
