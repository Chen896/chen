<?php
include('Signfork.class.php');

class test
{
    function __fork($arg)
    {
        return file_get_contents($arg);
    }
}

$limit      =microtime(true);
$test       =new test();
$Signfork   =new Signfork();



$arg=array(
'http://yahoo.com',
'http://baidu.com',
'http://google.com',
'http://qq.com',
'http://163.com',
'http://sina.com'
);


$Signfork->run($test,$arg);
echo 'Run time:'.(microtime(true)-$limit); //Run time:1.7930409908295