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

//展示登录
Route::get('login', function () {
    return view('demo/login');
});

//处理登录
Route::any('logindo','DemoController@loginDo');


//展示添加日程
Route::get('add', function () {
    return view('demo/add');
});

//处理添加日程
Route::any('adddo','DemoController@addDo');

//展示添加日程
Route::get('show', function () {
    return view('demo/show');
});

//处理添加日程
// Route::get('time','DemoController@time');
