<?php
/**
 * Created by PhpStorm.
 * User: yangmengwen
 * Date: 2022/1/26
 * Time: 8:44
 */

use think\Route;

Route::rule([
    'index' => 'index/Index/index',
    'chatInfo' => 'index/Index/chatInfo',
    'friends' => 'index/Index/friends',
]);