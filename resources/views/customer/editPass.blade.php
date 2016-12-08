@extends('customer.base')
@section('content')

<form id="editpass">
	{{csrf_field()}}
<input type="hidden" name="id" value="{{$user['id']}}"/>
<table class="main_tab">

	<tr>
		<td>用户名</td>
		<td><input type="text" name="username" value="{{$user['username']}}" readonly /></td>
	</tr>
	<tr>
		<td>旧密码</td>
		<td><input type="text" name="old" datatype="*6-16" errormsg="请输入6-16位的旧密码"/></td>
	</tr>
	<tr>
		<td>新密码</td>
		<td><input type="text" name="password"  datatype="*6-16" errormsg="请输入6-16位的新密码"/></td>
	</tr>
	<tr>
		<td>确认密码</td>
		<td><input type="text" name="repass"  datatype="*6-16" errormsg="请输入6-16位的密码"/></td>
	</tr>
	<tr>
		<td colspan="2">
			<button type="submit">修改</button>&nbsp;
			<button type="button" onclick="javascript:history.go(-1);">取消</button>
		</td>
	</tr>
</table>
</form>
<script>
	$('#editpass').submit(function () {

		$.post('{{url('home/uppass')}}', {
					'_token':'{{csrf_token()}}',
					'id':$("input[name=id]").val(),
					'username':$("input[name=username]").val(),
					'old':$("input[name=old]").val(),
					'password':$("input[name=password]").val(),
				},
				function (data) {
					if(data ==1){
						layer.alert('修改成功');
					}else {
						layer.alert('修改失败');
					}
				}
		);
		return false;
	});
</script>
@endsection
