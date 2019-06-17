<?php 

class meau{

    public $access_token;
    public $api;
    public function __construct(){
        include('api.class.php');


        $this->api = new api();
        $this->api->appID = 'wx4d8082247e00e14f';
        $this->api->appsecret = '2cf126da803e48607520433466a420cb';
        $this->access_token = $this->api->get_access_token();

    }
    public function add_meau(){
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->access_token;
        //echo $url;
        $data = ' {
            "button":[
            {    
                "type":"click",
                "name":"今日歌曲",
                "key":"MUSIC"
            },
            {
                "type":"click",
                "name":"新闻",
                "key":"NEWS"
            },
            {
                "name":"菜单",
                "sub_button":[
                {    
                    "type":"view",
                    "name":"搜索",
                    "url":"http://www.baidu.com/"
                    },               
                {    
                    "type":"view",
                    "name":"天下士",
                    "url":"http://wx.tcsvr.com/jssdk.php"
                    },               
                    {
                    "type":"click",
                    "name":"赞一下我们",
                    "key":"ZAN"
                    }]
            }]
        }';


        $result = url_request($url, $data);
        var_dump($result);



    }

    public function delete_meau(){
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$this->access_token;

        $result = url_request($url);
        var_dump($result);


    }









}

$menu = new meau();

$menu->add_meau();
//$menu->delete_meau();

























?>