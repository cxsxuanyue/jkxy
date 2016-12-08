<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>兄弟连CRM系统</title>
	<link rel="stylesheet" type="text/css" href="{{asset('public/css/css.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{asset('public/css/login.css')}}"/>
	<script src="{{url('public/js/jquery-1.8.3.min.js')}}"></script>
	<script src="{{asset('public/layer/layer.js')}}"></script>
	<style>
		input{
			border: 0px;
		}
	</style>
	<meta property="qc:admins" content="1366067100642615162057044717164506000747716716450" />
</head>
<body>
	<div class="login">
		<div class="img_a">
			<div class="img_u">
				<p>兄弟连CRM系统</p>
				<div class="forms">
					<img src="{{asset('public/images/user.png')}}" alt="用户图标">

					<form  id="login">

						用户名：<input class="inp1" type="text" name="name" value=""/><br/><br/>
						密　码：<input class="inp1" type="password" name="password" value=""/><br/>
						<input class="inp2" type="submit" value="登陆系统"/>
					</form>
					<script>
						$('#login').submit(function () {

							$.post('{{url('home/login')}}',{
										'_token':'{{csrf_token()}}',
										'name':$('input[name=name]').val(),
										'password':$('input[name=password]').val(),
									},
								function (data) {
									if(data == '0'){
										layer.alert('账号或密码错误');
									}else {
										window.location="{{url('home/index')}}";
									}
								}
							);
							return false;
						});
					</script>
					<p></p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
