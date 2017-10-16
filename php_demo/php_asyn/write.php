<?php
/**
 * 既方便网站程序错误调试，又不影响网站的正常运行的调试方法
 */
ini_set('error_reporting', E_ALL);  //显示所有错误信息
ini_set('display_errors', 0);       //禁止将错误信息输出到输出端
ini_set('log_errors', On);               //开启错误日志记录
ini_set('error_log', 'C:/php_log.txt');  //定义错误日志存储位置


/**
 * PHP 异步执行方法，模拟多线程
 * @应用场景：每当发表了一篇新日志后需要给所有该日志的订阅者发个邮件通知
 * 【同步sync】日志写完 -> 点提交按钮 -> 日志插入到数据库 -> 发送邮件通知 -> 告知撰写者发布成功（可能会等待很长时间）
 * 【异步asyn】日志写完 -> 点提交按钮 -> 日志插入到数据库 ---> 告知撰写者发布成功 ---> 发送邮件通知 -> [记下日志]
 * 【程序测试】有两个文件分别是 write.php 和 sendmail.php，在 sendmail.php 用 sleep(seconds) 来模拟程序执行所使用时间。
 * $url = '/Chen/workNote/php_asyn/sendmail.php?param=1'; #请求的资源URL
 * @date 2017-6-13
 */
function asyn_sendmail($host, $url='/', $port=80)
{
    # fsockopen是一个非常强大的函数，支持socket编程，可以使用fsockopen实现邮件发送等socket程序
    $fp = fsockopen($host, $port, $errno, $errstr, 5);
    if(!$fp){
        echo $errstr.'【'.$errno.'】<br/>';
    }

    sleep(1);

    $out = "GET $url HTTP/1.1\r\n";
    $out.= "Host: $host\r\n";
    $out.= "Connection: Close\r\n\r\n";
    fputs($fp, $out);  #可用 feof() 函数调试错误

    // while (!feof($fp)) {
    //     echo fgets($fp, 128);
    // }
    fclose($fp);
}


echo time().'<br>';
echo 'call asyn_sendmail<br>';

asyn_sendmail('localhost', '/Chen/workNote/php_asyn/sendmail.php?param=1');
echo time().'<br>';


#-------------------------------------------------------
#利用fsockopen去访问url，但是在访问时，并不要求获取url显示的内容，而是仅仅发出访问请求，请求到达后马上关闭这个访问。这样做的好处就是无需再等待被访问的url是否返回了可靠的信息，节约了时间，这段代码的执行时间在0.1-0.2秒之间。
#
#除了fsockopen，curl其实也可以实现这样的效果，有些主机上并不支持fsockopen，我们就可以使用curl来实现。
#-------------------------------------------------------
function _curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1); #curl发出请求，无论是否接收到返回的内容，1秒钟后关闭该访问

    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}