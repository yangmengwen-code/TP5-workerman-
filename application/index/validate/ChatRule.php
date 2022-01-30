<?php
/**
 * Created by PhpStorm.
 * User: yangmengwen
 * Date: 2022/1/29
 * Time: 8:39
 */

namespace app\index\validate;


use think\Validate;

class ChatRule extends Validate
{
    protected $rule = [
        'fid' => ['require','regex:^[1-9]\d*$'],
        'tid' => ['require','regex:^[1-9]\d*$'],
        'name' => ['require']
    ];

    protected $message = [
        'fid.require' => '参数错误',
        'tid.require' => '参数错误',
        'fid.regex' => '参数格式错误',
        'tid.regex' => '参数格式错误',
        'name.require' => '参数错误',
    ];

    protected $scene = [
        'init' => ['fid'],  //初始化页面
        'info' => ['fid','tid'],
        'friends' => ['fid']
    ];
}