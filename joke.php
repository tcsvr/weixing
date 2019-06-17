<?php
header("Content-Type:text/html;charset=UTF-8");
date_default_timezone_set("PRC");
$showapi_appid = '95170';  //替换此值,在官网的"我的应用"中找到相关值
$showapi_secret = '75fd6495acc844cd9063ff9c8c92a096';  //替换此值,在官网的"我的应用"中找到相关值
$paramArr = array(
    'showapi_appid' => $showapi_appid,
    'page' => "1",
    'maxResult' => "2"
    //添加其他参数
);


function url_request($url, $data = '')
{
    //初始化 curl
    $ch = curl_init();
    //设置 curl
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if ($data) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    //执行 curl
    return curl_exec($ch);
    //关闭 curl
    curl_close($ch);
}

//创建参数(包括签名的处理)
function createParam($paramArr, $showapi_secret)
{
    $paraStr = "";
    $signStr = "";
    ksort($paramArr);
    foreach ($paramArr as $key => $val) {
        if ($key != '' && $val != '') {
            $signStr .= $key . $val;
            $paraStr .= $key.'='.urlencode($val).'&';
        }
    }
    $signStr .= $showapi_secret; //排好序的参数加上secret,进行md5
    $sign = strtolower(md5($signStr));
    $paraStr .= 'showapi_sign='.$sign; //将md5后的值作为参数,便于服务器的效验
    echo "排好序的参数:".$signStr."\r\n";
    return $paraStr;
}

$param = createParam($paramArr, $showapi_secret);
$url = 'http://route.showapi.com/341-2?' . $param;
echo "请求的url:". $url."\r\n";
echo '<br>';
$result = url_request($url);
echo '<br>';
echo '<br>';

echo "返回的json数据:\r\n";
echo '<br>';
echo '<br>';

print $result . '\r\n';
echo '<br>';
echo '<br>';

$result = json_decode($result);
echo '<br>';
echo '<br>';

echo "\r\n取出showapi_res_code的值:\r\n";
echo '<br>';
echo '<br>';

print_r($result->showapi_res_code);
echo '<br>';
echo '<br>';

echo '<br>';
echo "\r\n";

/*
 {
	"showapi_res_code": 0,
	"showapi_res_error": "",
	"showapi_res_body": {
		"allNum": 2903,
		"allPages": 146,
		"contentlist": [
			{
				"ct": "2015-07-30 01:10:29.995",
				"img": "http://img5.hao123.com/data/3_2ec986ed8d235ebb3bd562ed5b782eb6_0",
				"title": "起来！就不~~~",
				"type": 2
			} 
		],
		"currentPage": 1,
		"maxResult": 20
	}
}
  */


?>