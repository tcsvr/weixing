<?php 

class jssdk{
    public $access_token;
    public $api;
    public function __construct(){
        include('api.class.php');
        $this->api = new api();
        $this->api->appID = 'wx4d8082247e00e14f';
        $this->api->appsecret = '2cf126da803e48607520433466a420cb';
        $this->access_token = $this->api->get_access_token();
    }  
    public function signature(){//生成签名算法
        $noncestr = $this->get_noncestr();
        $time = time();
        $url = $this->get_url();
        $ticket = $this->get_jsapi_ticket();
        $tmpArr = [
            'noncestr='.$noncestr,
            'timestamp='.$time,
            'url='.$url,
            'jsapi_ticket='.$ticket
        ];
        sort($tmpArr,SORT_STRING);
        $tmpStr = implode($tmpArr,'&');
        $sign = sha1($tmpStr);
       // return $sign;
        return [
            'appId'=> $this->api->appID,
            'timestamp'=>$time,
            'nonceStr'=>$noncestr,
            'signature' =>$sign,
            'url' =>$url,
        ];
    }
    public function get_url(){
     return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER[ 'SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
    }   
    public function get_noncestr(){
        $noncestr = "akjsfhasfsd5fs4d5g4dfg43a4sd54654da5s4d56asddfg456g456df4g56d4";
        $str = '';
        for($i=0;$i<15;$i++){
           $str.= $noncestr[rand(0,strlen($noncestr)-1)];
        }
        return $str;
    }
    public function get_jsapi_ticket(){
        $time = time();
        //设计缓存文件名 catch/
        $filename = "catch/".md5($this->api->appID.$this->api->appsecret).'_ticket.txt';
        if (is_file($filename) && file_exists($filename) && (filectime($filename) + 7000) > $time) {
            //读缓存
            return file_get_contents($filename);
        } else {
            //   请求获取ticket接口
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$this->access_token}&type=jsapi";
            //用get 请求
            $ticket_json = $this->api->url_request($url);
            $ticket_arr = json_decode( $ticket_json, 1);
            $ticket = $ticket_arr['ticket'];
            file_put_contents($filename, $ticket);
            return $ticket;
            //重新请求
        }
        //========================
      //  echo  $this->api->url_request($url);
    }
}

// $sdk =new  jssdk();
// echo $sdk->signature();
//echo  $sdk-> get_url();
//echo $sdk->get_noncestr();

//LIKLckvwlJT9cWIhEQTwfOxVd6J1CAGcFNIsTUGlMrC5Q5yQkubVi74mVTFt5HTvTlkkQYdvT9lGMftVwr89VA

















?>