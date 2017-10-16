<?php

// php异步调试和线上调试网站程序的方法
// 当碰到一个网站需要不间断运行，但又需要调试该网站的程序错误的时候，该如何办呢？是靠经验一点点猜测，还是直接打印错误信息让其在页面输出？
// 下面分享一种方法同时满足这两种条件，既方便网站程序错误调试，又不影响网站的正常运行的调试方法。将下面的php语句复制到公共代码顶部


//ini_set('error_reporting',E_ALL ^ E_NOTICE);//显示所有除了notice类型的错误信息
ini_set('error_reporting', E_ALL);//显示所有错误信息
ini_set('display_errors', 0);//禁止将错误信息输出到输出端
ini_set('log_errors', On);//开启错误日志记录
ini_set('error_log', 'C:/phpernote');//定义错误日志存储位置

// 另外附加两句比较常用的排除错误信息的PHP语句：
@ini_set('memory_limit', '500M');//设置程序可占用最大内存为500MB
@ini_set('max_execution_time', '180');//设置允许程序最长的执行时间为180秒