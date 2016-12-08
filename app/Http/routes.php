<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => ['web']], function () {

    /**
     * 登录系统
     */

    Route::get('/', function () {
        return view('login');
    });
    Route::any('home/login','Home\LoginController@login');

});
    // 用户登录中间件
    Route::group(['middleware' => ['web','home.login'],'prefix'=>'home','namespace'=>'Home'], function () {
        /**
         * 首页视图路由
         */
        Route::get('index','IndexController@index');
        Route::get('top', 'IndexController@top');
        Route::get('bottom', 'IndexController@bottom');
        Route::get('list', 'IndexController@listshow');
        Route::get('menu', 'IndexController@menu');
        Route::get('main', 'IndexController@main');

        // 退出系统
        Route::get('quit','LoginController@quit');
        // 修改密码
        Route::get('revise','LoginController@revise');
        Route::post('uppass','LoginController@uppass');
        // 获取学科列表
        Route::any('subject', 'CustomerController@subject');
        // 获取学科列表
        Route::any('class', 'CustomerController@getClass');
        // 获取手机验证
        Route::post('phone', 'CustomerController@phone');
        // 操作客户的资源路由
        Route::resource('customer', 'CustomerController');
});