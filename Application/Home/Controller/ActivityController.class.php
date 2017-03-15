<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/15
 * Time: 11:44
 */

namespace Home\Controller;


class ActivityController extends HomeController
{
    public function index($p=1){
        //
        $model = M('Document')->where(['category_id'=>43]);
        $list = $model->page($p,1)->select();
        foreach($list as &$value){
            $value['path'] = get_cover($value['cover_id'],'path');
            $value['add_time'] = time_format($value['create_time']);
            $value['url'] = U('Activity/detail?id='.$value['id']);
        }
        if(IS_AJAX){
            if($list){
                $data['data'] = $list;
            }
            $this->ajaxReturn($data);//返回ajax数据
        }
        $this->assign('list',$list);
        $this->display();
    }
    public function detail(){
        $id = I('get.id');
        $list = M('Document')->where(['id'=>$id])->find();
        //点进页面时浏览量+1
        $list['view']+=1;
        //保存
        M('Document')->data(['view'=>$list['view']])->where(['id'=>$id])->save();

        $document = M('Document_article')->where(['id'=>$id])->find();
        $this->assign('list',$list);
        $this->assign('document',$document);
        $this->display();
    }
}