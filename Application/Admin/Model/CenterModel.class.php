<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/12
 * Time: 21:41
 */

namespace Admin\Model;


use Think\Model;

class CenterModel extends Model
{
    protected $_validate = array(
        array('name', '1,16', '昵称长度为1-16个字符', self::EXISTS_VALIDATE, 'length'),
    );

//    public function lists($status = 1, $order = 'id DESC', $field = true){
//        $map = array('status' => $status);
//        return $this->field($field)->where($map)->order($order)->select();
//    }

}