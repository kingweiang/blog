<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;


class CommonController extends Controller
{
    public function upload()
    {

         $file = Input::file('Filedata');  // 获取文件内容必须使用fiel方法，读取数据用get方法

        if ($file->isValid()){   // 判断文件是否有效
            $realPath=$file->getRealPath();   // 获取临时文件的绝对路径
            $entension = $file->getClientOriginalExtension();  // 上传文件的后缀名
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;  // 定义新文件名为日期时间+ 3位随机数+ 后缀名
            $path=$file->move('uploads',$newName); // 移动到根目录的uploads并重命名
//            $bool = Storage::disk(base_path(),'/uploads')->put($newName, file_get_contents($realPath));
            $filepath = 'uploads/'.$newName;  // 定义新文件的存储路径
            return $filepath;
        }
    }
}
