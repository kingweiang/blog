<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Navs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        // 点击量最高的5篇文章
        $hot1=Article::orderBy('art_view','desc')->take(5)->get();
        // 最新发布文章8篇
        $news =Article::orderBy('art_time','desc')->take(6)->get();
        $navs = Navs::orderBy('nav_order','asc')->get();
        View::share('navs',$navs);  //  共享变量到所有继承类的视图
        View::share('hot1',$hot1);  //  共享变量到所有继承类的视图
        View::share('news',$news);  //  共享变量到所有继承类的视图
    }
}
