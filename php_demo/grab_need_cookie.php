<?php
set_time_limit(0);


/**
 * 功能：抓取网页内容时，需要Cookie参数
 * 应用场景：抓取eBay热卖Item，Shipping and handling选择China时【Cookie保存】，卖家的Items for sale不可见
 * @date 2017-08-12
 */
$url = 'https://www.ebay.com/sch/i.html?_ssn=seattle2003&LH_BIN=1&LH_ItemCondition=1000&LH_Sold=1&_udlo=8&_udhi=120&_nkw=Toy&_sacat=220&LH_PrefLoc=2&LH_FS=1&LH_RPA=1';

$cookie = 'nonsession=BAQAAAV3TvYE1AAaAAAgAHFm1/sQxNTAyNTA3NDYweDI1Mjg3ODM1MTg3NHgweDJOADMABFtvpUQsVVNBAMsAAlmOeMwzOADKACBi9HNEN2Q4MjMwNDExNWQwYTk5YmI3NTJkNzAzZmZhM2Q1NTaEqI1h9HhHdG8fsBpS2uhHCFSiag**';

$web = grabByFileGetContents($url, $cookie);
// $web = grabByCurl($url, $cookie);

print_r($web);

/**************************************************************************************************
 * 1）file_get_contents传递Cookie
 * 备注：请求头标明不支持gzip等【Accept-Encoding:gzip, deflate】格式返回，避免解析抓取内容
 */
function grabByFileGetContents($url, $cookie)
{
    $opt = array(
        #忽略SSL验证【http://php.net/manual/en/migration56.openssl.php】
        'ssl' => array(
            'verify_peer'      => false,
            'verify_peer_name' => false,
        ),
        'http' => array(
            'method' => 'GET',
            'header' => "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8\r\n" . "Cache-Control:no-cache\r\n" . "Cookie:" . $cookie . "\r\n"

            # 模拟浏览器请求2017-08-22
            ."User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36\r\n"
        )
    );

    $html = file_get_contents($url, false, stream_context_create($opt));
    return $html;
}

/**************************************************************************************************
 * 2）curl传递Cookie
 */
function grabByCurl($url, $cookie)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);

    $html = curl_exec($ch);
    curl_close($ch);

    return $html;
}