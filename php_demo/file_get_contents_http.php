<?php

function http_post ($url, $data)
{
    $data_url = http_build_query ($data);
    $data_len = strlen ($data_url);

    $opts = array(
        'http'=>array(
            'method'=>'POST',
            'header'=>"Connection: close\r\nContent-Length: $data_len\r\n",
            'content'=>$data_url
        )
    );

    $context = stream_context_create($opts);
    $content = file_get_contents($url, false, $context);
    return  $content;
}


function file_get_contents_utf8($fn)
{
    $opts = array(
        'ssl' => array( #忽略SSL验证
            'verify_peer' => false,
            'verify_peer_name' => false,
        ),
        'http' => array(
            'method'=>"GET",
            'header'=>"Content-Type: text/html; charset=utf-8"
        )
    );

    $context = stream_context_create($opts);
    $result = @file_get_contents($fn, false, $context);
    return $result;
}