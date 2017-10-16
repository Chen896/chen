<?php

/**
 * 无限分类树（支持子分类排序）
 * version：1.4
 * author：Veris
 * website：www.mostclan.com
 * @date 2017-08-17 17:23
 */
class ClassTree {

    /**
     * 分类排序（降序）
     */
    static public function sort($arr, $cols){
        //子分类排序
        foreach ($arr as $k => &$v) {
            if(!empty($v['sub'])){
                $v['sub'] = self::sort($v['sub'], $cols);
            }
            $sort[$k] = $v[$cols];
        }

        if(isset($sort))
            array_multisort($sort, SORT_DESC, $arr);
        return $arr;
    }

    /**
     * 横向分类树
     */
    static public function hTree($arr, $pid=0){
        foreach ($arr as $v) {
            if($v['pid'] == $pid){
                $data[$v['id']] = $v;
                $data[$v['id']]['sub'] = self::hTree($arr, $v['id']);
            }
        }
        return isset($data) ? $data : array();
    }

    /**
     * 纵向分类树
     */
    static public function vTree($arr, $pid=0){
        foreach ($arr as $v) {
            if($v['pid'] == $pid){
                $data[$v['id']] = $v;
                $data += self::vTree($arr, $v['id']);
            }
        }
        return isset($data) ? $data : array();
    }


}

//===========================Example===========================
$arr=array(
    array('id'=>1,'pid'=>0,'name'=>'浙江','sort'=>0),
    array('id'=>10,'pid'=>1,'name'=>'宁波','sort'=>0),
    array('id'=>13,'pid'=>1,'name'=>'金华','sort'=>1),
    array('id'=>4,'pid'=>0,'name'=>'上海','sort'=>2),
    array('id'=>5,'pid'=>4,'name'=>'闵行','sort'=>0),
    array('id'=>6,'pid'=>10,'name'=>'宁海','sort'=>0),
);
$arr=ClassTree::sort($arr,'sort');
$data=ClassTree::hTree($arr);
$data2=ClassTree::vTree($arr);


echo '<pre>';
print_r($arr);

print_r($data);
print_r($data2);