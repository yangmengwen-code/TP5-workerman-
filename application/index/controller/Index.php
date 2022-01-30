<?php
namespace app\index\controller;

use app\index\model\ChatModel;
use app\index\validate\ChatRule;
use think\Controller;
use think\Db;
use think\Request;
use think\Validate;

class Index extends Controller
{
    public function index(Request $request)
    {
        //todo 接收聊天双方fid tid
        if($request->isGet()){
            //获取参数
            $param = input('param.');
            //验证参数
            $initRule = new ChatRule();
            $valid = $initRule->scene('init')->check($param);
            if($valid !== true){
                return '<script>alert("房间参数错误，禁止进入！")</script>';
            }
            $fid = intval($param['fid']);
            //查询当前登录人身份信息
            $current = Db::name('user')->where('uid',$fid)->find();
            //查询所有人和我的聊天列表
            $chatList = Db::name('relation')
                ->alias('r')
                ->field('r.*,u.nickname as fname,u1.nickname as tname,u.picture as fimg,u1.picture as timg')
                ->join('user u','u.uid = r.fid','left')
                ->join('user u1','u1.uid = r.tid','left')
                ->where('fid',$fid)
                ->whereOr('tid',$fid)
                ->select();
            //循环处理
            $data = [];$res = [];
            foreach ($chatList as $k=>$v){
                if($v['tid'] != $fid){
                    $chat['tid'] = $v['tid'];
                    $chat['tname'] = $v['tname'];
                    $chat['timg'] = $v['timg'];
                    $chat['time'] = date('Y-m-d H:i:s',time());
                }else{
                    $chat['tid'] = $v['fid'];
                    $chat['tname'] = $v['fname'];
                    $chat['timg'] = $v['fimg'];
                    $chat['time'] = date('Y-m-d H:i:s',time());
                }
                $chat['pre'] = ChatModel::getLastInfo($fid,$v['tid']);
                //追加
                array_push($data,$chat);
            }
            //去重
            foreach ($data as $k=>$v){
                if(isset($res[$v['tid']])){
                    continue;
                }
                $res[$v['tid']] = $v;
            }
            //格式化
            $res = array_values($res);
            //渲染给前端
            $this->assign('current',$current);
            $this->assign('result',$res);
            return $this->fetch();
        }
    }

    public function chatInfo(Request $request){
        $param = input('param.');
        //验证
        $infoRule = new ChatRule();
        $valid = $infoRule->scene('info')->check($param);
        if($valid !== true){
            return ['Code'=>202,'Message'=>$infoRule->getError()];
        }
        //查询聊天信息
        $data = ChatModel::getAllInfo($param['fid'],$param['tid']);
        //返回
        return ['Code'=>200,'Message'=>'获取成功','Data'=>$data];
    }

    public function friends(Request $request){
        if($request->isPost()){
            $param = input('param.');
            //验证
            $fRule = new ChatRule();
            $valid = $fRule->scene('friends')->check($param);
            if($valid !== true){
                return ['Code'=>202,'Message'=>$fRule->getError()];
            }
            //查询好友列表
            $data = Db::name('user')->order('uid asc')->select();
            //返回数据
            return ['Code'=>200,'Message'=>'获取成功','Data'=>$data];
        }
    }
}
