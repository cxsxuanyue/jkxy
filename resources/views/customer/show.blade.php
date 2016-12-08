@extends('customer.base')
@section('content')
<style>
    .pagelist{
        margin-top: 1%;
        float: right;
        clear: both;
        margin-right: 1%;
    }
    .checkform{
        margin-right: 1%;
        margin-bottom: 1%;
    }
    .page ,.name,.phone{
        background: #EEEEEE;
        color: red;
    }
    input{
        text-align: center;
    }
</style>

<div class="pagelist checkform">

    {{--下拉框--}}
    <form action="{{url('home/customer')}}" method="get" id="checkform">

        <div class="btn-group">
            <select name="type" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <option  value="null">选择时间类型</option>
                <option  value="apply_time">报名日期</option>
                <option   value="client_insert_time">录入日期</option>

            </select>
        </div>
        {{--时间选择控件--}}
        <fieldset>
            <div class="control-group">
                <div class="controls">
                    <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" readonly style="width: 200px" name="time" id="reservation" class="form-control" value="" />
                    </div>
                </div>
            </div>
        </fieldset>

        <span class="btn btn-primary">姓名:</span><input type="text" class="name btn btn-success" name="username">
        <span class="btn btn-primary">电话:</span><input type="text" class="phone btn btn-success" name="phone">
        <button class="btn btn-primary check">查询</button>
    </form>
</div>
<br>
	<table class="main_tab">
		<tr>

			<th>录入日期</th>
			<th>客户姓名</th>
			<th>电话</th>
			<th>QQ</th>

			<th>意向校区</th>
			<th>意向学科</th>
			<th>意向班期</th>
			<th>录入时间</th>
			<th>报名时间</th>
			<th>业务人员</th>

			<th>客户状态</th>

		</tr>


		<tr style="background:<{if $row.status == 10}>
			#ccc
			<{elseif $row.classifys == 35}>
			#FFD700
			<{elseif  $row.classifys == 34}>
			#FF7F00
			<{elseif  $row.classifys == 12}>
			#550D4A
			<{elseif  $row.classifys == 13}>
			#FF99FF
			<{elseif  $row.classifys == 14}>
			#12F8EC
			<{elseif $row.worry == 1}>
			#FF4500
			<{elseif $row.worry == 2}>
			#32CD32
			<{/if}>">
				<!-- 批量操作只能主管可以操作 -->

@foreach($clt as $v)
			<tr>
				<td>{{$v['recordtime']}}</td>
				<td>{{$v['stuname']}}</td>
				<td>{{$v['phone']}}</td>
				<td>{{$v['qq']}}</td>

				<!--意向校区-->
				<td>{{$v['intentionschool']}}</td>
				<!--意向学科-->
				<td>{{$v['intentionsubject']}}</td>
				<!--意向班期-->
				<td>{{$v['classid']}}</td>
                <!--录入时间-->
                <td>{{date('Y-m-d',$v['recordtime'])}}</td>
                <!--报名时间-->
                <td>-</td>
				<!--业务人员-->
			    <td>{{$v['oncounselor']}}</td>
				<!--学员状态-->
				<td>
					@if($v['status']==3)
						公共库
					@elseif($v['status']==0)
						意向库
					@elseif($v['status']==1 || $v['status']==2)
						报名库
					@endif
				</td>
			</tr>
@endforeach
    </table>
@if($page['allPages'] > 1)
<div class="pagelist">
    <form action="customer" method="post" id="myform">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="_method" value="get">
        <input type="hidden" name="limit" value="{{$page['limit']}}">
        <input type="hidden" name="allPages" value="{{$page['allPages']}}">
        <input type="hidden" name="pageNum" value="{{$page['pageNum']}}">

        <span class="btn btn-primary">当前页：{{$page['pageNum']}}</span>
        <span class="btn btn-primary">总页数：{{$page['allPages']}}</span>
        <button class="btn btn-primary first" value="1">首页</button>
        @if($page['pageNum'] == 1)
            <button class="btn btn-primary uppage" disabled value="{{$page['pageNum'] - 1}}">上一页</button>
        @else
            <button class="btn btn-primary uppage" value="{{$page['pageNum'] - 1}}">上一页</button>
            {{--<button class="btn btn-primary perpage"  value="1">1</button>--}}
            {{--<button class="btn btn-primary perpage" disabled>...</button>--}}
        @endif
        <button class="btn btn-primary perpage"  value="{{$page['pageNum']}}">{{$page['pageNum']}}</button>
        @if($page['pageNum'] == $page['allPages'])
            <button class="btn btn-primary nextpage" disabled value="{{$page['pageNum'] + 1}}">下一页</button>
        @else
            {{--<button class="btn btn-primary perpage" disabled>...</button>--}}
            {{--<button class="btn btn-primary perpage"  value="{{$page['allPages']}}">{{$page['allPages']}}</button>--}}
            <button class="btn btn-primary nextpage" value="{{$page['pageNum'] + 1}}">下一页</button>
        @endif
        <button class="btn btn-primary last" value="{{$page['allPages']}}">末页</button>
        <input type="text" name="page" value="" class="page btn btn-success">
        <button class="btn btn-primary go">GO</button>
    </form>
</div>
@endif
<script type="text/javascript">
    $(document).ready(function() {
        $('#reservation').daterangepicker(null, function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });
</script>
<script>
    var limit = $("[name='limit']").val();
    var pageNum = $("[name='pageNum']").val();
    var allPages = $("[name='allPages']").val();
    $(".first").click(function () {
        // 获取要访问的页码数
        var pages = $(".first").val();
        $("[name='page']").val(pages);
        $("#myform").submit();
    });
    $(".uppage").click(function () {
        // 获取要访问的页码数
        var pages = $(".uppage").val();
        $("[name='page']").val(pages);
        $("#myform").submit();
    });
    $(".nextpage").click(function () {
        // 获取要访问的页码数
        var pages = $(".nextpage").val();
        $("[name='page']").val(pages);
        $("#myform").submit();
    });
    $(".last").click(function () {
        // 获取要访问的页码数
        var pages = $(".last").val();
        $("[name='page']").val(pages);
        $("#myform").submit();
    });
    $(".go").click(function () {
        var page = $("[name='page']").val();
        if (0 < page && page <= allPages) {
            $("#myform").submit();
        } else {
            alert('请输入合法的页码数！');
            return false;
        }
    });

    $(".perpage").click(function () {
        var page = $(".perpage").val();
        if (0 < page && page <= allPages) {
            $("[name='page']").val(page);
            $("#myform").submit();
        } else {
            alert('请输入合法的页码数！');
            return false;
        }
    });


//    条件查询
    $("#check").click(function () {
        $("#checkform").submit();
    })
</script>
@endsection
