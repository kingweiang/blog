<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use App\Http\Model\LoginUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    public function login(){
        if($input=Input::all()){    // 导入input输入的信息
            $code = new \code;      // 实例化验证码类
            $_code= $code->get();   // 获取当前验证码
            if (strtoupper($input['code'])!=$_code){   //将输入项转为大写，判断输入的与验证码是否一致
                return back()->with('msg','验证码输入错误');
            }
            $user = LoginUser::first();  //调取表中第一条数据
            // 判断用户名是否正确，解密表中密码字段进行比对密码判断
            if($user->user_name != $input['username'] &&  Crypt::decrypt($user->user_pass) != $input['password']){
                return back()->with('msg','用户名或密码错误');
            }
            session(['user'=>$user]);   //  登录信息写入session
//            dd(session('user'));
//            echo '登录成功！';
            return redirect('admin');  //  跳转到index
        }else{
            return view('admin.login');
        }
    }

    public function code(){
        $code = new \code;
        $code->make();
    }

    public function quit(){
        session(['user'=>null]);     // 清除session
        return redirect('admin/login');
    }

    public function crypt(){
        $str = '123456';
        echo Crypt::encrypt($str)."<br/>";
        $str1 = Crypt::encrypt($str);
        echo Crypt::decrypt($str1);
    }
}
