<?php

/**
 * 采集函数【file_get_contents, curl】
 * HTTP请求中的Query String Parameters[GET]、Form Data[POST提交表单数组] 和 Request Payload[POST提交Json对象]
 *
 * 备注：Joom平台Api[Curl提交的数组需要 http_build_query() 2017-12-25]
 * @date 2017-12-02
 */

#1.file_get_contents模拟GET/POST请求
function file_get_contents_http($url, $data)
{
    # $data = array('foo'=>'bar', 'bar'=>'baz');
    # 1.HTTP请求参数 Form Data ------------------------------------------
    # Content-type: application/x-www-form-urlencoded
    // $data = http_build_query($data);

    # 2.HTTP请求参数 Request Payload ------------------------------------
    # Content-Type: application/json; charset=UTF-8
    $data = json_encode($data);

    $data_len = strlen($data);
    $opts = array(
        'ssl' => array( #忽略SSL验证
            'verify_peer' => false,
            'verify_peer_name' => false,
        ),
        'http'=>array(
            'method'=>'POST',
            'header'=>"Connection: close\r\nContent-Length: $data_len\r\nContent-type: application/json; charset=UTF-8\r\n",
            'content'=>$data,
            'timeout'=>60
        )
    );

    $context = stream_context_create($opts);
    $content = array(
        'content'=>file_get_contents($url, false, $context),
        'headers'=>$http_response_header #头信息[get_headers($url)]
    );
    return  $content;
}


#2.Curl模拟GET/POST请求
function CurlRequest($url, $data='', $header=array(), $timeout=30)
{
    // if(!function_exists('curl_init')) return 'Can not find curl extension';
    $ch = curl_init();

    $opts = array();
    $opts[CURLOPT_URL] = $url;
    $opts[CURLOPT_HEADER] = 0;
    $opts[CURLOPT_HTTPHEADER] = $header;
    $opts[CURLOPT_RETURNTRANSFER] = 1;

    # Note: 传递一个数组到 CURLOPT_POSTFIELDS ，cURL会把数据编码成 multipart/form-data，而然传递一个URL-encoded字符串时，数据会被编码成 application/x-www-form-urlencoded。

    # $data  = array('name'=>'Foo', 'file'=>'@/home/user/test.png');
    # $data  = array('name'=>'Foo', 'file'=>new CURLFile( realpath('image.png') )); //PHP5.6及以上版本利用curl文件上传[PHP推荐使用CURLFile替代旧的@语法]
    if(!empty($data)){ // POST请求
        $is_array = is_array($data) && sizeof($data);

        $opts[CURLOPT_POST] = $is_array ? sizeof($data) : 1;
        $opts[CURLOPT_POSTFIELDS] = $data;
    }

    $opts[CURLOPT_TIMEOUT] = $timeout;
    $opts[CURLOPT_SSL_VERIFYPEER] = 0;
    $opts[CURLOPT_SSL_VERIFYHOST] = 0;

    curl_setopt_array($ch, $opts);
    $response = curl_exec($ch);

    $errno = curl_errno($ch);
    if (0 !== $errno) { #返回头信息
        return curl_getinfo($ch) + array('errno'=>$errno, 'error'=>curl_error($ch));
    }
    curl_close($ch);

    return $response;
}

##------------------------------------------------------------------------------------
##------------------------------------------------------------------------------------

$url = 'http://www.haiyingshuju.com/hysj/product_information';
$data = json_encode( array('pid'=>"558a6a0e84c2e807b76f923d") );

$header = array(
    'Content-Type: application/json;charset=UTF-8',
    'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.89 Safari/537.36'
);


// var_dump('<pre>', file_get_contents_http($url, array('pid'=>"558a6a0e84c2e807b76f923d")) );
var_dump('<pre>', $data, CurlRequest($url, $data, $header));


