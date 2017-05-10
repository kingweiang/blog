<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\LoginUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Validator;


class IndexController extends CommonController
{
    public function index(){
           return view('admin.index');
    }

    public function info(){
        return view('admin.info');
    }

    public function password(){
        if ($input = Input::all()){
            $rules =[               // 验证规则
                //  不能为空，且必须在6到20之间，验证两次密码是否一致。view页面需要设置为confirmation
                'password'=>'required|between:6,20|confirmed',
            ];
            $message = [
                'password.required'=>'新密码不能为空',
                'password.between'=>'新密码必须在6到20位之间',
                'password.confirmed'=>'输入的两次密码不匹配，请重新输入！',
            ];
            $validator = Validator::make($input,$rules,$message);   // 验证器

            if ($validator->passes()){
                $user = LoginUser::first();                // 获取原数据
                $_pass = Crypt::decrypt($user->user_pass);      // 解密密码进行赋值
                if ($input['password_o']==$_pass){
                    $user->user_pass = Crypt::encrypt($input['password']);   // 更新加密密码
                    $user->update();
                    return back()->with('errors','密码修改成功！');
                }else{
                    return back()->with('errors','原密码错误！');
                }
            }else{
//                dd($validator->errors()->all());   // 查看验证错误信息
                return back()->withErrors($validator);    // 返回页面并传递错误信息
            }
        }else{
            return view('admin.password');
        }
    }
}
