<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginModel extends Model {

    public $timestamps = false;
    protected $fillable = [
          'admin_user', 'admin_password', 'admin_name'
    ];
 
    protected $primaryKey = 'admin_id';
 	protected $table = 'admin';
}
