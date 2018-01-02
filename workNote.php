<?php
/**
 * 1��json_decode() ���� NULL ԭ�򣬼�������
 * 2017-4-7 10:07 Chineon
 *
 * json_decodeҪ����ַ����Ƚ��ϸ�
 * 1. ʹ��UTF-8����
 * 2. ���������Ԫ���ж���
 * 3. ����ʹ�õ�����
 * 4. �����з�б��
 */
    json_last_error();               # ���4 �﷨����
    htmlspecialchars_decode($json);  # ���� json �ַ����з�б�ܱ�ת��

    # ���ⷴб��ת����ɵ��޷�����
    urlencode(json_encode($json));  # ���ʱ��Ajaxʹ�� JSON.stringify() ��json����ת���� json �ַ���
    urldecode($json);               # ����ʱ

    json_decode($json, true);       # ��������

    # PHP�е�����ǿ��ת���� C �еķǳ�����Ҫת���ı���֮ǰ������������������Ŀ�����͡�
    (int)$str;  (bool)$str;  (float)$str;  (string)$str;  (array)$str;  (object)$str;

    Sublime Text3 ʹ�ÿ�ݼ�[Ctrl + N]�½��ļ������´򿪣��ļ���ʽΪ[ASCII] 2017-12-19

/**
 * 2��MySQL�ж���������ң�FIND_IN_SET() ��ȷƥ��
 * ��������ƥ���ֶ�`to_id`��ֵ�����á����š�����
 * 2017-4-7 16:37
 */
    # MySQL�� find_in_set �� in��like������in �൱�ڶ�� or ���ӡ�like ģ��ƥ�䡣
    $sql = 'SELECT * FROM `notify` WHERE ((FIND_IN_SET("'.$group_id.'",`to_id`)>0 AND `type`=1) OR (FIND_IN_SET("'.$uid.'",`to_id`)>0 AND `type`=2)) AND `status`>0';

/*
    MySQL����ϵͳ�������ռ䲻����������,����ִ���׽����ϵĲ���:

    ������ȷ�� TCP/IP ���ͷ��ѹرյ����Ӳ��ٴ�ʹ������Դǰ���뾭����ʱ�䡣�ر����ͷ�֮������ʱ���Ϊ TIME_WAIT ״̬�����������������ڣ�2MSL��״̬��

    ����DOS����:
    netstat -an | find /C "TIME_WAIT"
    ��鵱ǰ�ж��ٸ������TCP����:
    netstat -an | find /C "TCP"

    Mysql������Ĭ�ϵġ�wait_timeout����8Сʱ��Ҳ����Ĭ�ϵ�ֵĬ����28800�롿
    wait_timeout�����б׶ˣ������־���MySQL�������SLEEP�����޷���ʱ�ͷţ�����ϵͳ����
    mysql> set global wait_timeout=10;
    mysql> show global variables like 'wait_timeout';

    # �༭���ύ�ı�ʱ��ת��������������鿴Ч��������
    htmlspecialchar()������htmlentities()�������ƶ��ǰ�html����ת����htmlspecialchars_decode�ǰ�ת����html�ı���ת����ת��������
    ���ۣ�htmlentities �� htmlspecialchars ���������� htmlentities ��ת�����е� html character entity����htmlspecialchars ֻ��ת���ֲ����г��ļ��� html character entity ��Ҳ���ǻ�Ӱ�� html �������Ǽ��������ַ�����һ����˵��ʹ�� htmlspecialchars ת���������ַ����Ѿ��㹻�ˣ�û�б�Ҫʹ�� htmlentities��ʵ��Ҫʹ�� htmlentities ʱ��Ҫע��Ϊ����������������ȷ�ı��롣
    $data['note'] = htmlentities($this->request->post('note'), ENT_COMPAT, 'utf-8'); //ת��ʵ��

    MySQL��������int��tinyint��float��decimal���ѡ��
    ��������֪���������ʹ�õ���0��1���������ƣ�ʹ�ö����Ʊ�ʾ������ʮ�����׵�һ�����顱��
    ���Ҫ��ʮ���Ƶ�0.1ת��Ϊ������С����������1100ѭ����״����

    �ڱ����Ӧ�����������������ıȽϣ�������ܻᵼ��һЩǱ�ڵ����⡣
    ���������ʹ��floatȥ��money��ʹ��decimal�������ף���ʹ��decimal���������ɻ���������ͣ�������������뿼��ʹ�����ͣ����ҵ�λʹ�� �� �����߳����������С�
*/
    trim()����ɾ�������ַ������BUG 2017-4-17+++++++++++++++++++++++++++
    // $country = trim($country_tmp, '��');
    $country = trim($country_tmp, ',');
    $country = str_replace(',', '��', $country);


    MySQL �������������롮����������, ��explain��

    #ȥ������ո�
    $title = preg_replace('/\s\s+/', ' ', $title);

    #ɾ���ո�ͻس�
    function trimall($str){
        $qian=array(" ","��","\t","\n","\r");
        return str_replace($qian, '', $str);
    }

    #ɾ�����з�
    str_replace("\r\n","",string);

    #ȥ������Ļ��з�
    $detail = strip_tags(str_replace( array("\n","<br/>","<br />","\r","<p>","<li>","</p>"), "\n", $detail ));
    $detail = preg_replace("/\n\n+/", "\n", $detail); #ȥ������Ļ��з�


/**
 * 3��Web��̨ʹ��ɨ��ǹ��ɨ����Ʒ��ά�룬�Զ���ӡ��ݵ�
 * @date 2017-08-16 17:35
 */
    // lodop��Ϊ����ʹ����㷺��һ��WEB��ӡ�ؼ������С����ȴ�൱ǿ�󣬴򱨱������롢ͼ��ȡ�

    // ɨ��ǹ����һ��ͨ������ˣ���������ơ����ѹ�꽹��ŵ�һ�������ʱ��ɨ��ǹɨ�赽һ����Ϊ��86142345��ʱ���������ͻ���ʾΪ��86142345������Ȼ�����趨ɨ��ǹ������������������൱�ڼ��̵ġ��س��������������Ϳ����Զ��ύ�ˡ�

/**
 * 4��MySQL���ݿ����ռ�ÿռ��Сͳ��
 * @date 2017-08-29 15:29
 */
    #a.�鿴�����ݿ�ռ�ô��̿ռ�
    SELECT `table_schema`, CONCAT(TRUNCATE(SUM(`data_length`)/1024/1024,2),' MB') AS `data_size`,
        CONCAT(TRUNCATE(SUM(`index_length`)/1024/1024,2),' MB') AS `index_size`
        FROM `information_schema`.tables
        GROUP BY `table_schema`
    ORDER BY SUM(`data_length`) DESC;

    #b.�鿴���ݿ� `erp` �и����ݱ��ռ�ÿռ�
    SELECT `table_name`, `table_rows`, CONCAT(TRUNCATE(`data_length`/1024/1024,2),' MB') AS `data_size`,
        CONCAT(TRUNCATE(`index_length`/1024/1024,2),' MB') AS `index_size`
        FROM `information_schema`.tables WHERE `table_schema`='erp'
        GROUP BY `table_name`
    ORDER BY `data_length` DESC;

    #c.�鿴���ݿ� `erp` ��ָ�����ռ�ÿռ�
    SELECT `table_name`, `table_rows`, CONCAT(TRUNCATE(`data_length`/1024/1024,2),' MB') AS `data_size`,
        CONCAT(TRUNCATE(`index_length`/1024/1024,2),' MB') AS `index_size`
        FROM `information_schema`.tables WHERE `table_schema`='erp' AND `table_name`='erp_wish_listing'
        GROUP BY `table_name`
    ORDER BY `data_length` DESC;


/**
 * 5��MySQL��ѯ���ݱ���ֶ���Ϣ[�����ֶ�ӳ��]
 * @date 2017-09-04 12:19
 */
    #information_schema������һ����ΪCOLUMNS�ı�������м�¼�����ݿ������б���ֶ���Ϣ
    SELECT `COLUMN_NAME` FROM information_schema.`COLUMNS` WHERE `TABLE_SCHEMA`='erp' AND `TABLE_NAME`='sys_order'


/**
 * 6��PHP SOAP���͵Ľӿ�
 * @date 2017-09-13 14:59
 */

// [��ע��XML�еģ�i:nil="true"����ʾ��ǩֵΪ��null��]
$client = new SoapClient('https://wsvc.cdiscount.com/MarketplaceAPIService.svc?wsdl');
var_dump($client);

/*php��soap ��ʹ��ʵ��������дWSDL�ļ����ṩ�Զ�����WSDL�ļ���
http://www.cnblogs.com/phpdragon/archive/2012/06/10/2544171.html
�������������ʹ�õ��˽ӿڣ�
����ϵͳ�ӿڣ�
���½Ӵ��������֣�

1��URL���͵Ľӿ�
URL·�ɴ�����ʽ�Ľӿڣ�����ܺ�����ֻҪ�й�Web����������˶�����ɣ�
���ֽӿ����ݲ��������ԣ�����ֱ����������п�����

��֧�����Ľ�������URL����Ҫ��һ��MD5ǩ�����ͷ������˵��ٴ���֧����������������֤��
��Ȼsoap��ʽ���ݵ����������Ժܺ�!��Ϊ�����ݰ�ȫ������Ҳ��Ҫ��������ǩ����

2��SOAP���͵Ľӿ�
�޹ر�����ԡ��޹�ƽ̨����չ�Ժܺ�
Ҫʵ��һ��SOAP �͵Ľӿڣ������ַ�ʽ��һ����WSDL�ļ���ʽ��һ����WSDL�ļ���ʽ��

�����Ȱ��о��͵�����˵,ʹ�õ�һ�ַ�ʽ��������������˽�PHP����ô������һ��Web Service��
����һ�ֶ���������˵������һ��XML��ʽ��WSDL�ļ����ǱȽ��ѵģ���������˽���Ϥʲô��XML��
ѧ��XML�﷨��
  ������һ�����ڽ�����������˵��û����ô���ʱ��ȥ��Ϥ���������Ǽ����յ��£�
��������������˵�ˣ�����һ������WSDL�ļ��ķ�ʽ�����ң������⻹�ṩ��һ���Զ�����WSDL�ļ����࣡

����ǰ����������PHP��soap����֧�֣��ҵ�php.ini�ļ�
��extension=php_soap.dll
ɾ����"��" ������apache������*/

/**
 * 7��JS ȫѡ/��ѡ[���ؼ�]
 * @date 2017-09-21 15:59
 */
$(".checkAll").on("click", function(){
    $(".checkItem").each(function(i){
        this.checked = $(this).is(":checked") ? false : true;
    });
});

/**
 * 8��MySQL �Ƚ������ֶε�ʱ��� [����ʱ����ഴ��ʱ�䳬��28��]
 * https://wenku.baidu.com/view/ad6d5415f242336c1eb95eae.html
 * MySQL ���ݿ�Ҫ�����졢���졢ǰ���ա�����ʮ�졢���ȡ����ѯ
 * @date 2017-09-23 10:40
 */
SELECT COUNT(*) FROM `erp_distribute_ebay_listing` WHERE `status`=3 AND account_id!=7 AND TO_DAYS(`publish_start_date`) - TO_DAYS(`create_date`) > 28;


/**
 * 9��MySQL �����������ѯ�Ż����������������������Լ�����ǰ׺ԭ��
 * @date 2017-10-19 15:45
 */
    #�������������������
    ALTER TABLE `erp`.`erp_ebay_v2_listing` ADD INDEX `ebay_status` (`id`, `ebay_status`);

    #ȥ��[distinct]
    SELECT COUNT(DISTINCT(a.`listing_id`)) AS `count` FROM `erp_products_status_listing_log` a

    #ɸѡ�ظ���¼[group by .. having ..]
    SELECT *,COUNT(*) cc FROM `erp_products_status_log` WHERE `status`=0 GROUP BY `product_id` HAVING cc>1

/**
 * 10��MySQL ���ֱ�����䡾SELECT INTO �� INSERT INTO SELECT��
 * @date 2017-10-20 9:45
 */
    # 1.INSERT INTO SELECT���
    # �����ʽΪ��Insert into Table2(field1,field2,...) select value1,value2,... from Table1
    # Ҫ��Ŀ���Table2������ڣ�����Ŀ���Table2�Ѿ����ڣ����˲���Դ��Table1���ֶ��⣬�����Բ��볣����
    INSERT INTO `erp_ebay_seller_events_task`(`account_id`) SELECT `id` FROM `erp_basics_account` WHERE `platform_id`=2;

    # 2.SELECT INTO FROM���
    # �����ʽΪ��SELECT vale1, value2 into Table2 from Table1
    # Ҫ��Ŀ���Table2�����ڣ���Ϊ�ڲ���ʱ���Զ�������Table2������Table1��ָ���ֶ����ݸ��Ƶ�Table2�С�

    # 3.���ƶ����ֶε�ͬһ������Ҫע�����Ƕ�ײ�ѯ�������һ��Ҫ�����ñ����[`tb`]��
    INSERT INTO a (field1,field2) SELECT * FROM(SELECT b.f1,c.f2 FROM b JOIN c) AS tb;

/**
 * 11��ִ�� PHP �ű�����ʱ��ʹ�� JS �Զ�ˢ��ҳ��
 * @date 2017-10-25 16:07
 */
    echo '��ǰϵͳʱ�䣺' . date('Y-m-d H:i:s');
    #<!-- JS ҳ���Զ�ˢ�� -->
    echo '<script type="text/javascript">';
    echo     'setTimeout("window.location.reload()", 100);';
    echo '</script>';


/**
 * 12��UPDATE from SELECT
 * @date 2017-10-30 18:17
 */
    "UPDATE `erp_products_status_listing_log` c SET c.`status`=33
            WHERE c.id IN (SELECT d.id FROM
                (SELECT a.id FROM `erp_products_status_listing_log` a
                    JOIN erp_ebay_v2_listing b ON a.`listing_id` = b.`id`
                    WHERE a.platform_id=2 AND a.`status`=0 AND a.`type` IN (2) AND b.Quantity>0) d
            )";

    # �����ѯ[����������2017-11-17]
    "UPDATE `erp_ebay_order_profit_log` a JOIN `erp_ebay_order_profit_log` b ON a.`id`=b.`id` SET a.`profit_rate`=ROUND(b.`profit`/b.`shipping_min_price`*1000)";

    #MySQL��һ���������һ����
    # �޸�1��
        "UPDATE `student` s, `city` c SET s.`city_name` = c.`name` WHERE s.`city_code` = c.`code`";
    # �޸Ķ����
        "UPDATE a, b SET a.`title`=b.`title`, a.`name`=b.`name` WHERE a.`id`=b.`id`";
    # �����Ӳ�ѯ
        "UPDATE `erp_ebay_v2_listing` a SET a.`QC_profit` = (SELECT MIN(b.`QC_profit`) FROM `erp_ebay_v2_listing_variation` b WHERE a.`id`=b.`listing_id` AND b.`QC_rate` IS NOT NULL)";


/**
 * 13�������ȼ��Զ��ֲ�--ƥ��ֲֹ���BUG
 * @date 2017-11-21 14:15
 */
    #1) empty() �����ж� '0.00' �Ƿ�Ϊ�ա�
    #2) ���õݹ鷽��ʱ�������ڷ���ǰ�� ��return�� �����ݹ顣


/**
 * 14���ۼ۾�ȷ����[����ĩβ�ġ�0��]
 * @date 2017-11-27 16:16
 */
    sprintf('%.2f', round($salesPrice, 2));

    $num = 5;  $location = 'tree';
    $format = 'There are %d monkeys in the %s';
    echo sprintf($format, $num, $location);


/**
 * 15������������[�Լ۸�Ϊ����]
 * @date 2017-11-30 11:16
 */
    $price_sum = $this->priceCount($weight, $val);
    $key_sort = str_pad($price_sum*100, 8, '0', STR_PAD_LEFT) .'_'. $key;
    $priceListSort[$key_sort]['price_sum'] = $price_sum;
    ksort($priceListSort);  //����������



/**
 * 16��ʹ�� URL ���������������
 * @date 2017-12-11 15:13
 */
# http://localhost/test.php?id=1&pid[]=2&pid[]=5&pid[]=8
# array(2) { ["id"]=> string(1) "1" ["pid"]=> array(3) { [0]=> string(1) "2" [1]=> string(1) "5" [2]=> string(1) "8" } }



/**
 * 17���������ڲ� -- POST��ʽ�л�[����]
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
 * 18��Failed to execute 'getComputedStyle' on 'Window':
 * @date 2017-12-14 15:53
 */
/*
<!-- ��������[���ܷ���html��ǩ����] -->
<?php if ($this->key=="variant"){ ?>
    <html>
        ...
        $("#winEdit").window({
            //title:'Wish���ݵ���',
            closed:false,
            width:$(data).width(),  //BUG��'getComputedStyle'��
            shadow:false,
            minimizable:false,
            maximizable:false
        });
    </html>
<?php }?>
 */


/**
 * 19��Bootstrap ��ǩҳ��Tab��
 * @date 2017-12-14 16:53
 */
    /*
        <tr>
            <td  align="right">SKU</td>
            <!-- Tab��ǩҳ -->
            <td><ul id="myTab" class="nav nav-tabs">
                <?php foreach($this->attr as $k=>$v){?>
                    <li <?if($k==0){?>class="active"<?}?>><a href="#Tab-<?=$v['id']?>" data-toggle="tab"><?=$v['sku']?></a></li>
                <?php }?>
            </ul></td>
        </tr>
        <tr>
            <td  align="right">����</td>
            <!-- Tab��ǩҳ-���� -->
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
 * 20��Bootstrap ������Popover���������
 * @date 2017-12-22 18:05
 */
    .popover { max-width:800px; }  #Ĭ��������� 275px