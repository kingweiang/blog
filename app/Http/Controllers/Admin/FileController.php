<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{
//    public function upload(Request $request)
//    {
////        if ($request->isMethod('post'))
//
//
//            $file = Input::file('picture');
//        // 文件是否上传成功
//        if ($file->isValid()){
//            // 获取文件相关信息
//            $originalName = $file->getClientOriginalName(); // 文件原名
//            $ext = $file->getClientOriginalExtension();     // 扩展名
//            $realPath = $file->getRealPath();   //临时文件的绝对路径
//            $type = $file->getClientMimeType();     // image/jpeg
//            // 上传文件
//            $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
//            // 使用我们新建的uploads本地存储空间（目录）
//            $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
//            var_dump($bool);}
//        return view('admin.uploada');
//    }

    public function file(){
        return view('admin.file_pro');

    }

    public function file_pro()
    {
        // 接收文件信息 进行上传
        $file = Input::file('myfile');
//        dd($file);
// 检验一下上传的文件是否有效.
        if($file->isValid()){
//            dd($file);
// 缓存在tmp文件夹中的文件名 例如 php8933.tmp 这种类型的.
            $clientName = $file -> getClientOriginalName();
            $tmpName = $file ->getFileName();
// 这个表示的是缓存在tmp文件夹下的文件的绝对路径(这里要注意,如果我使用接下来的move方法之后, getRealPath() 就找不到文件的路径了.因为文件已经被移走了.所以这里道出了文件上传的原理,将文件上传的某个临时目录中,然后使用Php的函数将文件移动到指定的文件夹.)
            $realPath = $file -> getRealPath();
// 上传文件的后缀.
            $entension = $file -> getClientOriginalExtension();
// 大家对mimeType应该不陌生了. 我得到的结果是 image/jpeg.(这里要注意一点,以前我们使用 mime_content_type() ,在php5.3 之后,开始使用 fileinfo 来获取文件的mime类型.所以要加入 php_fileinfo的php拓展.windows下是 php_fileinfo.dll,在php.ini文件中将 extension=php_fileinfo.dll前面的分号去掉即可.当然要重启服务器. )
//            $mimeTye = $file -> getMimeType();
// (第一种)最后我们使用
//            $path = $file -> move('uploads');
            dd($file);
// 如果你这样写的话,默认是会放置在 我们 public/storage/uploads/php79DB.tmp
// 貌似不是我们希望的,如果我们希望将其放置在app的storage目录下的uploads目录中,并且需要改名的话..
//(第二种)
// $newName = md5(date("Y-m-d H:i:s").$clientName).".".$entension;
// $path = $file -> move(app_path().'/storage/uploads',$newName);
// 这里app_path()就是app文件夹所在的路径.$newName 可以是你通过某种算法获得的文件的名称.主要是不能重复产生冲突即可. 比如 $newName = md5(date("Y-m-d H:i:s").$clientName).".".$entension;
// 利用日期和客户端文件名结合 使用md5 算法加密得到结果.不要忘记在后面加上文件原始的拓展名.
// 将$path入库

//            if(Db::table('file')->insert(['file_path'=>$path])){
//                return Redirect::to('admin/file_list');
//            }

        }

    }
}
