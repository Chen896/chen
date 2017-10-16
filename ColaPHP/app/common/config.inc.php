<?php

# 配置文件
$config = array(
    '_urls' => array(
        '/^view\/?(\d+)?\/?(\d+)?$/' => array(
            'controller' => 'IndexController',
            'action' => 'indexAction',
            'maps' => array(
                1 => 'id',
                2 => 'page'
            ),
            'defaults' => array(
                'id' => 9527,
                'page'=> 1,
            )
        ),
        '/^v-?(\d+)?$/' => array(
            'controller' => 'IndexController',
            'action' => 'indexAction',
            'maps' => array(
                1 => 'id'
            ),
            'defaults' => array(
                'id' => 9527
            )
        )
    ),
    '_cache'=>array(
        'memcache'=>array(
                'adapter' => 'Memcached',
                'servers'=>array(
                        array('127.0.0.1', 11211, 100)
                        ),
        ),
        'redis'=>array(
                'adapter' => 'Redis','host'=>'127.0.0.1','port'=>6379,'timeout'=>3,
                'persistent' => 0,'ttl'=>600
        )
    ),
    '_log' => array(
            'FileLog'=>array(
                            'adapter'=>"File",
                            'mode' => '0755',
                            'file' => '/Users/kang/Documents/phpProject/otherproject/colaphp/app/Cola.log',
                            ),

    ),


    '_db' => array(
        'adapter' => 'Mysqli',
        'params' => array(
            'host' => '127.0.0.1',
            'port' => 3306,
            'user' => 'root',
            'password' => '123456',
            'database' => 'test',
            'charset' => 'utf8',
            'persitent' => true
        )
    ),

    '_appHome'         => APP_PATH,
    '_modelsHome'      => APP_PATH.DIRECTORY_SEPARATOR.'common/model',
    '_controllersHome' => APP_PATH.DIRECTORY_SEPARATOR.B_MODULE.'/controller',
    //'_viewsHome'       => APP_PATH.DIRECTORY_SEPARATOR.B_MODULE.'/view'
);