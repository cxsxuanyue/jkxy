@extends('index.menu')
@section('content')

    <ul>



        <!-- 线上咨询师 -->
        <li>
            <a class="yia" href="#"><span>咨询管理</span></a>
            <dl class="subClass">
                <dd><a href="{{url('home/customer/create')}}" target="mainFrame">添加客户</a></dd>
                <dd><a href="{{url('home/customer')}}" target="mainFrame">记录查询</a></dd>

            </dl>
        </li>

        <li>
            <a class="yia" href="#"><span>系统管理</span></a>
            <dl class="subClass">
                <dd><a href="{{url('home/systemClearCache')}}" target="mainFrame">清除缓存</a></dd>
            </dl>
        </li>


        <li><a class="yia" href="#"><span>个人中心</span></a>
            <dl class="subClass">
                <dd><a href="{{url('home/revise')}}" target="mainFrame">修改密码</a></dd>
                <dd><a href="{{url('home/quit')}}" target="_top">退出登录</a></dd>
            </dl>
        </li>

    </ul>


@endsection