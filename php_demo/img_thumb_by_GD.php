<?php

$src_img = '../other/1467779396.JPG';
imgThumb($src_img, 800, 500);
imgThumb2($src_img);

/**
 * 1.压缩裁剪图片（按原始比例）
 * @param  string  $src_img [要裁剪的图片]
 * @param  integer $dst_w   [裁剪后的宽度]
 * @param  integer $dst_h   [或裁剪后的高度]
 * @date 2017-4-10 10:12 By Chen
 */
function imgThumb($src_img, $dst_w=300, $dst_h=200){
    list($src_w, $src_h) = getimagesize($src_img);  // 获取原图尺寸

    $dst_scale = $dst_h/$dst_w; //目标图像长宽比
    $src_scale = $src_h/$src_w; // 原图长宽比

    if ($src_scale>=$dst_scale){  // 过高
        $w = intval($src_w);
        $h = intval($dst_scale*$w);

        $x = 0;
        $y = ($src_h - $h)/3;
    } else { // 过宽
        $h = intval($src_h);
        $w = intval($h/$dst_scale);

        $x = ($src_w - $w)/2;
        $y = 0;
    }

    // 剪裁
    $source = imagecreatefromjpeg($src_img);
    $croped = imagecreatetruecolor($w, $h);
    imagecopy($croped, $source, 0, 0, $x, $y, $src_w, $src_h);

    // 缩放
    $scale = $dst_w / $w;
    $target = imagecreatetruecolor($dst_w, $dst_h);
    $final_w = intval($w * $scale);
    $final_h = intval($h * $scale);
    imagecopyresampled($target, $croped, 0, 0, 0, 0, $final_w,$final_h, $w, $h);

    // 保存
    $timestamp = time();
    imagejpeg($target, $timestamp.".jpg");
    imagedestroy($target);
}

/**
 * 2.无损裁剪图片（统一宽高）
 * @param  string  $src_img [要裁剪的图片]
 * @param  integer $yy      [裁剪后的宽度]
 * @param  integer $xx      [裁剪后的高度]
 * @date 2017-4-10 10:12 By Chen
 */
function imgThumb2($src_img, $yy=200, $xx=140){ # 原图
    $imgstream = file_get_contents($src_img);
    $im = imagecreatefromstring($imgstream);
    $x = imagesx($im);//获取图片的宽
    $y = imagesy($im);//获取图片的高

    // 缩略后的大小
    $xx = 140;
    $yy = 200;

    if($x>$y){
    //图片宽大于高
        $sx = abs(($y-$x)/2);
        $sy = 0;
        $thumbw = $y;
        $thumbh = $y;
    } else {
    //图片高大于等于宽
        $sy = abs(($x-$y)/2.5);
        $sx = 0;
        $thumbw = $x;
        $thumbh = $x;
    }

    if(function_exists("imagecreatetruecolor")) {
        $dim = imagecreatetruecolor($yy, $xx); // 创建目标图gd2
    } else {
        $dim = imagecreate($yy, $xx); // 创建目标图gd1
    }

    //重采样拷贝部分图像并调整大小
    imageCopyreSampled ($dim,$im,0,0,$sx,$sy,$yy,$xx,$thumbw,$thumbh);

    //直接输出
    header ("Content-type: image/jpeg");
    imagejpeg ($dim, null, 100);  //filename为NULL：直接输出原始图象流

    //释放
    imagedestroy($dim);
}