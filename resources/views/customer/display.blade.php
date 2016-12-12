<style>
    .glyphicon{
        color: red;
    }

    .display{
        margin-left: 1%;
    }
</style>

<hr/>
<div class="display">
    <span>已选条件：</span>

    {{--报名时间--}}
    @if(Rediss::exists('timeapply_time'))
        <div>
            <form action="close" method="post" id="whereform">
                <span>报名时间：</span>
                {{date('Y-m-d', Rediss::get('timestartapply_time'))}}
                <span>至</span>
                {{date('Y-m-d', Rediss::get('timeendapply_time'))}}
                {{csrf_field()}}
                <button id="close" name="button" value="1"><div class="glyphicon glyphicon-remove"></div></button>
            </form>
        </div>
    @endif

    {{--录入时间--}}
    @if(Rediss::exists('timeclient_insert_time'))
       <div>
               <form action="close" method="post" id="whereform">
               <span>录入时间：</span>
               {{date('Y-m-d', Rediss::get('timestartclient_insert_time'))}}
               <span>至</span>
               {{date('Y-m-d', Rediss::get('timeendclient_insert_time'))}}
               {{--<button id="close" value="1"><div class="glyphicon glyphicon-remove"></div></button>--}}
               {{csrf_field()}}
                <button id="close" name="button" value="1"><div class="glyphicon glyphicon-remove"></div></button>
            </form>
       </div>
    @endif

    {{--不选类型的时间搜索--}}
    @if(Rediss::exists('timenull'))
        <div>
            <form action="close" method="post" id="whereform">
                <span>录入时间(空)：</span>
                {{date('Y-m-d',Rediss::get('timestartnull'))}}
                <span>至</span>
                {{date('Y-m-d',Rediss::get('timeendnull'))}}
                <button id="close" value="1"><div class="glyphicon glyphicon-remove"></div></button>
                {{csrf_field()}}
                <button id="close" name="button" value="1"><div class="glyphicon glyphicon-remove"></div></button>
            </form>
        </div>
    @endif

    {{--姓名搜索--}}
    @if(Rediss::exists('client_name'))
        <div>
            <form action="close" method="post" id="whereform">
                <span>姓名：</span>
                {{Rediss::get('client_name')}}
                {{--<button id="close" value="1"><div class="glyphicon glyphicon-remove"></div></button>--}}
                {{csrf_field()}}
                <button id="close" name="button" value="1"><div class="glyphicon glyphicon-remove"></div></button>
            </form>
        </div>
    @endif

    {{--电话搜索--}}
    @if(Rediss::exists('phone_num'))
        <div>
            <form action="close" method="post" id="whereform">
                <span>电话：</span>
                {{Rediss::get('phone_num')}}
                {{--<button id="close" value="1"><div class="glyphicon glyphicon-remove"></div></button>--}}
                {{csrf_field()}}
                <button id="close" name="button" value="1"><div class="glyphicon glyphicon-remove"></div></button>
            </form>
        </div>
    @endif
</div>

<hr/>