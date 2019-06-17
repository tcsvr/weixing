<?php

class material{
    public $access_token;
    public $api;
    public function __construct() {
        include('api.class.php');
        $this->api = new api();
        $this->api->appID = 'wx4d8082247e00e14f';
        $this->api->appsecret = '2cf126da803e48607520433466a420cb';
        $this->access_token = $this->api->get_access_token();
    }      
    public function add_ls_material(){
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$this->access_token}&type=image";
        //new CURLFile(/image)
        $img  = './images/12.jpg';
        // $img  = './video/bootstrap.mp4';
        $img = realpath($img);
        $data = ['media' => new CURLFile($img)];
        return $this->api->url_request($url,$data);
    }
    public function get_ls_material(){
        $media_id = "AVj0O52xSBY-mTKrNip1ggtoe4ytEpBkfnJoIdMThI17n5O3Yy3QvKc9FiVMyQKI"; //image
         //$media_id = "wWkfxywDnywlOrme5gMzHdu39GWwgYAW_mVTWTjVfPlGXYCO3glxyG28RY2fogHI"; //mp4
        $url = "https://api.weixin.qq.com/cgi-bin/media/get?access_token={$this->access_token}&media_id={$media_id}";
        return $this->api->url_request($url);
        

    }


}


$ma = new material();
//echo $ma->add_ls_material();
//$media_id = "wWkfxywDnywlOrme5gMzHdu39GWwgYAW_mVTWTjVfPlGXYCO3glxyG28RY2fogHI";  video
//$media_id = "AVj0O52xSBY-mTKrNip1ggtoe4ytEpBkfnJoIdMThI17n5O3Yy3QvKc9FiVMyQKI";  image
header('content-type:image/jpg');
//header('content-type:video/mp4');
echo $ma->get_ls_material();



























?>