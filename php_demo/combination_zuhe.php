<?php

/**
 * 二维数组排列组合[保留下标]
 * @date 2017-08-07
 * @param  array  $arr [二维数组]
 * @return array       [一维数组]
 */
function combination(array $data)
{
    #1.保留下标
    $arr = array();
    foreach($data as $key=>$val){
        foreach($val as $v){
            $arr[$key][] = $key.'||'.$v;
        }
    }

    $num = count($arr);
    if ($num === 0) return false;
    if ($num === 1) {

        $combination = array();
        $val = array_shift($arr);
        foreach($val as $k=>$v){

            $vv = explode('||', $v);
            $combination[$k][$vv[0]] = $vv[1];
        }
        return $combination;
    };

    #2.排列组合
    while(count($arr) > 1) {
        $arr_first = array_shift($arr);
        $arr_second = array_shift($arr);
        $c = array();

        foreach ($arr_first as $v) {
            $v = (array) $v;

            foreach ($arr_second as $val) {
                $c[] = array_merge($v, (array) $val);
            }
        }

        array_unshift($arr, $c);
        unset($c);
    }

    #3.恢复下标
    $combination = array();
    foreach($arr[0] as $key=>$val){
        foreach($val as $v){

            $vv = explode('||', $v);
            $combination[$key][$vv[0]] = $vv[1];
        }
    }

    return $combination;
}

$arr = array(
    'Color'=>['white','black','pink'],
    'Size'=>['S','M','L','XL'],
    'Length'=>['A','B']
);
var_export(combination($arr));