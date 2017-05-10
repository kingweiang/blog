<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends Controller
{
    public function index()
    {
        $data = Navs::orderBy('nav_order','asc')->get();
        return view('admin.navs.index', compact('data'));
    }

    public function changeOrder()
    {
        $input = Input::all();   // 获取异步传人的值
        $navs = Navs::find($input['nav_id']);  // 通过navs的model 查找对应id的值
        $navs->nav_order = $input['nav_order']; // 将输入的值赋值给数据库的cate_order
        $re = $navs->update();
        //创建信息确认
        if ($re){
            $data =[
                'status' => 0,
                'msg' => '自定义导航排序更新成功！',
            ];
        }else{
            $data =[
                'status' => 1,
                'msg' => '自定义导航排序更新失败，请稍后重试！',
            ];
        }
        return $data;
    }

    //get.admin/navs/{navs}   显示单个分类
    public function show(){

    }

    //get.admin/navs/create   创建分类
    public function create(){
        return view('admin/navs/add');  // 通过compact传输数据到view
    }

    public function store(){
        $input = Input::except('_token');   // 除_token之外的字段
        $rules =[               // 验证规则
            'nav_name'=>'required',
            'nav_url'=>'required',
        ];

        $message = [
            'nav_name.required'=>'导航名称不能为空',
            'nav_url.required'=>'URL地址不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);   // 验证器

        if ($validator->passes()){
            $re = Navs::create($input);    //  插入数据
            if($re){
                return redirect('admin/navs');
            }else{
                return back()->with('errors','数据存储失败，请稍后再试！');
            }
        }else{
            return back()->withErrors($validator);
        }

    }

    //put.admin/navs/{navs}   更新分类
    public function update($nav_id){
        $input =Input::except('_token','_method');
        $re = Navs::where('nav_id',$nav_id)->update($input);
        if ($re){
            return redirect('admin/navs');
        }else{
            return back()->with('errors','数据更新失败，请稍后再试！');
        }
    }

    //get.admin/navs/{navs}/edit   编辑分类
    public function edit($nav_id){
        $field = Navs::find($nav_id);
        return view('admin.navs.edit1',compact('field'));
    }

    //delete.admin/navs/{navs}  删除单个分类
    public function destroy($nav_id){
        $re = Navs::where('nav_id',$nav_id)->delete();
        if($re){
            $datas =[
                'status' => 0,
                'msg' => '导航删除成功！',
            ];
        }else{
            $datas =[
                'status' => 1,
                'msg' => '导航删除失败,请稍后重试！',
            ];
        }
        return $datas;
    }
}
