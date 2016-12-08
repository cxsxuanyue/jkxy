@extends('customer.base')
@section('content')

	<form>
		{{csrf_field()}}
		<div class="tables fl">
			<table>
				<tr>
					<th colspan="10" style="width:1200px;">基本信息</th>
				</tr>
				<tr>
					<td class="centers">姓名<span style="color:red;">(*)</span>：</td>
					<td colspan="9">
						<input type="text" id="adname" name="name" value="" datatype="zh1-4"  sucmsg="输入姓名正确" errormsg="姓名必须是1-4个汉字" nullmsg="请输入客户姓名" placeholder="张三丰"/>
					</td>
				</tr>
				<tr>
					<td class="centers">性别<span style="color:red;">(*)</span>：</td>
					<td colspan="9">
						<input type="radio" value="1" name="stusex" id="male" datatype="*"  /><label for="male"> 男</label>
						<input type="radio" value="2" name="stusex" id="female" /><label for="female"> 女</label>
					</td>
				</tr>
				<tr>

					<td class="centers">电话<span style="color:red;">(*)</span>：</td>
					<td colspan="9">
						<input type="text" name="phone" id="phone" value=""   />


					</td>

				</tr>
				<tr>
					<td class="centers">QQ：</td>
					<td colspan="9">
						<input type="text" name="qq" id="qq" value=""  placeholder="请输入QQ号码"/>
					</td>
				</tr>
				<tr>
					<td class="centers">邮箱：</td>
					<td colspan="9"><input type="text" id="email" name="email" value="" ignore="ignore" placeholder="请输入邮箱"/>
					</td>
				</tr>


				<tr>
					<td class="centers">意向校区<span style="color:red;">(*)</span>：</td>
					<td colspan="9">
						<select id="schools" name="intentionschool">
							<option value="">--请选择意向校区--</option>

							@foreach($school as $v)
							<option class="subjects" value="{{$v['id']}}" title="{{$v['subjects']}}">
								{{$v['name']}}
							</option>
							@endforeach

						</select>
						<select id="subjects" name="intentionsubject" datatype="*" sucmsg="验证成功" errormsg="请选择咨询学科" nullmsg="请选择咨询学科">
							<option value="">--请选择意向学科--</option>
						</select>
						<select id="claa" name="classid" name="classid" datatype="*" sucmsg="验证成功" errormsg="请选择意向班期" nullmsg="请选择意向班期">
							<option value="">--请选择意向班期--</option>
						</select>
						<span class="Validform_checktip"></span>
					</td>
				</tr>

				<!-- 课程顾问填写表单 end -->

				<tr>
					<td class="centers">咨询记录：</td>
					<td colspan="9">
						<textarea name="consultrecord" id="consultrecord" datatype="*" sucmsg="验证通过" errormsg="请输入非空的记录" nullmsg="请输入咨询记录" placeholder="请输入咨询记录"></textarea>
					</td>
				</tr>
				<tr>
					<td class="centers">备注：</td>
					<td colspan="9">
						<textarea name="remark" id="remark" ignore="ignore" datatype="*" sucmsg="验证通过" errormsg="请输入备注"  placeholder="请输入备注"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="10" class="btns" style="text-align:center;">
						<input type="button" name="button"  id="aaa" value="提交" />
					</td>
				</tr>
			</table>
		</div>
	</form>
<!--zeb 去掉以往的学科级联 引入级联脚本 start-->
{{--<{include file="../base/schsubcla.html"}>--}}
<!--zeb 去掉以往的学科级联 引入级联脚本 end-->
<script>

	$('#schools').change(function () {
		// 首先之前对应的清除学科
		$("#subjects option:gt(0)").remove();
		var subject = $("#schools").find("option:selected").attr("title");

		$.post('{{url('home/subject')}}',
				{'_token':'{{csrf_token()}}',
					'cate_id':$('#schools').val(),
					'subjects':subject
				},
				function (data) {
					$.each(data, function(key,val){

						$("#subjects").append("<option class='suba' value='"+val.id+"'>"+val.name+"</option> ");
					});

				}
		);
	});
	// 选择学科 获取班期
	$('#subjects').change(function () {
		// 首先之前对应的清除班期
		$("#claa option:gt(0)").remove();
		// 获取学科ID
		var subid = $('#subjects').val();
		// 获取校区ID
		var schid = $('#schools').val();

		$.post('{{url('home/class')}}',
				{'_token':'{{csrf_token()}}',
					'schid':schid,
					'subid':subid
				},
				function (data) {
					console.log(data);
					$.each(data, function(key,val){
						console.log(val.name);
						$("#claa").append("<option value='"+val.id+"'>"+val.name+"</option> ");
					});

				}
		);
	});

	// 表单提交
	$('#aaa').click(function () {
		//判断姓名是否填写
		if($('#adname').val()== ''){
			layer.msg('请填写姓名', {
				offset: 't',
				anim: 6
			});
			return false;
		}
		//判断性别是否填写
		var sex = $('input:radio[name="stusex"]:checked').val();
		if(sex== null){
			layer.msg('请选择性别', {
				offset: 't',
				anim: 6
			});
			return false;
		}

		//判断电话是否填写
		if($('#phone').val()== ''){
			layer.msg('请填写电话', {
				offset: 't',
				anim: 6
			});
			return false;
		}


		$.post('{{url('home/customer ')}}', {
					'_token':'{{csrf_token()}}',
					'name':$('#adname').val(),
					'stusex':$("input[type='radio']:checked").val(),
					'phone':$('#phone').val(),
					'qq':$('#qq').val(),
					'email':$('#email').val(),
					'intentionschool':$('#schools').val(),
					'intentionsubject':$('#subjects').val(),
					'classid':$('#claa').val(),
					'consultrecord':$('#consultrecord').val(),
					'remark':$('#remark').val()
				},
				function (data) {
					console.log(data)
					if(data ==1){
						layer.confirm('录入成功', {
							btn: ['确定'] //可以无限个按钮
							,
						},function(index){
							location.reload();
						});
					}else if (data ==2){
						layer.alert('手机号码重复');
					}else{
						layer.alert('已分配到待分配库，请提醒管理员排班');
					}

				}
		);
	});


	// 添加表单验证的必选项
	function addStar(param){
		$(param).removeAttr('ignore').parent().prev().find('span').remove().append('<span style="color:red;">(*)</span>');
		$(param).removeAttr('ignore').parent().prev().append('<span style="color:red;">(*)</span>');
	}

</script>
@endsection