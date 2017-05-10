@extends('layouts.adminhome')
@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 网站配置
    </div>
    <!--面包屑配置项 结束-->

	{{--<!--结果页快捷搜索框 开始-->--}}
	{{--<div class="search_wrap">--}}
        {{--<form action="" method="post">--}}
            {{--<table class="search_tab">--}}
                {{--<tr>--}}
                    {{--<th width="120">选择分类:</th>--}}
                    {{--<td>--}}
                        {{--<select onchange="javascript:location.href=this.value;">--}}
                            {{--<option value="">全部</option>--}}
                            {{--<option value="http://www.baidu.com">百度</option>--}}
                            {{--<option value="http://www.sina.com">新浪</option>--}}
                        {{--</select>--}}
                    {{--</td>--}}
                    {{--<th width="70">关键字:</th>--}}
                    {{--<td><input type="text" name="keywords" placeholder="关键字"></td>--}}
                    {{--<td><input type="submit" name="sub" value="查询"></td>--}}
                {{--</tr>--}}
            {{--</table>--}}
        {{--</form>--}}
    {{--</div>--}}
    {{--<!--结果页快捷搜索框 结束-->--}}

    <!--搜索结果页面 列表 开始-->
        <div class="result_wrap">
            <div class="result_title">
                <h3>配置项管理</h3>
                @if(count($errors)>0)
                    <div class="mark">
                        @if(is_object($errors))
                            @foreach($errors->all() as $error)
                                <p>{{$error}}</p>
                            @endforeach
                        @else
                            <p>{{$errors}}</p>
                        @endif
                    </div>
                @endif
            </div>
            <!--快捷配置项 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                    <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部配置项</a>
                </div>
            </div>
            <!--快捷配置项 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <form action="{{url('admin/config/changecontent')}}" method="post">

                <table class="list_tab">
                    <tr>
                        <th class="tc"  width="4%">排序</th>
                        <th class="tc"  width="4%">ID</th>
                        <th>配置项标题</th>
                        <th>配置项名称</th>
                        <th>内容</th>
                        <th>操作</th>
                    </tr>
                    {{csrf_field()}}
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$v->conf_id}})" value="{{$v->conf_order}}">  {{--传入input这个对象及conf_id--}}
                        </td>
                        <td class="tc">{{$v->conf_id}}</td>
                        <td>
                            <a href="#">{{$v->conf_title}}</a>
                        </td>
                        <td>{{$v->conf_name}}</td>
                        <td>
                            <input type="hidden" name="conf_id[]" value="{{$v->conf_id}}">
                            {!! $v->html !!}</td>
                        <td>
                            <a href="{{url('admin/config/'.$v->conf_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delLink({{$v->conf_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach

                </table>
                    <div class="btn_group">
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回" >
                    </div>
                </form>

                {{--<div class="page_nav">--}}
                    {{--<div>--}}
                    {{--<a class="first" href="/wysls/index.php/Admin/Tag/index/p/1.html">第一页</a> --}}
                    {{--<a class="prev" href="/wysls/index.php/Admin/Tag/index/p/7.html">上一页</a> --}}
                    {{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/6.html">6</a>--}}
                    {{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/7.html">7</a>--}}
                    {{--<span class="current">8</span>--}}
                    {{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/9.html">9</a>--}}
                    {{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/10.html">10</a> --}}
                    {{--<a class="next" href="/wysls/index.php/Admin/Tag/index/p/9.html">下一页</a> --}}
                    {{--<a class="end" href="/wysls/index.php/Admin/Tag/index/p/11.html">最后一页</a> --}}
                    {{--<span class="rows">11 条记录</span>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="page_list">--}}
                    {{--<ul>--}}
                        {{--<li class="disabled"><a href="#">&laquo;</a></li>--}}
                        {{--<li class="active"><a href="#">1</a></li>--}}
                        {{--<li><a href="#">2</a></li>--}}
                        {{--<li><a href="#">3</a></li>--}}
                        {{--<li><a href="#">4</a></li>--}}
                        {{--<li><a href="#">5</a></li>--}}
                        {{--<li><a href="#">&raquo;</a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            </div>
        </div>
    <!--搜索结果页面 列表 结束-->
    <script>
        function changeOrder(obj,conf_id) {
            var conf_order=$(obj).val();    // 获取对象input输入的conf_order值
            // 调用方法，传入token、conf_id及conf_order值，通过回调函数获取$data的值
            $.post("{{url('admin/config/changeorder')}}",{'_token':'{{csrf_token()}}','conf_id':conf_id,'conf_order':conf_order},function (data) {
                if (data.stutas == 0){    // 判断状态，给出相应图片
                    layer.msg(data.msg, {icon: 5});   // 通过引入第三方插件实现弹出窗信息
                }else {
                    layer.msg(data.msg, {icon: 6});
                }
            })
        }
        // 删除分类弹出提示框
        function delLink(conf_id) {
            layer.confirm('您确定要删除此分类吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/config')}}/"+conf_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (datas) {
                    if (datas.status == 0){     // 判断状态，给出相应图片
                        location.href = location.href; //  自己刷新页面???
                        layer.msg(datas.msg, {icon: 6});   
                    }else {
                        layer.msg(datas.msg, {icon: 5});
                    }
                })
    //                layer.msg('的确很重要', {icon: 1});
            }, function(){
    
            });
        }
    
    </script>
@endsection