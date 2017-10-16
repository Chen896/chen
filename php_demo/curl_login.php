<?php

/**
 * Curl 模拟 POST请求 登录
 * @param  string $url      采集的url
 * @param  array $postData  post提交的数据
 * @param  array $header    header头数组，curl命令里的-H参数组成的数组
 * @param  array $opts      option数组，供额外添加opt属性
 * @param  string $cookieSaveFile    存储cookie的文件
 * @param  string $cookieGetFile     读取cookie的文件（可以是上一个getPage存下来的cookie文件）
 * @param  string $timeout  超时时间
 * @date 2017-08-28 17:32
 */
function curlPage( $url, $postData=array(), $header=array(), $opts=array(), $cookieSaveFile='', $cookieGetFile='' , $timeout=60 ) {
    $ch  = curl_init();
    $options = array();

    $options[CURLOPT_URL] = $url;
    $options[CURLOPT_HEADER] = false;         //不输出头信息
    $options[CURLOPT_NOBODY] = false;         //需要页面内容
    $options[CURLOPT_RETURNTRANSFER] = true;  //返回数据不直接输出
    $options[CURLOPT_FOLLOWLOCATION] = true;  //add 302 support

    //SSL
    if(substr($url, 0, 8) === 'https://') {
        $options[CURLOPT_SSL_VERIFYPEER] = false;
        $options[CURLOPT_SSL_VERIFYHOST] = false;
        //error:14077458:SSL routines:SSL23_GET_SERVER_HELLO:reason(1112)解决
        // $options[CURLOPT_SSLVERSION] = 1; //值有0-6，请参考手册，值1不行试试其他值
    }

    //post数据
    if(!empty($postData)) {
        $options[CURLOPT_POST] = 1;                  //发送POST类型数据
        $options[CURLOPT_POSTFIELDS] = $postData;    //POST数据，$post可以是数组（multipart/form-data），也可以是拼接参数串（application/x-www-form-urlencoded）
    }

    //头信息
    if(!empty($header))  $options[CURLOPT_HTTPHEADER] = $header;
    //存储cookie到文件
    if(!empty($cookieSaveFile))  $options[CURLOPT_COOKIEJAR] = $cookieSaveFile;
    //使用存储的cookie数据做参数（上一次请求得到的cookie文件）
    if(!empty($cookieGetFile))  $options[CURLOPT_COOKIEFILE] = $cookieGetFile;
    //超时时间
    if(!empty($timeout))  $options[CURLOPT_TIMEOUT] = (int)$timeout;

    //额外option
    if(!empty($opts)) {
        foreach($opts as $key => $value)
            $options[$key] = $value;
    }

    //配置属性
    curl_setopt_array($ch, $options);
    $result = array();
    $result['ack'] = 'success';
    $result['content'] = curl_exec($ch);         //执行结果
    // $result['curlinfo'] = curl_getinfo($ch);  //连接资源句柄的信息

    if($error = curl_error($ch)){
        $result['ack'] = 'fail';
        $result['error'] = $error;
    }

    curl_close($ch);
    return $result;
}

$url = 'http://192.168.1.252/index.php/Login/validate';
$postData = array(
    'username' => 'admin',
    'password' => 'Q!W@E#R$'
);

$header = array(
    'Host: 192.168.1.252',
    'Referer: http://www.8.com',
    'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36'
);

$saveCookieFile = __DIR__ . '/curlPage.cookie.txt';
if(file_exists($saveCookieFile)) { @unlink($saveCookieFile); }

// $cookieGetFile = file_get_contents($saveCookieFile);
$opts = array( CURLOPT_FOLLOWLOCATION => 1, CURLOPT_HEADER => 0, CURLOPT_RETURNTRANSFER=>0 );

// 1.登录
$data = curlPage($url, $postData, $header, $opts, $saveCookieFile);

$url = 'http://192.168.1.252/index.php';
$postData = array();
$header = array();
$opts = array();

// 2.登录后的页面
$data = curlPage($url, $postData, $header, $opts, '', $saveCookieFile);

echo '<pre>';
var_dump($data);