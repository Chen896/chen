<?php
/**
 * 1）json_decode() 返回 NULL 原因，及处理方法
 * 2017-4-7 10:07 Chineon
 *
 * json_decode要求的字符串比较严格：
 * 1. 使用UTF-8编码
 * 2. 不能在最后元素有逗号
 * 3. 不能使用单引号
 * 4. 不能有反斜杠
 */
    json_last_error();               # 输出4 语法错误
    htmlspecialchars_decode($json);  # 处理 json 字符串中反斜杠被转义

    # 避免反斜杠转义造成的无法解析
    urlencode(json_encode($json));  # 输出时；Ajax使用 JSON.stringify() 把json对象转换成 json 字符串
    urldecode($json);               # 接收时

    json_decode($json, true);       # 返回数组

    # PHP中的类型强制转换和 C 中的非常像：在要转换的变量之前加上用括号括起来的目标类型。
    (int)$str;  (bool)$str;  (float)$str;  (string)$str;  (array)$str;  (object)$str;

    Sublime Text3 使用快捷键[Ctrl + N]新建文件，重新打开，文件格式为[ASCII] 2017-12-19

/**
 * 2）MySQL中多条件组查找：FIND_IN_SET() 精确匹配
 * 条件：被匹配字段`to_id`的值必须用‘逗号’隔开
 * 2017-4-7 16:37
 */
    # MySQL中 find_in_set 与 in、like的区别：in 相当于多个 or 叠加、like 模糊匹配。
    $sql = 'SELECT * FROM `notify` WHERE ((FIND_IN_SET("'.$group_id.'",`to_id`)>0 AND `type`=1) OR (FIND_IN_SET("'.$uid.'",`to_id`)>0 AND `type`=2)) AND `status`>0';

/*
    MySQL由于系统缓冲区空间不足或队列已满,不能执行套接字上的操作:

    描述：确定 TCP/IP 在释放已关闭的连接并再次使用其资源前必须经过的时间。关闭与释放之间的这段时间称为 TIME_WAIT 状态或者两倍最大段生存期（2MSL）状态。

    运行DOS命令:
    netstat -an | find /C "TIME_WAIT"
    检查当前有多少个大概有TCP连接:
    netstat -an | find /C "TCP"

    Mysql服务器默认的“wait_timeout”是8小时【也就是默认的值默认是28800秒】
    wait_timeout过大有弊端，其体现就是MySQL里大量的SLEEP进程无法及时释放，拖累系统性能
    mysql> set global wait_timeout=10;
    mysql> show global variables like 'wait_timeout';

    # 编辑器提交文本时，转义后不能浏览器输出查看效果！！！
    htmlspecialchar()函数和htmlentities()函数类似都是把html代码转换，htmlspecialchars_decode是把转化的html的编码转换成转换回来。
    结论：htmlentities 和 htmlspecialchars 的区别在于 htmlentities 会转化所有的 html character entity，而htmlspecialchars 只会转化手册上列出的几个 html character entity （也就是会影响 html 解析的那几个基本字符）。一般来说，使用 htmlspecialchars 转化掉基本字符就已经足够了，没有必要使用 htmlentities。实在要使用 htmlentities 时，要注意为第三个参数传递正确的编码。
    $data['note'] = htmlentities($this->request->post('note'), ENT_COMPAT, 'utf-8'); //转义实体

    MySQL数字类型int与tinyint、float与decimal如何选择
    “众所周知，计算机中使用的是0和1，即二进制，使用二进制表示整数是十分容易的一件事情”。
    如果要将十进制的0.1转换为二进制小数，则会出现1100循环的状况。

    在编程中应尽量避免做浮点数的比较，否则可能会导致一些潜在的问题。
    坚决不允许使用float去存money，使用decimal更加稳妥，但使用decimal做除法依旧会产生浮点型，所以特殊情况请考虑使用整型，货币单位使用 分 ，或者除法在最后进行。
*/
    trim()函数删除中文字符引起的BUG 2017-4-17+++++++++++++++++++++++++++
    // $country = trim($country_tmp, '、');
    $country = trim($country_tmp, ',');
    $country = str_replace(',', '、', $country);


    MySQL ‘联合索引’与‘单列索引’, ‘explain’

    #去掉多余空格
    $title = preg_replace('/\s\s+/', ' ', $title);

    #删除空格和回车
    function trimall($str){
        $qian=array(" ","　","\t","\n","\r");
        return str_replace($qian, '', $str);
    }

    #删除换行符
    str_replace("\r\n","",string);

    #去掉多余的换行符
    $detail = strip_tags(str_replace( array("\n","<br/>","<br />","\r","<p>","<li>","</p>"), "\n", $detail ));
    $detail = preg_replace("/\n\n+/", "\n", $detail); #去掉多余的换行符


/**
 * 3）Web后台使用扫码枪，扫码商品二维码，自动打印快递单
 * @date 2017-08-16 17:35
 */
    // lodop作为现下使用最广泛的一款WEB打印控件，体积小功能却相当强大，打报表、条形码、图表等。

    // 扫描枪就是一普通的输入端，与键盘类似。当把光标焦点放到一个输入框时，扫描枪扫描到一条码为“86142345”时，此输入框就会显示为“86142345”，当然可以设定扫描枪在输入条码后，再输入相当于键盘的“回车键”，这样表单就可以自动提交了。

/**
 * 4）MySQL数据库磁盘占用空间大小统计
 * @date 2017-08-29 15:29
 */
    #a.查看各数据库占用磁盘空间
    SELECT `table_schema`, CONCAT(TRUNCATE(SUM(`data_length`)/1024/1024,2),' MB') AS `data_size`,
        CONCAT(TRUNCATE(SUM(`index_length`)/1024/1024,2),' MB') AS `index_size`
        FROM `information_schema`.tables
        GROUP BY `table_schema`
    ORDER BY SUM(`data_length`) DESC;

    #b.查看数据库 `erp` 中各数据表的占用空间
    SELECT `table_name`, `table_rows`, CONCAT(TRUNCATE(`data_length`/1024/1024,2),' MB') AS `data_size`,
        CONCAT(TRUNCATE(`index_length`/1024/1024,2),' MB') AS `index_size`
        FROM `information_schema`.tables WHERE `table_schema`='erp'
        GROUP BY `table_name`
    ORDER BY `data_length` DESC;

    #c.查看数据库 `erp` 中指定表的占用空间
    SELECT `table_name`, `table_rows`, CONCAT(TRUNCATE(`data_length`/1024/1024,2),' MB') AS `data_size`,
        CONCAT(TRUNCATE(`index_length`/1024/1024,2),' MB') AS `index_size`
        FROM `information_schema`.tables WHERE `table_schema`='erp' AND `table_name`='erp_wish_listing'
        GROUP BY `table_name`
    ORDER BY `data_length` DESC;


/**
 * 5）MySQL查询数据表的字段信息[便于字段映射]
 * @date 2017-09-04 12:19
 */
    #information_schema库中有一个名为COLUMNS的表，这个表中记录了数据库中所有表的字段信息
    SELECT `COLUMN_NAME` FROM information_schema.`COLUMNS` WHERE `TABLE_SCHEMA`='erp' AND `TABLE_NAME`='sys_order'


/**
 * 6）PHP SOAP类型的接口
 * @date 2017-09-13 14:59
 */

// [备注：XML中的（i:nil="true"）表示标签值为‘null’]
$client = new SoapClient('https://wsvc.cdiscount.com/MarketplaceAPIService.svc?wsdl');
var_dump($client);

/*php中soap 的使用实例无需手写WSDL文件，提供自动生成WSDL文件类
http://www.cnblogs.com/phpdragon/archive/2012/06/10/2544171.html
最近工作的内容使用到了接口！
对于系统接口：
现下接触的有两种！

1、URL类型的接口
URL路由带参数式的接口！这个很好做！只要有过Web开发经验的人都能完成！
这种接口数据不够隐蔽性，可以直接在浏览其中看到，

如支付宝的交易请求URL。需要加一个MD5签名，和服务器端的再次向支付宝服务器发送验证！
虽然soap方式传递的数据隐蔽性很好!但为了数据安全，难免也需要进行数据签名。

2、SOAP类型的接口
无关编程语言、无关平台、扩展性很好
要实现一个SOAP 型的接口，有两种方式：一种有WSDL文件方式、一中无WSDL文件方式！

对于热爱研究型的人来说,使用第一种方式可以让你清楚的了解PHP是怎么创建了一个Web Service！
但第一种对于新手来说，创建一个XML格式的WSDL文件，是比较难的，这你的先了解熟悉什么是XML！
学会XML语法！
  但对于一个急于解决问题的人来说！没有这么多的时间去熟悉！所以这是件烦恼的事！
不过不急，上面说了，还有一种无需WSDL文件的方式！而且，本讲解还提供了一个自动生成WSDL文件的类！

讲解前，先配置下PHP的soap环境支持：找到php.ini文件
；extension=php_soap.dll
删除掉"；" ，重启apache服务器*/

/**
 * 7）JS 全选/反选[表单控件]
 * @date 2017-09-21 15:59
 */
$(".checkAll").on("click", function(){
    $(".checkItem").each(function(i){
        this.checked = $(this).is(":checked") ? false : true;
    });
});

/**
 * 8）MySQL 比较两个字段的时间差 [刊登时间相距创建时间超过28天]
 * https://wenku.baidu.com/view/ad6d5415f242336c1eb95eae.html
 * MySQL 数据库要按当天、昨天、前七日、近三十天、季度、年查询
 * @date 2017-09-23 10:40
 */
SELECT COUNT(*) FROM `erp_distribute_ebay_listing` WHERE `status`=3 AND account_id!=7 AND TO_DAYS(`publish_start_date`) - TO_DAYS(`create_date`) > 28;


/**
 * 9）MySQL 多条件联表查询优化【单例索引、多列索引以及最左前缀原则】
 * @date 2017-10-19 15:45
 */
    #添加索引【多列索引】
    ALTER TABLE `erp`.`erp_ebay_v2_listing` ADD INDEX `ebay_status` (`id`, `ebay_status`);

    #去重[distinct]
    SELECT COUNT(DISTINCT(a.`listing_id`)) AS `count` FROM `erp_products_status_listing_log` a

    #筛选重复记录[group by .. having ..]
    SELECT *,COUNT(*) cc FROM `erp_products_status_log` WHERE `status`=0 GROUP BY `product_id` HAVING cc>1

/**
 * 10）MySQL 两种表复制语句【SELECT INTO 和 INSERT INTO SELECT】
 * @date 2017-10-20 9:45
 */
    # 1.INSERT INTO SELECT语句
    # 语句形式为：Insert into Table2(field1,field2,...) select value1,value2,... from Table1
    # 要求目标表Table2必须存在，由于目标表Table2已经存在，除了插入源表Table1的字段外，还可以插入常量。
    INSERT INTO `erp_ebay_seller_events_task`(`account_id`) SELECT `id` FROM `erp_basics_account` WHERE `platform_id`=2;

    # 2.SELECT INTO FROM语句
    # 语句形式为：SELECT vale1, value2 into Table2 from Table1
    # 要求目标表Table2不存在，因为在插入时会自动创建表Table2，并将Table1中指定字段数据复制到Table2中。

    # 3.复制多表的字段到同一个表【需要注意的是嵌套查询部分最后一定要有设置表别名[`tb`]】
    INSERT INTO a (field1,field2) SELECT * FROM(SELECT b.f1,c.f2 FROM b JOIN c) AS tb;

/**
 * 11）执行 PHP 脚本任务时，使用 JS 自动刷新页面
 * @date 2017-10-25 16:07
 */
    echo '当前系统时间：' . date('Y-m-d H:i:s');
    #<!-- JS 页面自动刷新 -->
    echo '<script type="text/javascript">';
    echo     'setTimeout("window.location.reload()", 100);';
    echo '</script>';


/**
 * 12）UPDATE from SELECT
 * @date 2017-10-30 18:17
 */
    "UPDATE `erp_products_status_listing_log` c SET c.`status`=33
            WHERE c.id IN (SELECT d.id FROM
                (SELECT a.id FROM `erp_products_status_listing_log` a
                    JOIN erp_ebay_v2_listing b ON a.`listing_id` = b.`id`
                    WHERE a.platform_id=2 AND a.`status`=0 AND a.`type` IN (2) AND b.Quantity>0) d
            )";

    # 联表查询[更新利润率2017-11-17]
    "UPDATE `erp_ebay_order_profit_log` a JOIN `erp_ebay_order_profit_log` b ON a.`id`=b.`id` SET a.`profit_rate`=ROUND(b.`profit`/b.`shipping_min_price`*1000)";

    #MySQL用一个表更新另一个表
    # 修改1列
        "UPDATE `student` s, `city` c SET s.`city_name` = c.`name` WHERE s.`city_code` = c.`code`";
    # 修改多个列
        "UPDATE a, b SET a.`title`=b.`title`, a.`name`=b.`name` WHERE a.`id`=b.`id`";
    # 采用子查询
        "UPDATE `erp_ebay_v2_listing` a SET a.`QC_profit` = (SELECT MIN(b.`QC_profit`) FROM `erp_ebay_v2_listing_variation` b WHERE a.`id`=b.`listing_id` AND b.`QC_rate` IS NOT NULL)";


/**
 * 13）按优先级自动分仓--匹配分仓规则BUG
 * @date 2017-11-21 14:15
 */
    #1) empty() 不能判断 '0.00' 是否为空。
    #2) 调用递归方法时，忘记在方法前加 ’return‘ 结束递归。


/**
 * 14）售价精确到分[包含末尾的’0‘]
 * @date 2017-11-27 16:16
 */
    sprintf('%.2f', round($salesPrice, 2));

    $num = 5;  $location = 'tree';
    $format = 'There are %d monkeys in the %s';
    echo sprintf($format, $num, $location);


/**
 * 15）按键名排序[以价格为键名]
 * @date 2017-11-30 11:16
 */
    $price_sum = $this->priceCount($weight, $val);
    $key_sort = str_pad($price_sum*100, 8, '0', STR_PAD_LEFT) .'_'. $key;
    $priceListSort[$key_sort]['price_sum'] = $price_sum;
    ksort($priceListSort);  //按键名排序



/**
 * 16）使用 URL 向服务器传递数组
 * @date 2017-12-11 15:13
 */
# http://localhost/test.php?id=1&pid[]=2&pid[]=5&pid[]=8
# array(2) { ["id"]=> string(1) "1" ["pid"]=> array(3) { [0]=> string(1) "2" [1]=> string(1) "5" [2]=> string(1) "8" } }



/**
 * 17）控制器内部 -- POST方式切换[方法]
 * @date 2017-12-12 15:53
 */
 echo "<form style='display:none;' id='form1' name='form1' method='post' action='{$url}'>
  <input name='pid' type='text' value='{$pData['id']}'/>
  <input name='ShopeeSysSiteId' type='text' value='30'/>
  <input name='ShopeeCateId' type='text' value='{$cate_id_MY}'/>
  <input name='has_multi_attr' type='text' value='1'/>
  <input name='need_group' type='text' value='0'/>
  </form>
<script type='text/javascript'>function load_submit(){document.form1.submit()}load_submit();</script>";


/**
 * 18）Failed to execute 'getComputedStyle' on 'Window':
 * @date 2017-12-14 15:53
 */
/*
<!-- 变体属性[不能放在html标签外面] -->
<?php if ($this->key=="variant"){ ?>
    <html>
        ...
        $("#winEdit").window({
            //title:'Wish数据导入',
            closed:false,
            width:$(data).width(),  //BUG【'getComputedStyle'】
            shadow:false,
            minimizable:false,
            maximizable:false
        });
    </html>
<?php }?>
 */


/**
 * 19）Bootstrap 标签页（Tab）
 * @date 2017-12-14 16:53
 */
    /*
        <tr>
            <td  align="right">SKU</td>
            <!-- Tab标签页 -->
            <td><ul id="myTab" class="nav nav-tabs">
                <?php foreach($this->attr as $k=>$v){?>
                    <li <?if($k==0){?>class="active"<?}?>><a href="#Tab-<?=$v['id']?>" data-toggle="tab"><?=$v['sku']?></a></li>
                <?php }?>
            </ul></td>
        </tr>
        <tr>
            <td  align="right">标题</td>
            <!-- Tab标签页-内容 -->
            <td><div id="myTabContent" class="tab-content">
                <?php foreach($this->attr as $k2=>$v2){?>
                    <div class="tab-pane fade <?if($k2==0){?>in active<?}?>" id="Tab-<?=$v2['id']?>">
                        <input name="title[]" style="width:500px;" class="form-control" type="text" value="<?=$v2['title']?>">
                    </div>
                <?php }?>
            </div></td>
        </tr>
     */



/**
 * 20）Bootstrap 弹出框（Popover）宽度限制
 * @date 2017-12-22 18:05
 */
    .popover { max-width:800px; }  #默认最多宽度是 275px



/**
 * 21）HTTP中GET与POST的区别
 * @date 2018-01-05 16:49
 */
    /*
    GET和POST还有一个重大区别，简单的说： GET产生一个TCP数据包；POST产生两个TCP数据包。

    对于GET方式的请求，浏览器会把http header和data一并发送出去，服务器响应200（返回数据）；
    而对于POST，浏览器先发送header，服务器响应100 continue，浏览器再发送data，服务器响应200 ok（返回数据）。

    也就是说，GET只需要汽车跑一趟就把货送到了，而POST得跑两趟，第一趟，先去和服务器打个招呼“嗨，我等下要送一批货来，你们打开门迎接我”，然后再回头把货送过去。

    因为POST需要两步，时间上消耗的要多一点，看起来GET比POST更有效。因此Yahoo团队有推荐用GET替换POST来优化网站性能。但这是一个坑！跳入需谨慎。为什么？
    1. GET与POST都有自己的语义，不能随便混用。
    2. 据研究，在网络环境好的情况下，发一次包的时间和发两次包的时间差别基本可以无视。而在网络环境差的情况下，两次包的TCP在验证数据包完整性上，有非常大的优点。
    3. 并不是所有浏览器都会在POST中发送两次包，Firefox就只发送一次。
     */

/**
 * 22）CSS星号“*”的意义
 * @date 2018-01-11 09:21
 */
    *{padding:0; ... } #这里的“*”号是通配符，即指，网页html中所有标签意思。

    # bootstrap 描述：为元素指定的任何内边距和边框都将在已设定的宽度和高度内进行绘制。
    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }