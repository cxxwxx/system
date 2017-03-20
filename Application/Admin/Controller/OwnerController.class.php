<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/20
 * Time: 16:25
 */

namespace Admin\Controller;


class OwnerController extends AdminController
{
    public function index()
    {
        $owners = M('Owner')->select();
//        dump($owners);exit;
        $this->assign('owners',$owners);
        $this->display();
    }

    public function edit()
    {
        
    }

}