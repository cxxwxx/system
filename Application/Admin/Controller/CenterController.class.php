<?php
/**
 * Created by PhpStorm.
 * User: yl
 * Date: 2017/3/12
 * Time: 11:04
 */

namespace Admin\Controller;


use Think\Page;

class CenterController extends AdminController
{
    public function action(){
        //获取列表数据
        $Action =   M('Action')->where(array('status'=>array('gt',-1)));
        $list   =   $this->lists($Action);
        int_to_string($list);
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->assign('_list', $list);
        $this->meta_title = '用户行为';
        $this->display();
    }

    public function index()
    {
        $count = M('Repair')->count();
        //分页工具
        $page = new Page($count,C('LIST_ROWS'));

        $page_html = $page->show(); //分页工具条
        $list = M('Repair')->page(I('p',1),$page->listRows)->select();
        //分页工具条
        //处理分页数据
        $this->assign('list',$list);
        $this->assign('page',$page_html);
        $this->meta_title = '物业管理';
        $this->display();
    }

    public function changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] =   array('in',$id);
        switch ( strtolower($method) ){
            case 'js':
                $model = 'Repair';
                $where = $map;
                $data    =  array('status' => 1);
                $msg = array( 'success'=>'接收处理成功！', 'error'=>'接收处理失败！');
                $this->editRow(  $model , $data, $where, $msg);
                break;
            case 'wc':
                $model = 'Repair';
                $where = $map;
                $data    =  array('status' => 2);
                $msg = array( 'success'=>'处理完成成功！', 'error'=>'处理完成失败！');
                $this->editRow(  $model , $data, $where, $msg);
                break;
            case 'delete':
                $model = 'Repair';
                $where = $map;
                $data    =  array('status' => -1);
                $msg = array( 'success'=>'删除成功！', 'error'=>'删除失败！');
                $this->editRow(  $model , $data, $where, $msg);
                break;
            default:
                $this->error('参数非法');
        }
    }

    public function add($name = '', $tel = '', $address = '', $pro = ''){
        if(IS_POST){
            $user = array('name' => $name, 'tel' => $tel, 'address' => $address,'pro'=>$pro,'status'=>0,'time'=>time());
//            dump($user);exit;
            if(!M('Repair')->add($user)){
                $this->error('报修添加失败！');
            } else {
                $this->success('报修添加成功！',U('index'));
            }
        } else {
            $this->meta_title = '新增物业';
            $this->display('edit');
        }
    }

    public function detail()
    {
        $id = array_unique((array)I('id',0));
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] =   array('in',$id);
        $list   = $this->lists('Repair', $map);
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = '物业详情';
        $this->display();
    }
    public function activity(){
        $data=M("Apply");
        $user=M('Member');
        $activity=M('Document');
        $list=$data->select();
        //添加用户名
        foreach ($list as &$item){
            $aa=$user->where(['uid'=>$item['member_id']])->find();
            $item['nickname']=$aa['nickname'];
            $act_info=$activity->where(['id'=>$item['act_id']])->find();
            $item['act_name']=$act_info['title'];
            $item['act_des']=$act_info['description'];
            $item['act_endtime']=date('Y-m-d',$act_info['deadline']);
            $item['act_status']=$act_info['status'];
        }
        $this->assign('activity',$list);
       $this->display();

    }
}