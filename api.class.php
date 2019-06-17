<?php
//curl php 模拟提交；
//$url = 'http://www.baidu.com';
//$url = 'http://wx.tcsvr.com/demo.php?a=1&b=2';
//$data =['a'=>'ssadasd'];
class api{
    public $appID;
    public $appsecret;
    public function get_access_token(){
        $time=time();
        //设计缓存文件名 /catch/
        $filename = "catch/".md5($this->appID.$this->appsecret).'_access_token.txt';
        if(is_file($filename) && file_exists($filename) && (filectime($filename)+7000)>$time){
            //读缓存
            return file_get_contents($filename);
        }else{
            //要拿自己的凭证 和秘钥 
            //   $appID='wx4d8082247e00e14f';
            //  $appsecret='2cf126da803e48607520433466a420cb';
            //请求获取access_token接口
            $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appID}&secret={$this->appsecret}";
            //用get 请求
            $access_json = $this->url_request($url);
            $access_arr = json_decode($access_json,1);
            $access_token = $access_arr['access_token'];
            file_put_contents($filename,$access_token);
            return $access_token;
            //重新请求
        }
    }
    public function url_request($url,$data=''){
//初始化 curl
        $ch = curl_init();
//设置 curl
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if($data){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        }
//执行 curl
        return curl_exec($ch);
//关闭 curl
        curl_close($ch);
    }
}
/*
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


*/




?>