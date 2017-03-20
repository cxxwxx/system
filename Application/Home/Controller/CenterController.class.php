<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/15
 * Time: 14:31
 */

namespace Home\Controller;


class CenterController extends HomeController
{
    public function index(){
       //判断是否登录  没有登录则跳转到登录页面
        parent::login();
        //查出当前用户SESSION中的数据
        $value = session('user_auth');
//        dump($value);
        /*array(3) {
            ["uid"] => string(1) "1"
            ["username"] => string(5) "Admin"
            ["last_login_time"] => string(10) "1489558678"*/
        $user = M('Member')->where(['uid'=>$value['uid']])->find();
//        dump($user);exit;
        $this->assign('user',$user);
        $this->display();
    }
    public function sign(){
        //判断当前登录用户是否签到
        $member_id = session('user_auth')['uid'];
        $model = M('Member')->where(['uid'=>$member_id])->find();
        if(date('Y-m-d',$model['last_sign_time']) < date('Y-m-d')){
            //签到
            $model['score'] +=rand(1,20);
            $model['last_sign_time'] = time();
            M('Member')->data(['score'=>$model['score'],'last_sign_time'=>$model['last_sign_time']])->where(['uid'=>$member_id])->save();
            $data['error'] = 0;
            $data['msg'] = '签到成功';
        }else{
            $data['error'] = 1;
            $data['msg'] = '您今天已经签到过了，请明天再来哦~';
        }
        $this->ajaxReturn($data);
    }
}