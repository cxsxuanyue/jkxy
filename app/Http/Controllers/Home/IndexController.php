<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;

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

}
