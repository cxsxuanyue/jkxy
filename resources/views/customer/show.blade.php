@extends('customer.base')
@include('customer.display')
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
    @include('customer.search')
    <br>
    <table class="main_tab">
        <tr>
            <th>编号</th>
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
            <th>操作</th>

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
                <td>{{$v['id']}}</td>
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
                @if(!empty($v['apply_pay_time']))
                    <td>{{date('Y-m-d',$v['apply_pay_time'])}}</td>
                @else
                    <td>-</td>
            @endif
            <!--业务人员-->
                <td>{{$v['oncounselor']}}</td>
                <!--学员状态-->
                <td>
                    @if($v['status']==3)
                        公共库
                    @elseif($v['status']==0)
                        意向库
                    @elseif($v['status']==4)
                        无效
                    @elseif($v['status']==1 || $v['status']==2)
                        报名库
                    @elseif($v['status']==20 || $v['status']==2)
                        审核中
                    @endif
                </td>

                <td>
                    @if($v['status']==4)
                        <button cid="{{$v['id']}}" id="Appeal" style="color: red">无效申诉</button>
                    @elseif($v['status'] == 20)
                        <button style="color: green">审核中...</button>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

    {{--无搜索条件的分页开始--}}
    @if($page['allPages'] !== null)
        <div class="pagelist">
            <form action="customer" method="post" id="myform">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="_method" value="get">
                <input type="hidden" name="limit" value="{{$page['limit']}}">
                <input type="hidden" name="allPages" value="{{$page['allPages']}}">
                <input type="hidden" name="pageNum" value="{{$page['pageNum']}}">

                @if(isset($page['time']))
                    <input type="hidden" name="biaoshi" value="{{$page['time']}}">
                @endif

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

    {{--无搜索条件的分页js开始--}}
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
                layer.alert('请输入合法的页码数！');
                return false;
            }
        });

        $(".perpage").click(function () {
            var page = $(".perpage").val();
            if (0 < page && page <= allPages) {
                $("[name='page']").val(page);
                $("#myform").submit();
            } else {
                layer.alert('请输入合法的页码数！');
                return false;
            }
        });

        {{--无搜索条件的分页js结束--}}

        //    条件查询
        $("#check").click(function () {
            $("#checkform").submit();
        })

        // 提交申诉无效
        $('#Appeal').click(function () {

            $.post('{{url('home/appeal')}}',
                    {'_token':'{{csrf_token()}}',
                        'cid':$(this).attr('cid'),
                    },
                    function (data) {
                        if(data == '1'){
                            layer.confirm('申诉已提交，等待审核', {
                                btn: ['确定'] //可以无限个按钮
                                ,
                            },function(index){
                                location.reload();
                            });
                        }else {
                            layer.alert('申诉失败');
                        }

                    }
            );

        });
    </script>
    <script>
        {{--$("#close").click(function () {--}}
            {{--// 获取关闭按钮的值--}}
            {{--var close = $("#close").val();--}}
            {{--$.ajax({--}}
                {{--url:'close',--}}
                {{--type:'post',--}}
                {{--dataType:'json',--}}
                {{--data:{'button':close, '_token':'{{csrf_token()}}'},--}}
                {{--success:function (res) {--}}
                    {{--console.log(res);--}}
                    {{--if (res == '1') {--}}
                        {{--// 刷新本页面--}}
                        {{--location.reload();--}}
                    {{--} else {--}}
                        {{--layer.alert('关闭失败！');--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}
        {{--})--}}

         $("#close").click(function () {
            $("#whereform").submit();
        })
    </script>
@endsection
