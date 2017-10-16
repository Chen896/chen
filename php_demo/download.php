<?php

# 简单下载方法
function download(){
    $file = APP_ROOT . $this->request->get('url'); //物理路径
    $filename = $this->request->get('name'); //默认保存文件名

    // 检查文件是否存在
    if(!is_file($file)){
        echo '<script type="text/javascript">alert("文件不存在"); window.history.go(-1);</script>';
        exit;
    }

    header ( "Pragma: public" );
    header ( "Expires: 0" );
    header ( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
    header ( "Cache-Control: public" );
    header ( "Content-Description: File Transfer" );
    header ( "Content-Type: application/force-download" ); //强制下载

    header ( "Content-Disposition: attachment; filename=" . $filename . ";" );
    header ( "Content-Transfer-Encoding: binary" );
    header ( "Content-Length: " . filesize($file) );

    @readfile ( $file );
    exit;
}