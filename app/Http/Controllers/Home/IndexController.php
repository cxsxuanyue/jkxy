<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Rediss;

class indexController extends Controller
{
    // 首页展示
    public function index()
    {

        return view('index.index');
    }
    // 头部页面
    public function top()
    {
        $user = Session::get('user');
        return view('index.top')->with('user',$user);
    }
    // 底部页面
    public function bottom()
    {
        return view('index.bottom');
    }
    // 菜单框里的列表
    public function listshow()
    {
        return view('index.list');
    }
    // 菜单框
    public function menu()
    {
        return view('index.menu');
    }
    // 主体内容页面
    public function main()
    {
        return view('index.main');
    }

    // 删除所有redis缓存的方法
    public function close()
    {
        $button = $_POST['button'];
        if ($button) {

           $res =  Rediss::flushdb();
           if ($res == 'OK') {
               return redirect(url('home/customer'));
           } else {
               return view('errors.503');
           }
        }
    }

    // 系统管理下的清楚缓存
    public function systemClearCache()
    {
        $res =  Rediss::flushdb();
        if ($res) {
            return view('errors.show')->with('show', 'OK');
        } else {
            return view('errors.show')->with('show', 'UNOK');
        }
    }
}
