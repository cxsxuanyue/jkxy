<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>menu</title>
    <link rel="stylesheet" type="text/css" href="{{asset('public/css/css.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('public/css/menu.css')}}"/>
    <script src="{{url('public/js/jquery-1.8.3.min.js')}}"></script>
    <script type="text/javascript">var path = "<{$res}>";</script>
    <script src="{{url('public/js/menu.js')}}"></script>
</head>
<body>
<div class="menu">
    <div class="img_bt fl"><img src="<{$res}>/images/ss1.png" alt=""></div>
    <div class="menus fl"></div>
    <div class="menur fl">操作导航</div>
    <div class="clearfix"></div>
    <div class="menul fl">咨询</div>
    <div class="dover" style="height:;">
        <div class="menu_nav fl">
@yield('content')
        </div>
    </div>
</div>
</body>
</html>
