<?php

/**
 * 既方便网站程序错误调试，又不影响网站的正常运行的调试方法
 */
ini_set('error_reporting', E_ALL);  //显示所有错误信息
ini_set('display_errors', 0);       //禁止将错误信息输出到输出端
ini_set('log_errors', On);               //开启错误日志记录
ini_set('error_log', 'C:/php_log.txt');  //定义错误日志存储位置


/**
 * PHP 异步执行方法，模拟多线程【异步发送邮件】
 * @date 2017-6-13
 */
sleep(10); #模拟发送邮件的处理时间
file_put_contents('./sendmail.txt', date('Y-m-d H:i:s').PHP_EOL, FILE_APPEND);

fopen("", "w");  #测试错误日志