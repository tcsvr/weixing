<?php
   // echo 122223;
include ('wechat.class.php');
$we = new wechat();
define('TOKEN','cao');
//$signature = $_GET["signature"];
$echostr = $_GET["echostr"];
if($echostr){
    $we->valid();
    exit;
}

$we-> responseMsg();

//接收原生post数据
/*
    if($msgtype == 'text'){
        if($content!='音乐'){
            $xml = "<xml>
                  <ToUserName><![CDATA[$fromUsername]]></ToUserName>
                  <FromUserName><![CDATA[$toUsername]]></FromUserName>
                  <CreateTime>$time</CreateTime>
                  <MsgType><![CDATA[text]]></MsgType>
                  <Content><![CDATA[$content]]></Content>
                </xml>";
            echo $xml;
        }
//        }else if($content=='你坏'){
//            $xml = "<xml>
//                  <ToUserName><![CDATA[$fromUsername]]></ToUserName>
//                  <FromUserName><![CDATA[$toUsername]]></FromUserName>
//                  <CreateTime>$time</CreateTime>
//                  <MsgType><![CDATA[text]]></MsgType>
//                  <Content><![CDATA[你也坏]]></Content>
//                </xml>";
//            echo $xml;
//
    //    }

    }else if($msgtype == 'image'){
        $xml = "<xml>
                  <ToUserName><![CDATA[$fromUsername]]></ToUserName>
                  <FromUserName><![CDATA[$toUsername]]></FromUserName>
                  <CreateTime>$time</CreateTime>
                  <MsgType><![CDATA[image]]></MsgType>
                  <Image>
                      <MediaId><![CDATA[$mediaId]]></MediaId>
                   </Image>
                </xml>";
        echo $xml;

    }else if($msgtype == 'voice'){
        $xml = "<xml>
                  <ToUserName><![CDATA[$fromUsername]]></ToUserName>
                  <FromUserName><![CDATA[$toUsername]]></FromUserName>
                  <CreateTime>$time</CreateTime>
                  <MsgType><![CDATA[voice]]></MsgType>
                  <Voice>
                      <MediaId><![CDATA[$mediaId]]></MediaId>
                   </Voice>
                </xml>";
        echo $xml;

    }else if($msgtype == 'text'){
        if($content =='音乐') {
          $url =  "https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=ACCESS_TOKEN";

            $xml = "<xml>
                  <ToUserName><![CDATA[$fromUsername]]></ToUserName>
                  <FromUserName><![CDATA[$toUsername]]></FromUserName>
                  <CreateTime>$time</CreateTime>
                  <MsgType><![CDATA[music]]></MsgType>
                   <Music>
                        <Title><![CDATA[Mark]]></Title>
                        <Description><![CDATA[纯音乐]]></Description>
                        <MusicUrl><![CDATA[http://wx.tcsvr.com/music/Mark.mp3]]></MusicUrl>
                        <ThumbMediaId><![CDATA[$thumbMediaId]]></ThumbMediaId>

                    </Music>

                </xml>";

            echo $xml;
        }


}
//  $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];  //php 低版本
    file_put_contents('log.txt',$postStr);



/**
 * wechat php test
 */

//define your token
/*
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();
class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)){

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $musicTpl = "<xml>
                            <ToUserName><![CDATA[$fromUsername ]]></ToUserName>
                            <FromUserName><![CDATA[$toUsername]]></FromUserName>
                            <CreateTime>$time</CreateTime>
                            <MsgType><![CDATA[music]]></MsgType>
                            <Music>
                             <MusicUrl><![CDATA[http://wx.tcsvr.com/music/Mark.mp3]]></MusicUrl>
                             </Music>
                            <FuncFlag>0</FuncFlag>
                            </xml>";
            if(!empty( $keyword ))
            {
                $msgType = "music";
                $resultStr = sprintf($musicTpl, $fromUsername, $toUsername, $time, $msgType);
                echo $resultStr;
            }else{
                echo "Input something...";
            }

        }else {
            echo "";
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}

















/*
function resourceAddImg()
{
    //JcX0UIGCrSnFHpsbzk4OecrHmfESxoknNXlD-jILMBU   img1
    //JcX0UIGCrSnFHpsbzk4OeUMnkyeMc7ef3hyf-iGsDjY   img2
    //JcX0UIGCrSnFHpsbzk4OeeYqIqTNvRnFZTZnBOlGNQY   img3
    //JcX0UIGCrSnFHpsbzk4OeU2LOA7AudBfqtU-o0Ba4T8   img4
    //JcX0UIGCrSnFHpsbzk4OeVw59WBJ4khk2sSse8UZM-Q   img5
    //JcX0UIGCrSnFHpsbzk4OedfNGwMueCfxmKYcXktTHA4   img6

$imgsrc = "/images/12.jpg";
        $real_path="{$_SERVER['DOCUMENT_ROOT']}{$imgsrc}";

        $file_info=array(
            'filename'=>$imgsrc,
            'content-type'=>'image/jpeg',
            'filelength'=>filesize($real_path)
        );


        $access_token = $this->getAccessToken('cao');

        $url="https://api.weixin.qq.com/cgi-bin/material/add_material?access_token={$access_token}&type=image";
        $curl = curl_init();
        $timeout = 5;
        $data= array("media"=>"@{$real_path}",'form-data'=>$file_info);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($curl);
        curl_close($curl);

        var_dump($result);

    }

resourceAddImg() ;

/*
function httprequest($imgurl,$url){
    $data = array(
        "media" => "@$imgurl"
    );
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
$result = curl_exec($ch);
curl_close($ch);
$result = json_decode($result, true);

return $result['thumb_media_id'];//即为上传缩略图的media_id
}
$realurl = 'http://wx.tcsvr.com/images/12.jpg';
//$url =   "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=cao)";
$appid = 'wx4d8082247e00e14f';
$appsecret = '2cf126da803e48607520433466a420cb';

$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
$thumb_media_id =  httprequest($imgurl,$url);
$postStr = file_get_contents("php://input");
file_put_contents('log.txt',$thumb_media_id);
echo $thumb_media_id ;











//define("TOKEN", "cao");
//$wechatObj = new wechatCallbackapiTest();
//$wechatObj->responseMsg();
//
///**
// * 微信处理类
// */
//class wechatCallbackapiTest {
//
//    /**
//     * 回应微信推送的主方法
//     */
//    public function responseMsg() {
//        //获取post数据
//        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
//        //解析post数据
//        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
//        switch ($postObj->MsgType) {
//            case 'event':
//                echo $resultStr = $this->getWelcomeContent($postObj);
//                break;
//            case 'text':
//                echo $resultStr = $this->getMusicContent($postObj);
//                break;
//            default:
//                echo $resultStr = $this->getMusicContent($postObj);
//                break;
//        }
//    }
//
//    /**
//     * 用户关注该公众号时推送给用户的信息
//     * @param resource $postObj 微信推送过来的数据对象
//     *
//     */
//    private function getWelcomeContent($postObj) {
//        if ($postObj->Event == 'subscribe') {
//            $ret = "<xml>
//                    <ToUserName><![CDATA[%s]]></ToUserName>
//                    <FromUserName><![CDATA[%s]]></FromUserName>
//                    <CreateTime>%s</CreateTime>
//                    <MsgType><![CDATA[%s]]></MsgType>
//                    <Content><![CDATA[%s]]></Content>
//                    </xml>";
//            $ToUserName = $postObj->FromUserName;
//            $FromUserName = $postObj->ToUserName;
//            $CreateTime = time();
//            $MsgType = 'text';
//            $Content = '欢迎关注PHP技术文章,本公众号会不定时分享PHP相关技术性文章。当然，无聊也开发了一些小功能，目前可用的是点歌功能，输入歌名或歌名[空格]歌星，即可点歌。个人网站:wx.tcsvr.com';
//            return sprintf($ret, $ToUserName, $FromUserName, $CreateTime, $MsgType, $Content);
//        } else {
//            //这里是取消关注，暂时不做处理
//        }
//    }
//
//    /**
//     *  获取返回数据，响应文字流
//     * @param resource $postObj 微信推送过来的数据对象
//     * @return text 格式化的字符串
//     */
//    private function getTextContent($postObj) {
//        $ret = "<xml>
//                <ToUserName><![CDATA[%s]]></ToUserName>
//                <FromUserName><![CDATA[%s]]></FromUserName>
//                <CreateTime>%s</CreateTime>
//                <MsgType><![CDATA[%s]]></MsgType>
//                <Content><![CDATA[%s]]></Content>
//                </xml>";
//        $MsgType = 'text'; //回复类型
//        $GetMsg = $postObj->Content; //用户发送的内容
//        //如果输入的是以下文字，后期会进行其他处理，目前还没做。
//        $MsgArray = array('文章', '技术', '其他', '笑话');
//        if (in_array($GetMsg, $MsgArray)) {
//            $RetMsg = '您需要的' . $GetMsg . '还没有找到，好吧，就算找到了也不会回给你。';
//        } else {
//            $RetMsg = '亲，如果您是点歌，那么很遗憾没有找到您点的歌，请确认后再次点歌。如果您是来逗我的话，对不起，我宁死不从。我也是有贞操的。';
//        }
//        $resultStr = sprintf($ret, $postObj->FromUserName, $postObj->ToUserName, time(), $MsgType, $RetMsg);
//        return $resultStr;
//    }
//
//    /**
//     * 获取返回数据，响应点歌
//     * @param type $postObj 微信推送过来的数据对象
//     * @return text 格式化的字符串
//     */
//    private function getMusicContent($postObj) {
//        $ret = "<xml>
//            <ToUserName><![CDATA[%s]]></ToUserName>
//            <FromUserName><![CDATA[%s]]></FromUserName>
//            <CreateTime>%s</CreateTime>
//            <MsgType><![CDATA[%s]]></MsgType>
//            <Music>
//            <Title><![CDATA[%s]]></Title>
//            <Description><![CDATA[]]></Description>
//            <MusicUrl><![CDATA[%s]]></MusicUrl>
//            <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
//            <FuncFlag><![CDATA[1]]></FuncFlag>
//            </Music>
//            </xml>";
//        $recognition = $postObj->Content;
//        //判断格式是否为歌名+明星
//        if (strstr($recognition, " ")) {
//            $strArray = explode(" ", $recognition);
//            $keywordc = urlencode($strArray[0]);
//            $keyword2 = urlencode($strArray[1]);
//        } else {
//            $keywordc = urlencode($recognition);
//            $keyword2 = null;
//        }
//        //这里歌曲库拿的是百度音乐，歌曲还是比较全的
//        $musicapi = "http://box.baidu.com/x?op=12&count=1&title={$keywordc}\$\${$keyword2}\$\$\$\$";
//        $simstr = file_get_contents($musicapi);
//        $musicobj = simplexml_load_string($simstr);
//        //如果没有搜寻到歌曲，按输入文字处理
//        if (empty($musicobj->count)) {
//            return $this->getTextContent($postObj);
//        }
//        foreach ($musicobj->url as $itemobj) {
//            $encode = $itemobj->encode;
//            $decode = $itemobj->decode;
//            $removedecode = end(explode('&', $decode));
//            if ($removedecode <> "") {
//                $removedecode = "&" . $removedecode;
//            }
//            $decode = str_replace($removedecode, "", $decode);
//            $musicurl = str_replace(end(explode('/', $encode)), $decode, $encode);
//            break;
//        }
//        $resultStr = sprintf($ret, $postObj->FromUserName, $postObj->ToUserName, time(), 'music', $recognition, $decode, $musicurl, $musicurl);
//        return $resultStr;
//    }
//
//}
// $music = new wechatCallbackapiTest();
//print_r($music);
//









?>

