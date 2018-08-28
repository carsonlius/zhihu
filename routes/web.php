<?php

Route::get('/', 'QuestionController@index');

Route::get('/home', 'QuestionController@index');

Auth::routes();

// 邮箱激活
Route::get('/EmailConfirm/Activate/{confirmation_token}', 'EmailConfirmController@Activate');

// 问题
Route::group(['prefix' => '/Question'], function () {
    Route::get('/create', 'QuestionController@create'); // 创建问题
    Route::get('/show/{question}', 'QuestionController@show'); // 展示问题
    Route::get('/edit/{question}', 'QuestionController@edit'); // 编辑问题
    Route::get('/index', 'QuestionController@index'); // 问题列表
    Route::delete('/{question}', 'QuestionController@destroy'); // 删除问题
    Route::put('/update/{question}', 'QuestionController@update'); // 更新问题
    Route::post('/store', 'QuestionController@store'); // 存储问题
});

// 答案

Route::group(['prefix' => 'Answer', 'middleware' => ['auth']], function () {
    Route::post('', 'AnswerController@store'); // 创建答案
});

// 关注者
Route::group(['prefix' => 'Follower', 'middleware' => ['auth']], function (){
    Route::get('/{question}', 'FollowerQuestionController@store'); // 关注问
});


// 私信
Route::group(['prefix' => 'message', 'middleware' => ['auth']], function (){
    // 当前用户收到的私信列表
    Route::get('/inbox', 'MessageController@index');

    // 来自某个特定用户发送给登陆用户的信息
    Route::get('/{friend_id}', 'MessageController@show');
});


// 消息通知
Route::group(['prefix' => 'notifications', 'middleware' => 'auth'], function(){
    // 消息通知列表
    Route::get('/', 'NotificationsController@index');

    // 消息详情列表
    Route::get('/{notification}', 'NotificationsController@show');
});


// 用户头像
Route::get('/avatar', 'UserController@avatar')->middleware('auth');
Route::post('/avatar', 'UserController@avatarUpload')->middleware('auth');

// 用户密码
Route::group(['prefix' => 'password', 'middleware' => ['auth']], function(){
    // 密码得更新
    Route::get('', 'PasswordController@password');

    // 密码更新
    Route::post('update', 'PasswordController@update');
});

// 用户设置列表 && 更新
Route::get('setting', 'UserController@settingList')->middleware('auth');

Route::get('permission', function (){
    return view('home');
});

// 用户角色
Route::group(['prefix' => 'Role', 'middleware' => 'auth'], function(){
    // 角色列表
    Route::get('/', 'RoleController@index');

    // 新建角色
    Route::get('/create', 'RoleController@create');

    // 编辑角色
    Route::get('/{role}/edit', 'RoleController@edit');

    // 角色权限分配
    Route::get('/permission', 'RoleController@permission');
});

// 权限
Route::group(['prefix' => 'permission', 'middleware' => 'auth'], function(){
    // 权限列表
    Route::get('/', 'PermissionController@index');

    // 编辑权限
    Route::get('/{permission}/edit', 'PermissionController@edit');

    // 新建权限
    Route::get('/create', 'PermissionController@create');
});

// 测试使用的路由
Route::get('/test', function (){
    return view('test.test');
});

Route::get('test_permission', 'PermissionController@tree');



