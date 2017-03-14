<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/14
 * Time: 16:25
 */

namespace Home\Controller;


class ServiceController extends HomeController
{
    public function index($p=1){
        $service = M('Document')->where(['category_id'=>41]);
        $list = $service->page($p,C('LIST_ROWS'))->select();
        $this->assign('list',$list);
        $this->display();
    }
    public function detail(){
        $id = I('get.id');
        $list = M('Document')->where(['id'=>$id])->find();
        $document = M('Document_article')->where(['id'=>$id])->find();
        $this->assign('list',$list);
        $this->assign('document',$document);
        $this->display();
    }

}