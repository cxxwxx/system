<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/20
 * Time: 14:52
 */

namespace Home\Controller;


use Home\Model\OwnerModel;

class OwnerController extends HomeController
{
    /**
     * 业主认证：
     *  判断是否登录
     *  登录后获取UID
     *  查看是否登录 查看数据库中是否存在 如果存在则判断他是否已完成认证
     *  如果没有认证则添加认证信息 添加到数据库中
     */
    public function register(){
        parent::login();
        $uid = session('user_auth')['uid'];
        $map['uid'] = $uid;
        $map['status'] = ['neq',-1];
        $val = M('Owner')->where()->find();
        if($val['status'] == 1){
            $this->success('您已认证',U('Index/index'));
        }elseif($val['status' == 0]){
            $this->success('您已经提交过认证信息 请耐心等待审核',U('Index/index'));
        }
        if(IS_POST){
            $owner = D('Owner');
            $data = $owner->create();
            if($data){
                $data['uid'] = $uid;
                if($owner->add($data)){
                    $this->success('认证提交成功 请等候审核！',U('Index/index'));
                    exit;
                }else{
                    $this->error('认证失败！');
                    exit;
                }
            }else{
                $this->error($owner->getError());
            }
        }
        $this->display();
    }

}