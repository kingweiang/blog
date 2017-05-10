<?php

namespace App\Http\Controllers\admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    public function index()
    {
        $data = Links::orderBy('link_order','asc')->get();
        return view('admin.links.index', compact('data'));
    }

    public function changeOrder()
    {
        $input = Input::all();   // 获取异步传人的值
        $links = Links::find($input['link_id']);  // 通过links的model 查找对应id的值
        $links->link_order = $input['link_order']; // 将输入的值赋值给数据库的cate_order
        $re = $links->update();
        //创建信息确认
        if ($re){
            $data =[
                'status' => 0,
                'msg' => '友情链接排序更新成功！',
            ];
        }else{
            $data =[
                'status' => 1,
                'msg' => '友情链接排序更新失败，请稍后重试！',
            ];
        }
        return $data;
    }

    //get.admin/category/{category}   显示单个分类
    public function show(){

    }

    //get.admin/links/create   创建分类
    public function create(){
        return view('admin/links/add');  // 通过compact传输数据到view
    }

    public function store(){
        $input = Input::except('_token');   // 除_token之外的字段
        $rules =[               // 验证规则
            'link_name'=>'required',
            'link_url'=>'required',
        ];

        $message = [
            'link_name.required'=>'链接名称不能为空',
            'link_url.required'=>'URL地址不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);   // 验证器

        if ($validator->passes()){
            $re = Links::create($input);    //  插入数据
            if($re){
                return redirect('admin/links');
            }else{
                return back()->with('errors','数据存储失败，请稍后再试！');
            }
        }else{
            return back()->withErrors($validator);
        }

    }

    //put.admin/links/{category}   更新分类
    public function update($link_id){
        $input =Input::except('_token','_method');
        $re = Links::where('link_id',$link_id)->update($input);
        if ($re){
            return redirect('admin/links');
        }else{
            return back()->with('errors','数据更新失败，请稍后再试！');
        }
    }

    //get.admin/links/{category}/edit   编辑分类
    public function edit($link_id){
        $field = Links::find($link_id);
        return view('admin.links.edit1',compact('field'));
    }

    //delete.admin/category/{category}  删除单个分类
    public function destroy($link_id){
        $re = Links::where('link_id',$link_id)->delete();
        if($re){
            $datas =[
                'status' => 0,
                'msg' => '链接删除成功！',
            ];
        }else{
            $datas =[
                'status' => 1,
                'msg' => '链接删除失败,请稍后重试！',
            ];
        }
        return $datas;
    }

}
