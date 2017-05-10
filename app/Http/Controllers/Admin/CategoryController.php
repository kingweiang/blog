<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class CategoryController extends CommonController
{
    //get.admin/category  显示全部分类
    public function index(){
        $data = (new Category)->tree();    // 动态方法调用
//        $data = Category::tree();      // 静态方法调用
        return view('admin.category.index')->with('data',$data);
    }

    public function changeOrder()
    {
        $input = Input::all();   // 获取异步传人的值
        $cate = Category::find($input['cate_id']);  // 通过category的model 查找对应id的值
        $cate->cate_order = $input['cate_order']; // 将输入的值赋值给数据库的cate_order
        $re = $cate->update();
        //创建信息确认
        if ($re){
            $data =[
                'status' => 0,
                'msg' => '分类排序更新成功！',
            ];
        }else{
            $data =[
                'status' => 1,
                'msg' => '分类排序更新失败，请稍后重试！',
            ];
        }
        return $data;
    }
    //post.admin/category   添加分类提交方法
    public function store(){
        $input = Input::except('_token');   // 除_token之外的字段
        $rules =[               // 验证规则
            'cate_name'=>'required',
        ];

        $message = [
            'cate_name.required'=>'分类名称不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);   // 验证器

        if ($validator->passes()){
            $re = Category::create($input);    //  插入数据
            if($re){
                return redirect('admin/category');
            }else{
                return back()->with('errors','数据存储失败，请稍后再试！');
            }
            }else{
            return back()->withErrors($validator);
        }

    }

    //get.admin/category/create   创建分类
    public function create(){
        $data = Category::where('cate_pid',0)->get();   // 读取pid为0的数据
        return view('admin/category/add',compact('data'));  // 通过compact传输数据到view
    }
    //get.admin/category/{category}   显示单个分类
    public function show(){

    }

    //delete.admin/category/{category}  删除单个分类
    public function destroy($cate_id){
        $re = Category::where('cate_id',$cate_id)->delete();
        Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);  //  如果id等于pid，则升级为顶级分类
        if($re){
            $datas =[
                'status' => 0,
                'msg' => '分类删除成功！',
            ];
        }else{
            $datas =[
                'status' => 1,
                'msg' => '分类删除失败,请稍后重试！',
            ];
        }
        return $datas;
    }
    //put.admin/category/{category}   更新分类
    public function update($cate_id){
        $input =Input::except('_token','_method');
        $re = Category::where('cate_id',$cate_id)->update($input);
        if ($re){
            return redirect('admin/category');
        }else{
            return back()->with('errors','数据更新失败，请稍后再试！');
        }
    }

    //get.admin/category/{category}/edit   编辑分类
    public function edit($cate_id){
        $field=Category::find($cate_id);
        $data = Category::where('cate_pid',0)->get();
        return view('admin.category.edit',compact('field','data'));
    }

}
