<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>兄弟连CRM系统</title>
    <link rel="shortcut icon"   href="<{$res}>/images/xdl.ico">
    <!--<script src="<{$res}>/js/jquery-1.8.3.min.js"></script>
    <script src="<{$res}>/js/menu.js"></script>-->
</head>
<frameset rows="67,87%,30" border="0">
    <frame src="{{url('home/top')}}" tppabs="" scrolling="no" name="acv">
    <frameset id="frame" cols="205, *">
        <frame src="{{url('home/list')}}" tppabs="" scrolling="no" name="ss">
        <frame src="{{url('home/main')}}" tppabs="" name="mainFrame">
    </frameset>
    <frame src="{{url('home/bottom')}}" tppabs="" scrolling="no" name="bb">
</frameset>
</html>