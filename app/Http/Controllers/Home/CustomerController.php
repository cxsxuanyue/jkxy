<?php

namespace App\Http\Controllers\Home;

use App\libraries\Base;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Yaml\Tests\B;
use Rediss;

class CustomerController extends Controller
{
    /**
     *
     *  学员查询页面及学员数据显示
     * @return array
     * @auth 杨楠 曹现赏
     * @date 20161210
     */
    public function index()
    {
        // 获取用户的ID
        $user = Session::get('user');
        $input = Input::all();

        // 获取搜索时间
        @$time = $input['time'];
        $xtime = explode(' - ',$time);

        // 开始时间和结束时间组成数组
        $arrtime = array();
        @$arrtime['type'] = $input['type'];

        foreach ($xtime as $k =>$v){
            $arrtime['start'] = strtotime($xtime[0]);
            @$arrtime['end'] = strtotime($xtime[1]);
        }

        // 判断是否传过来当前页数和每页的条数
        if (isset($_POST['limit']) && isset($_POST['page'])) {
            $stripNum = $_POST['limit'] * ($_POST['page'] - 1) + 1;
        } else {
            $stripNum = 1;
        }


        // 搜索条件 设置请求参数
        $clientarr = array();

        if(!empty($input['username'])){
            // 获取搜索的名字
            $clientarr=[
                'id' => $user['id'],
                'client_name'=>trim($input['username']),
            ];


            // 获取搜索的电话
        }else if (!empty($input['phone'])){
            $clientarr = [
                'id' => $user['id'],
                'phone_num'=>$input['phone'],
            ];

            // 获取搜索的时间
        }else if (!empty($input['time'])){
            $clientarr = [
                'id' => $user['id'],
                'time' => $arrtime,
            ];

            // 默认显示所有的
        }else{
            $clientarr = [
                'id' => $user['id'],
                'strip_num' => $stripNum

            ];
        }

        $token = new Base();

        // 获取学生数据
        $clienturl = config('api.host').'clientApi/getClientInfo';

        // 设置分页时每页的条数（不分页的时候无意义）
        $limit=15;

        // 判断有没有报名时间搜索的缓存
        if (Rediss::exists('timeapply_time')) {

            // 直接读取缓存
            $client = json_decode(Rediss::get('timeapply_time_data'), true);

            unset($client['ResultData']['allPages']);
            unset($client['ResultData']['limit']);
            unset($client['ResultData']['pageNum']);

            // 获取总条数
            $allLists = count($client['ResultData']);

            if (isset($_POST['page'])) {
                $page = $_POST['page'];
            } else {
                $page = 1;
            }

            $clientPage = array_slice($client['ResultData'], ($page-1)*$limit, $limit);
            $client['ResultData'] = $clientPage;

            // 计算总页数
            $tmp = $allLists % $limit;
            if ($tmp > 0) {
                $allPages = floor($allLists / $limit) + 1;
            } else {
                $allPages = floor($allLists / $limit);
            }
            $page = [
                // 总页数
                'allPages' => $allPages,
                'limit' => $limit,
                'pageNum' => $page,
            ];
        } else {

            // 判断有没有报名时间搜索条件
            if (isset($clientarr['time']['type'])) {

                if ($clientarr['time']['type'] == 'apply_time') {

                    // 把时间搜索的条件存到redis
                    Rediss::set('timestart'.$clientarr['time']['type'], $clientarr['time']['start']);
                    Rediss::set('timeend'.$clientarr['time']['type'], $clientarr['time']['end']);

                    // 把时间搜索的类型存到redis
                    Rediss::set('time'.$clientarr['time']['type'], $clientarr['time']['type']);

                    $client = json_decode($token->scurl($clienturl,$clientarr),true);

                    // 把报名搜索时间的数据保存到缓存
                    Rediss::set('timeapply_time_data', json_encode($client));

                    //=======
                    unset($client['ResultData']['allPages']);
                    unset($client['ResultData']['limit']);
                    unset($client['ResultData']['pageNum']);

                    // 获取总条数
                    $allLists = count($client['ResultData']);

                    if (isset($_POST['page'])) {
                        $page = $_POST['page'];
                    } else {
                        $page = 1;
                    }

                    $clientPage = array_slice($client['ResultData'], ($page-1)*$limit, $limit);
                    $client['ResultData'] = $clientPage;

                    // 计算总页数
                    $tmp = $allLists % $limit;
                    if ($tmp > 0) {
                        $allPages = floor($allLists / $limit) + 1;
                    } else {
                        $allPages = floor($allLists / $limit);
                    }

                    $page = [
                        'allPages' => $allPages,
                        'limit' => $limit,
                        'pageNum' => $page,
                    ];
                }
            }
        }

        // 判断有没有录入时间搜索的缓存
        if (Rediss::exists('timeclient_insert_time')) {

            // 直接读取缓存
            $client = json_decode(Rediss::get('timeclient_insert_time_data'), true);

            unset($client['ResultData']['allPages']);
            unset($client['ResultData']['limit']);
            unset($client['ResultData']['pageNum']);

            // 获取总条数
            $allLists = count($client['ResultData']);

            if (isset($_POST['page'])) {
                $page = $_POST['page'];
            } else {
                $page = 1;
            }

            $clientPage = array_slice($client['ResultData'], ($page-1)*$limit, $limit);
            $client['ResultData'] = $clientPage;

            // 计算总页数
            $tmp = $allLists % $limit;
            if ($tmp > 0) {
                $allPages = floor($allLists / $limit) + 1;
            } else {
                $allPages = floor($allLists / $limit);
            }
            $page = [
                // 总页数
                'allPages' => $allPages,
                'limit' => $limit,
                'pageNum' => $page,
            ];
        } else {

            // 判断是否存在录入时间的条件
            if (isset($clientarr['time']['type'])) {

                if ($clientarr['time']['type'] == 'client_insert_time') {

                    // 把时间搜索的条件存到redis
                    Rediss::set('timestart'.$clientarr['time']['type'], $clientarr['time']['start']);
                    Rediss::set('timeend'.$clientarr['time']['type'], $clientarr['time']['end']);

                    // 把时间搜索的类型存到redis
                    Rediss::set('time'.$clientarr['time']['type'], $clientarr['time']['type']);

                    $client = json_decode($token->scurl($clienturl,$clientarr),true);

                    // 把录入搜索时间的数据保存到缓存
                    Rediss::set('timeclient_insert_time_data', json_encode($client));

                    //=======
                    unset($client['ResultData']['allPages']);
                    unset($client['ResultData']['limit']);
                    unset($client['ResultData']['pageNum']);

                    // 获取总条数
                    $allLists = count($client['ResultData']);

                    if (isset($_POST['page'])) {
                        $page = $_POST['page'];
                    } else {
                        $page = 1;
                    }

                    $clientPage = array_slice($client['ResultData'], ($page-1)*$limit, $limit);
                    $client['ResultData'] = $clientPage;

                    // 计算总页数
                    $tmp = $allLists % $limit;
                    if ($tmp > 0) {
                        $allPages = floor($allLists / $limit) + 1;
                    } else {
                        $allPages = floor($allLists / $limit);
                    }

                    $page = [
                        'allPages' => $allPages,
                        'limit' => $limit,
                        'pageNum' => $page,
                    ];
                }

            }
        }

        // 判断有没有不选类型的时间搜索的缓存
        if (Rediss::exists('timenull')) {

            // 直接读取缓存
            $client = json_decode(Rediss::get('timenull_data'), true);

            unset($client['ResultData']['allPages']);
            unset($client['ResultData']['limit']);
            unset($client['ResultData']['pageNum']);

            // 获取总条数
            $allLists = count($client['ResultData']);

            if (isset($_POST['page'])) {
                $page = $_POST['page'];
            } else {
                $page = 1;
            }

            $clientPage = array_slice($client['ResultData'], ($page-1)*$limit, $limit);
            $client['ResultData'] = $clientPage;

            // 计算总页数
            $tmp = $allLists % $limit;
            if ($tmp > 0) {
                $allPages = floor($allLists / $limit) + 1;
            } else {
                $allPages = floor($allLists / $limit);
            }
            $page = [
                // 总页数
                'allPages' => $allPages,
                'limit' => $limit,
                'pageNum' => $page,
            ];

        } else {

            // 判断是否存在不选类型的时间的条件
            if (isset($clientarr['time']['type'])) {

                if ($clientarr['time']['type'] == 'null') {

                    // 把时间搜索的条件存到redis
                    Rediss::set('timestart'.$clientarr['time']['type'], $clientarr['time']['start']);
                    Rediss::set('timeend'.$clientarr['time']['type'], $clientarr['time']['end']);

                    // 把时间搜索的类型存到redis
                    Rediss::set('time'.$clientarr['time']['type'], $clientarr['time']['type']);

                    $client = json_decode($token->scurl($clienturl,$clientarr),true);

                    // 把录入搜索时间的数据保存到缓存
                    Rediss::set('timenull_data', json_encode($client));

                    //=======
                    unset($client['ResultData']['allPages']);
                    unset($client['ResultData']['limit']);
                    unset($client['ResultData']['pageNum']);

                    // 获取总条数
                    $allLists = count($client['ResultData']);

                    if (isset($_POST['page'])) {
                        $page = $_POST['page'];
                    } else {
                        $page = 1;
                    }

                    $clientPage = array_slice($client['ResultData'], ($page-1)*$limit, $limit);
                    $client['ResultData'] = $clientPage;

                    // 计算总页数
                    $tmp = $allLists % $limit;
                    if ($tmp > 0) {
                        $allPages = floor($allLists / $limit) + 1;
                    } else {
                        $allPages = floor($allLists / $limit);
                    }

                    $page = [
                        'allPages' => $allPages,
                        'limit' => $limit,
                        'pageNum' => $page,
                    ];

                }
            }

        }

        // 判断有没有按姓名搜索的缓存
        if (Rediss::exists('client_name')) {

            // 直接读取缓存
            $client = json_decode(Rediss::get('client_name_data'), true);

            $page = [
                'allPages' => $client['ResultData']['allPages'],
                'limit' => $client['ResultData']['limit'],
                'pageNum' => $client['ResultData']['pageNum'],
            ];

            //=======
            unset($client['ResultData']['allPages']);
            unset($client['ResultData']['limit']);
            unset($client['ResultData']['pageNum']);

        } else {

            if (isset($clientarr['client_name'])) {

                // 把姓名搜索的条件存到redis
                Rediss::set('client_name', trim($input['username']));

                $client = json_decode($token->scurl($clienturl,$clientarr),true);

                // 把姓名搜索的数据保存到redis
                Rediss::set('client_name_data', json_encode($client));

                $page = [
                    'allPages' => $client['ResultData']['allPages'],
                    'limit' => $client['ResultData']['limit'],
                    'pageNum' => $client['ResultData']['pageNum'],
                ];

                //=======
                unset($client['ResultData']['allPages']);
                unset($client['ResultData']['limit']);
                unset($client['ResultData']['pageNum']);
            }
        }

        // 判断有没有按电话搜索的缓存
        if (Rediss::exists('phone_num')) {

            // 直接读取缓存
            $client = json_decode(Rediss::get('phone_num_data'), true);

            $page = [
                'allPages' => $client['ResultData']['allPages'],
                'limit' => $client['ResultData']['limit'],
                'pageNum' => $client['ResultData']['pageNum'],
            ];

            //=======
            unset($client['ResultData']['allPages']);
            unset($client['ResultData']['limit']);
            unset($client['ResultData']['pageNum']);

        } else {

            if (isset($clientarr['phone_num'])) {

                // 把手机搜索的条件存到redis
                Rediss::set('phone_num', trim($input['phone']));

                $client = json_decode($token->scurl($clienturl,$clientarr),true);

                // 把姓名搜索的数据保存到redis
                Rediss::set('phone_num_data', json_encode($client));

                $page = [
                    'allPages' => $client['ResultData']['allPages'],
                    'limit' => $client['ResultData']['limit'],
                    'pageNum' => $client['ResultData']['pageNum'],
                ];

                //=======
                unset($client['ResultData']['allPages']);
                unset($client['ResultData']['limit']);
                unset($client['ResultData']['pageNum']);
            }
        }

        // 判断是否存在学生数据
        if (!isset($client)) {
            $client = json_decode($token->scurl($clienturl,$clientarr),true);

            $page = [
                'allPages' => $client['ResultData']['allPages'],
                'limit' => $client['ResultData']['limit'],
                'pageNum' => $client['ResultData']['pageNum'],
            ];
            unset($client['ResultData']['allPages']);
            unset($client['ResultData']['limit']);
            unset($client['ResultData']['pageNum']);
        }

        // 获取校区接口
        $schurl = config('api.host').'select/getIntentionSchool';
        $shcool = json_decode($token->scurl($schurl),true);

        // 远程请求学科接口
        $url = config('api.host').'select/getIntentionSubject';
        $sub = json_decode($token->scurl($url),true);

        // 远程请求用户接口
        $url = config('api.host').'user/getUserList';
        $user = json_decode($token->scurl($url),true);

        // 远程请求班期接口
        $url = config('api.host').'select/getIntentionClass';
        $cla = json_decode($token->scurl($url),true);

        //遍历学生数据 获取班期名称，组装数组
        foreach ($client['ResultData'] as $k => $v){

            foreach ($cla['ResultData'] as  $value){
                if ($v['classid'] ==$value['id']){

                    $client['ResultData'][$k]['classid']=$value['name'];
                }
            }
        }

        //遍历学生数据 对比客服id获取客户名称
        foreach ($client['ResultData'] as $k =>$v){

            foreach ($user['ResultData'] as  $value){
                if ($v['oncounselor'] ==$value['id']){
                    $client['ResultData'][$k]['oncounselor']=$value['username'];
                }
            }
        }

        // 遍历学生数据 对比校区id获取校区名称
        foreach ($client['ResultData'] as $k =>$v){

            foreach ($shcool['ResultData'] as  $value){
                if ($v['intentionschool'] ==$value['id']){
                    $client['ResultData'][$k]['intentionschool']=$value['name'];
                }
            }
        }
        // 遍历学生数据 对比学科id获取校区名称
        foreach ($client['ResultData'] as $k =>$v) {

            foreach ($sub['ResultData'] as $value) {
                if ($v['intentionsubject'] == $value['id']) {
                    $client['ResultData'][$k]['intentionsubject'] = $value['name'];
                }
            }
        }

        return view('customer.show',['clt'=>$client['ResultData'], 'page' => $page]);
    }

    /**
     *
     *  录入学员页面
     * @return array
     * @auth 杨楠
     * @date 20161201
     */
    public function create()
    {
        $token = new Base();
        // 获取校区接口
        $schurl = config('api.host').'select/getIntentionSchool';
        $shcool = json_decode($token->scurl($schurl),true);
        $shc = $shcool['ResultData'];

        return view('customer.add')->with('school',$shc);

    }

    /**
     *
     *  录入学员提交方法
     * @return array
     * @auth 杨楠
     * @date 20161202
     */
    public function store(Request $request)
    {
        // 获取用户的ID和角色
        $user = Session::get('user');

        // 组合参数
        $arr = [
            "stuname" => $_POST['name'],
            "stusex" => $_POST['stusex'],
            "phone" => $_POST['phone'],
            "qq" => $_POST['qq'],
            "email" => $_POST['email'],
            "intentionschool" => $_POST['intentionschool'],
            "intentionsubject" => $_POST['intentionsubject'],
            "classid" => $_POST['classid'],
            "consultrecord" => $_POST['consultrecord'],
            "remark" => $_POST['remark'],
            "user_id" => $user['id'],
            "role_id" => $user['role_id'],
        ];
        $token = new Base();
        // 获取校区接口
        $addurl = config('api.host').'clientApi/insertClient';
        $res = json_decode($token->scurl($addurl, $arr),true);

        // 如果录入成功返回1 反之返回0
        if($res['ServerNo']=='SN200'){
            return '1';
        }else if($res['ServerNo']=='SN202'){
            return '2';
        }else{
            return '0';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     *
     *  获取学科列表
     * @return array
     * @auth 杨楠
     * @date 20161202
     */
    public function subject()
    {
        $token = new Base();
        // 获取传递过来的学科 转化成数组
        $subjects = $_POST['subjects'];
        $rew = explode(',',$subjects);
        // 远程请求学科接口
        $url = config('api.host').'select/getIntentionSubject';
        $sub = json_decode($token->scurl($url),true);
        $subdata = array();
        foreach ($sub['ResultData'] as $value){
            if(in_array($value['id'],$rew)){
                $subdata[]= $value;
            }
        }

        return $subdata;
    }
    /**
     *
     *  获取班期列表
     * @return array
     * @auth 杨楠
     * @date 20161202
     */
    public function getClass()
    {
        $token = new Base();
        // 获取校区ID
        $schid = $_POST['schid'];
        // 获取学科ID
        $subid = $_POST['subid'];

        // 远程请求班期接口
        $url = config('api.host').'select/getIntentionClass';
        $cla = json_decode($token->scurl($url),true);

        // 根据校区和学科 获取相应的班期
        $cladata = array();
        foreach ($cla['ResultData'] as $value){
            if($value['school_id']==$schid && $value['subject_id']==$subid){
                $cladata[]= $value;
            }
        }

        return $cladata;
//        return $subid;
    }
    /**
     *
     *  申诉无效的接口
     * @return array
     * @author 杨楠
     * @date 20161209
     */
    public function appeal()
    {
        $token = new Base();
        // 获取用户ID
        $user = Session::get('user');

        // 获取学员ID
        $cid = $_POST['cid'];
        $data = array(
            'id' => $user['id'],
            'cid' => $cid
        );
        // 远程请求申诉接口
        $url = config('api.host').'ClientApi/appeal';
        $ap = json_decode($token->scurl($url,$data),true);

        // 申诉成功返回1 否则返回0
        if ($ap['ServerNo']=="SN200"){
            return 1;
        }else{
            return 0;
        }
    }
    /**
     *
     *  验证手偶记
     * @return array
     * @author 杨楠
     * @date 20161209
     */
    public function phone(Request $request)
    {
        $token = new Base();
        // 手机参数
        $user = Session::get('user');
        
        $phone =['phone' => $request['phone'],'id'=>$user['id']];
        // 请求手机验证参数
        $url = config('api.host').'ClientApi/repeatInsert';
        $ap = json_decode($token->scurl($url,$phone),true);
        return $ap['ServerNo'];
    }
}
