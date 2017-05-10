<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class LoginUser extends Model
{
    protected $table ="user";
    protected $primaryKey="user_id";
    public $timestamps = false;
}
