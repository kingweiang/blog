<?php

namespace App\Http\Controllers\Home;


use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;

class IndexController extends CommonController
{
    public function index()
    {
        // 点击量最高的6篇文章
        $hot=Article::orderBy('art_view','desc')->take(6)->get();

        // 图文列表
        $data =Article::orderBy('art_time','desc')->paginate(5);

        // 友情链接
        $links = Links::orderBy('link_order','asc')->get();
        // 网站配置项

        return view('home.index',compact('hot','data','news','links','hot1'));
    }

    public function listPage($cate_id)
    {
        // 图文列表4篇，带分页
        $data =Article::where('cate_id',$cate_id)->orderBy('art_time','desc')->paginate(4);

        // 当前分类的子分类
        $submenu= Category::where('cate_pid',$cate_id)->get();

        $field = Category::find($cate_id);
        return view('home.list',compact('field','data','submenu'));
    }

    public function newsPage($art_id)
    {
        $field=Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();
//        dd($field);
        $article['pre']=Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $article['next']=Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
//        dd($article);
        $data = Article::where('cate_id',$field->cate_id)->orderBy('art_id','desc')->take(6)->get();
        return view('home.news',compact('field','article','data'));
    }
}
