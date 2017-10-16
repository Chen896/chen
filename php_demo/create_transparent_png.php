<?php

    createImg();
    createImg2();

    function createImg(){
        # 1.GD创建无底透明的图片
        $image = imagecreatefrompng('https://www.baidu.com/img/bd_logo1.png');
        $zhibg = imagecolorallocate ($image, 0, 0, 0);

        imagefill($image, 0, 0, $zhibg);
        imagecolortransparent($image, $zhibg);  //将某个颜色定义为透明色

        imagepng($image, '../other/baidu.png');
        imagedestroy($image);  //销毁
    }

    function createImg2(){
        # 2.php生成透明的文字图片
        $img = imagecreatetruecolor(200, 200);  //生成真彩图
        $color = imagecolorallocate($img, 255, 255, 255);  //上色

        imagecolortransparent($img, $color);  //设置透明
        imagefill($img, 0, 0, $color);

        $textcolor = imagecolorallocate($img, 0, 0, 0); //向画布上写字
        imagettftext($img, 50, 0, 10, 100, $textcolor, "C:\Windows\Fonts\simsun.ttc", "测试");

        imagepng($img, "../other/aaa.png");  //保存
        imagedestroy($img); //释放
    }