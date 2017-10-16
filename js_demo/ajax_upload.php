<?php

# H5 Ajax 上传图片
if(!isset($_FILES)) die('请选择图片！');

# 1.上传文件转换成二进制数据流
    # 1.1接收文件
    $image = $_FILES['file'];
    $tmp_name = $image['tmp_name'];
    $size = $image['size'];

    # 1.2验证是否是图片
    $ext_name = pathinfo($image['name'], PATHINFO_EXTENSION);
    if(!in_array( $ext_name, array('png','jpg','jpeg','gif') )) die('只接受图片格式的文件！');

    # 1.3转换二进制
    $file = file_get_contents($tmp_name);

    # 1.4生成图片
    $filename = date('YmdHis') . '.png';  #新图片名称
    $res = file_put_contents($filename, $file);  #生成图片
    echo $res ? '上传成功【'.$filename.'】' : '上传失败！';
#-----------------------------------------------------------------------------------------------
#-----------------------------------------------------------------------------------------------




/** 2.发送流文件
* @param  String  $url  接收的路径
* @param  String  $file 要发送的文件
* @return boolean
*/
function sendStreamFile($url, $file){
    if(file_exists($file)){
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'content-type:application/x-www-form-urlencoded',
                'content' => file_get_contents($file)
            )
        );

        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);
        $ret = json_decode($response, true);
        return $ret['success'];
    }else{
        return false;
    }
}
// $ret = sendStreamFile('http://localhost/receiveStreamFile.php', 'send.txt');


/** 3.接收流文件
* @param  String  $file 接收后保存的文件名
* @return boolean
*/
function receiveStreamFile($receiveFile){
    $streamData = isset($GLOBALS['HTTP_RAW_POST_DATA'])? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

    if(empty($streamData)){
        $streamData = file_get_contents('php://input');
    }

    if($streamData!=''){
        $ret = file_put_contents($receiveFile, $streamData, true);
    }else{
        $ret = false;
    }

    return $ret;
}
// $receiveFile = 'receive.txt';
// $ret = receiveStreamFile($receiveFile);
// echo json_encode(array('success'=>(bool)$ret));