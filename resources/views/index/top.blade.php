<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>top</title>
    <link rel="stylesheet" type="text/css" href="{{asset('public/css/css.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('public/css/top.css')}}"/>
    <link rel="shortcut icon"   href="<{$res}>/images/xdl.ico">
</head>
<body>
<div class="tops">
    <div class="log fl">
        <a href="javascript:void(0)" onclick="window.top.location='{{url('home/show')}}'"><img src="{{asset('public/images/logo.png')}}" alt=""></a>
        <!-- <img src="./images/top_bg2.jpg" alt="log" /> -->
    </div>
    <div class="history fl">
        <a href="javascript:history.go(-1);"><img src="{{asset('public/images/Arrow_l.png')}}" title="后退一步" alt="后退一步"></a>
        <a href="javascript:history.go(1);"><img src="{{asset('public/images/Arrow_r.png')}}" title="前进一步" alt="前进一步"></a>
    </div>
    <div class="users fr" style="width:425px;;">



        <div class="us fl" style="margin-right:1%;">
            <a href="{{url('home/main')}}" target="mainFrame">{{$user['username']}}</a>
        </div>

        <img src="{{asset('public/images/g.png')}}" alt="小竖杠"/>
        <div class="home fl">
            <a href="javascript:void(0)" onclick="window.top.location='{{url('home/index')}}'">首页</a>
        </div>
        <img src="{{asset('public/images/g.png')}}" alt="小竖杠"/>
        <div class="quit fl">
            <a href="{{url('home/quit')}}" target="_parent">退出</a>
        </div>

    </div>
</div>
</body>
</html>
