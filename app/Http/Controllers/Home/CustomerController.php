<?php

namespace App\Http\Controllers\Home;

use App\libraries\Base;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Yaml\Tests\B;

class CustomerController extends Controller
{
    /**
     *
     *  学员查询页面及学员数据显示
     * @return array
     * @auth 杨楠
     * @date 20161203
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
                'time' => $stripNum,
            ];
            // 默认显示所有的
        }else{
            $clientarr = [
                'id' => $user['id'],
                'strip_num' => $arrtime

            ];
        }



        $token = new Base();

        // 获取学生数据

        $clienturl = config('api.host').'clientApi/getClientInfo';
        $client = json_decode($token->scurl($clienturl,$clientarr),true);

        $page = [
            'allPages' => $client['ResultData']['allPages'],
            'limit' => $client['ResultData']['limit'],
            'pageNum' => $client['ResultData']['pageNum'],
        ];
        unset($client['ResultData']['allPages']);
        unset($client['ResultData']['limit']);
        unset($client['ResultData']['pageNum']);

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
}
