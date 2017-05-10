<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    public function index(){
        $data = Article::orderBy('art_id','desc')->paginate(4);  //  倒序排序让最新发布的文章排在最前面，paginate方法设计分页
        return view('admin.article.index',compact('data'));
    }

    public function create(){
        $data = (new Category)->tree();
        return view('admin/article/add',compact('data'));  // 通过compact传输数据到view
    }

    //post.admin/article   添加分类提交方法
    public function store(){
        $input = Input::except('_token');   // 除_token之外的字段
        $input['art_time'] = time();

        $rules =[               // 验证规则
            'art_title'=>'required',
            'art_content'=>'required',
        ];

        $message = [
            'art_title.required'=>'文章名称不能为空',
            'art_content.required'=>'文章内容不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);   // 验证器

        if ($validator->passes()){
            $re = Article::create($input);    //  插入数据
            if ($re){
                return redirect('admin/article');
            }else{
                return back()->with('errors','数据更新失败，请稍后再试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    //get.admin/article/{article_id}/edit   编辑分类
    public function edit($art_id){
        $data = (new Category)->tree();  // 获取类型的树形目录
        $field= Article::find($art_id);  // 按art_id获取相应数据信息
        return view('admin.article.edit',compact('data','field'));
    }

    //put.admin/article/{art_id}   更新文章
    public function update($art_id){
        $input =Input::except('_token','_method');
        $re = Article::where('art_id',$art_id)->update($input);
        if ($re){
            return redirect('admin/article');
        }else{
            return back()->with('errors','数据更新失败，请稍后再试！');
        }
    }

    //delete.admin/article/{article}  删除单个分类
    public function destroy($art_id){
        $re = Article::where('art_id',$art_id)->delete();
        if($re){
            $datas =[
                'status' => 0,
                'msg' => '文章删除成功！',
            ];
        }else{
            $datas =[
                'status' => 1,
                'msg' => '文章删除失败,请稍后重试！',
            ];
        }
        return $datas;
    }

}
