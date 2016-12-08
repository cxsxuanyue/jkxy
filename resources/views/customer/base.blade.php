<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
	<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>

	<!-- 新 Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">

	<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	{{--时间插件--}}
	<script src="{{asset('public/js/moment.js')}}"></script>
	<script src="{{asset('public/js/daterangepicker.js')}}"></script>
	{{--时间css--}}
	<link rel="stylesheet" type="text/css" href="{{asset('public/css/daterangepicker-bs3.css')}}"/>

	<link rel="stylesheet" type="text/css" href="{{asset('public/css/css.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{asset('public/css/main.css')}}"/>


	<!-- 自定义js文件 -->
	<script>
		var host = '<{$app}>';
	</script>

	<script src="{{url('public/js/menu.js')}}"></script>

{{--
	<!-- 对话框 -->
	<link rel="stylesheet" href="{{asset('bulic/plugin/artDialog/css/ui-dialog.css')}}" />
	<script src="{{asset('bulic/plugin/artDialog/dist/dialog-min.js')}}"></script>--}}

{{--	<!-- 表单验证 -->
	<script src="{{asset('publi/plugin/Validform_v5.3.2_min.js')}}"></script>--}}

	<!-- 表单美容 -->
	<link rel="stylesheet" href="{{asset('public/plugin/jqtransform/jqtransform.css')}}" />
	<script src="{{asset('public/plugin/jqtransform/jquery.jqtransform-min.js')}}"></script>


	<!-- 加载弹窗插件-->
	<script src="{{asset('public/layer/layer.js')}}"></script>


</head>
<body>
	<div class="main">

@yield('content')
	</div>
</body>
</html>
