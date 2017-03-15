<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/14
 * Time: 11:32
 */

namespace Home\Controller;



class NoticeController extends HomeController
{
    public function index($p=1){
        //查询对应的页面数据
        $model = M('Document')->where(['category_id'=>40]);
//        dump(C('LIST_ROWS'));exit;
        $list = $model->page($p,1)->select();
//        dump($list);exit;
        foreach ($list as &$value){
            $value['path'] = get_cover($value['cover_id'],'path');
            $value['add_time'] = time_format($value['create_time']);
            $value['url'] = U('Notice/detail？id='.$value['id']);
        }
        //判断是否是ajax请求
        if(IS_AJAX){
            if(empty($list)){
                $data['error'] = 0;
            }else{
                $data['error'] = 1;
                $data['data']=$list;
            }
            $this->ajaxReturn($data);//ajax返回数据
        }
        $this->assign('list',$list);
        $this->display();
    }
    public function detail(){
        $id = I('get.id');
        $list = M('Document')->where(['id'=>$id])->find();
        $list['view']+=1;
        //保存
        M('Document')->data(['view'=>$list['view']])->where(['id'=>$id])->save();


//        dump($id);exit;

//        dump($list);
        $document = M('Document_article')->where(['id'=>$id])->find();
//        dump($document);exit;
        $this->assign('list',$list);
        $this->assign('document',$document);
        $this->display();
    }

}