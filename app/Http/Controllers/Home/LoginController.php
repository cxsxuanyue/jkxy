<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use App\libraries\Base;
class LoginController extends Controller
{

    public function login(Request $request)
    {
        //通过参数,时间,和秘钥生成-------加密参数,签名,和时间 的数组


        // 获取登录提交过来的参数
        $re = $request->except('_token');

        $url = config('api.host').'login/login';

        // 判断是否提交过来参数
        if (isset($_POST['name'])) {
            $arr = [
                'name' => $_POST['name'],
                'password' => $_POST['password']
            ];
        } else {
            return redirect('/');
        }

        $token = new Base();

        $arr = json_decode($token->scurl($url,$arr),true);

        // 判断是否登录成功
        if($arr['ServerNo'] =='SN200'){
            // 讲用户信息存入session
            Session::put('user',$arr['ResultData']);
            return '1';
        }else{
            // 登录失败返回登录页面
            return '0';
        }

    }
    // 修改密码
    public function revise()
    {
        $user = Session::get('user');
        return view('customer.editPass')->with('user',$user);
    }
    public function uppass(Request $request)
    {

        // 组装参数
        $arr = [
            'user_id'=>$_POST['id'],
            'user_name'=>$_POST['username'],
            'old_pasw'=>$_POST['old'],
            'new_pasw'=>$_POST['password'],
        ];
        // 参数转化成json

        $url = config('api.host').'user/changePasw';

        // 加密 签名 并请求远程接口
        $token = new Base();

        $pass = json_decode($token->scurl($url,$arr),true);
        //修改成功返回1 否则返回0d
        if($pass['ServerNo']=='SN200'){
            return '1';
        }else{
            return '0';
        }

    }

    // 退出系统
    public function quit()
    {
        Session::flush();
        return redirect('/');
    }
}
