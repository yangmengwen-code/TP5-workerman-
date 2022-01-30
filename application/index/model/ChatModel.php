<?php
/**
 * Created by PhpStorm.
 * User: yangmengwen
 * Date: 2022/1/29
 * Time: 14:14
 */

namespace app\index\model;


use think\Db;
use think\Model;

class ChatModel extends Model
{
    public static function getLastInfo($fid,$tid){
        $data = Db::name('relation')->where(['fid'=>$fid,'tid'=>$tid])->whereOr(['fid'=>$tid,'tid'=>$fid])->order('id desc')->find();
        return $data;
    }

    public static function getAllInfo($fid,$tid){
        $data =  Db::name('relation')
            ->alias('r')
            ->field('r.*,u.nickname as fname,u1.nickname as tname,u.picture as fimg,u1.picture as timg')
            ->join('user u','u.uid = r.fid','left')
            ->join('user u1','u1.uid = r.tid','left')
            ->where(['fid|tid'=>$fid,'tid|fid'=>$tid])
            ->order('r.id')
            ->select();
        return $data;
    }
}