<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    public function index()
    {
        $data = Config::orderBy('conf_order','asc')->get();
        foreach ($data as $k=>$v){
            switch ($v->field_type) {
                // conf_content[] 如果不定义成数组，将只体现最后一个数据
                case 'input':
                    $data[$k]->html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->html = '<textarea type="text" class="lg"  name="conf_content[]" >'.$v->conf_content.'</textarea>';

                    break;
                case 'radio':
                    // 1|开启,0|关闭,用，拆分
                    $arr = explode(',',$v->field_value);
                    $str = '';
                    foreach ($arr as $m=>$n){
                        //1|开启
                        $a = explode('|',$n);
                        $c = $v->conf_content==$a[0]?' checked ':'';
                        $str .= '<input type="radio" name="conf_content[]" value="'.$a[0].'"'.$c.'>'.$a[1].'　';
                    }
                    $data[$k]->html = $str;
                    break;
            }
        }

        return view('admin.config.index', compact('data'));
    }

    public function changeOrder()
    {
        $input = Input::all();   // 获取异步传人的值
        $config = Config::find($input['conf_id']);  // 通过config的model 查找对应id的值
        $config->conf_order = $input['conf_order']; // 将输入的值赋值给数据库的cate_order
        $re = $config->update();
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

    //get.admin/config/{config}   显示单个导航
    public function show(){

    }

    //get.admin/config/create   创建导航
    public function create(){
        return view('admin/config/add');  // 通过compact传输数据到view
    }

    public function store(){
        $input = Input::except('_token');   // 除_token之外的字段
        $rules =[               // 验证规则
            'conf_name'=>'required',
            'conf_title'=>'required',
        ];

        $message = [
            'conf_name.required'=>'配置项名称不能为空',
            'conf_title.required'=>'配置项标题不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);   // 验证器

        if ($validator->passes()){
            $re = Config::create($input);    //  插入数据
            if($re){
                return redirect('admin/config');
            }else{
                return back()->with('errors','数据存储失败，请稍后再试！');
            }
        }else{
            return back()->withErrors($validator);
        }

    }

    //put.admin/config/{config}   更新配置项
    public function update($conf_id){
        $input =Input::except('_token','_method');
        $re = Config::where('conf_id',$conf_id)->update($input);
        if ($re){
            $this->putFile(); // 将内容写入web配置文件
            return redirect('admin/config');
        }else{
            return back()->with('errors','数据更新失败，请稍后再试！');
        }
    }

    //get.admin/config/{config}/edit   编辑导航
    public function edit($conf_id){
        $field = Config::find($conf_id);
        return view('admin.config.edit',compact('field'));
    }

    //delete.admin/config/{config}  删除单个导航
    public function destroy($conf_id){
        $re = Config::where('conf_id',$conf_id)->delete();
        if($re){
            $this->putFile(); // 将内容写入web配置文件
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
    // admin/config/changecontent  首页更新配置项
    public function changeContent()
    {
        $input = Input::all();
        // 传过来两组数组，conf_id和conf_content.进行分别匹配来完成数据更新
        foreach ($input['conf_id'] as $k=>$v){
            Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile(); // 将内容写入web配置文件
        return back()->with('errors','配置项更新成功！');
    }

    public function putFile()
    {
        // 如果不使用all()方法得出的数组不是纯净的数组
        $config=Config::pluck('conf_content','conf_name')->all();
//        dd($config);
        $path = base_path().'\config\web.php';
        //  var_export($config,true); 将数组转为字符串
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);
//        echo \Illuminate\Support\Facades\Config::get('web.web_status');  读取web配置文件中的web_status配置项
    }
}
