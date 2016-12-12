@if(!(Rediss::keys('*')))
    <nav class="navbar navbar-default" role="navigation" style="height: 8%;">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <div class="control-group" id="shi" >
                        <div class="controls">
                            <div class="input-prepend input-group">
                                <form action="{{url('home/customer')}}" method="get" id="checkform">
                                <span>
                                    <span class="btn btn-primary">
                                        <select name="type" class="btn btn-primary" data-toggle="dropdown">
                                            <option  value="null">选择时间类型</option>
                                            <option  value="apply_time">报名日期</option>
                                            <option  value="client_insert_time">录入日期</option>
                                        </select>
                                    </span>
                                    <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                    <input type="text" readonly style="width: 200px" name="time" id="reservation" placeholder="请点击选择时间" class="phone btn btn-success" value="" />
                                    <span id="nam" class="btn btn-primary">姓名:</span><input type="text" class="name btn btn-success" name="username">
                                    <span class="btn btn-primary">电话:</span><input type="text" class="phone btn btn-success" name="phone">
                                    <button class="btn btn-primary check">查询</button>
                                </span>
                                </form>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </nav>
@endif


