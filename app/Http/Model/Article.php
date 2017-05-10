<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table ="article";
    protected $primaryKey="art_id";
    public $timestamps = false;  // 创建时间及更新时间为false
    protected $guarded=[];    //  排除不需要填充的字段,否则报MassAssignmentException in Model.php line 444
}
