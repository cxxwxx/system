<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/20
 * Time: 15:03
 */

namespace Home\Model;


use Think\Model;

class OwnerModel extends Model
{
    //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),

    protected $_validate = array(
        array('name', 'require', '姓名不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('house', 'require', '房间号不能为空', self::MUST_VALIDATE  , 'regex', self::MODEL_BOTH),
        array('IDcard', 'require', '身份证号码不能为空', self::MUST_VALIDATE  , 'regex', self::MODEL_BOTH),
        array('phone', 'require', '电话号码不能为空', self::MUST_VALIDATE  , 'regex', self::MODEL_BOTH),
        array('relation', 'require','与户主关系不能为空',self::MUST_VALIDATE  ,'regex', self::MODEL_BOTH),
    );
    //自动完成
    protected $_auto = array(
        array('add_time', NOW_TIME, self::MODEL_INSERT),
        array('status', '0', self::MODEL_BOTH),
    );


}