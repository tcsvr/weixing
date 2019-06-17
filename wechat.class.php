<?php

class wechat
{

    public $postObj;
    public $fromUsername;
    public $toUsername;
    public $msgtype;
    public $content;
    public $MediaId;
    public $time;


    public function checkSignature()
    {//检查签名

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];


//    file_put_contents('log.txt',TOKEN);

        $tmpArr = [TOKEN, $timestamp, $nonce];

        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
            // echo 'error';
            //  exit;
        }
    }

    public function valid()
    {//验证消息
        $echostr = $_GET["echostr"];
        if ($this->checkSignature()) {
            echo $echostr;
        } else {
            echo 'error';
            exit;
        }

    }


    public function   responseMsg()
    {//响应消息
        $postStr = file_get_contents("php://input");//php 7.3版本
        if (empty($postStr)) {
            echo 'error';
            //exit;
        } else {
            $this->postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $this->fromUsername = $this->postObj->FromUserName;
            $this->toUsername = $this->postObj->ToUserName;
            $this->msgtype = $this->postObj->MsgType;
            $this->content = $this->postObj->Content;
            $this->MediaId = $this->postObj->MediaId;
            $this->time = time();


            // $thumbMediaId = JcX0UIGCrSnFHpsbzk4OecrHmfESxoknNXlD - jILMBU;
            // $description = $postObj->Description;
            // $musicURL = $postObj->MusicURL;
            // $hqMusicUrl = $postObj->HQMusicUrl;
            // $title = $postObj->Title;
            //JcX0UIGCrSnFHpsbzk4OecrHmfESxoknNXlD-jILMBU   img1
            //JcX0UIGCrSnFHpsbzk4OeUMnkyeMc7ef3hyf-iGsDjY   img2
            //JcX0UIGCrSnFHpsbzk4OeeYqIqTNvRnFZTZnBOlGNQY   img3
            //JcX0UIGCrSnFHpsbzk4OeU2LOA7AudBfqtU-o0Ba4T8   img4
            //JcX0UIGCrSnFHpsbzk4OeVw59WBJ4khk2sSse8UZM-Q   img5
            //JcX0UIGCrSnFHpsbzk4OedfNGwMueCfxmKYcXktTHA4   img6
        }

//======================处理文本消息开始===============================================
        if ($this->msgtype == 'text') {
            if ($this->content == '点歌') {
                $title = '我的';
                $description = 'sq';
                $music_url = 'http://wx.tcsvr.com/music/Mark.mp3';
                $hq_music_url = 'http://wx.tcsvr.com/music/Mark.mp3';

                $this->receiveMusic($title, $description, $music_url, $hq_music_url);//处理文本信息
            } else if ($this->content == '水') {
                $txt = '暂时没有水';
                $this->receiveText($txt);//处理文本信息

            }else if($this->content == '新闻') {

                $this->receiveArticle();

            }else if( $this->content == '图片'){
                $mediald = "AVj0O52xSBY-mTKrNip1ggtoe4ytEpBkfnJoIdMThI17n5O3Yy3QvKc9FiVMyQKI";
                $this->receiveImage($mediald);//处理图片信息
            }else if( $this->content == '视频'){

                $mediald = "wWkfxywDnywlOrme5gMzHdu39GWwgYAW_mVTWTjVfPlGXYCO3glxyG28RY2fogHI";
                $title = '士';
                $description = '学习';
                $this->receiveVideo($mediald, $title, $description);

            }

//======================处理文本消息结束===============================================
//======================处理图片消息开始===============================================

        } else if ($this->msgtype == 'image') {
            $mediald = $this->MediaId;
            $this->receiveImage($mediald);//处理图片信息


        }else if($this->msgtype == 'event'){
            $this->receiveEvent();

        }

    }
//======================事件处理开始====================================================
public function receiveEvent(){
    $key = $this->postObj->Event;
    if($key == 'subscribe'){
        $txt ="欢迎来到\n";
        $txt.="我的世界\n";
        $txt.="有你更精彩\n";
        $txt.="NICE！";
        $this->receiveText($txt);

    }else if($key == 'CLICK'){
        if($this->postObj->EventKey=='NEWS'){
            $this->receiveArticle();
        }else if( $this->postObj->EventKey == 'MUSIC'){

                $title = '我的';
                $description = 'sq';
                $music_url = 'http://wx.tcsvr.com/music/Mark.mp3';
                $hq_music_url = 'http://wx.tcsvr.com/music/Mark.mp3';
                $this->receiveMusic($title, $description, $music_url, $hq_music_url);//处理文本信息


        }else if($this->postObj->EventKey == 'ZAN'){
                $txt = '谢谢点赞';
                $this->receiveText($txt);//处理文本信息

        }

    }

    

}



//======================事件处理结束====================================================
//======================消息回复开始====================================================

//====================== 文本 消息回复开始===============================================
    public function receiveText($txt)
    {

        $xml = "<xml>
                  <ToUserName><![CDATA[%s]]></ToUserName>
                  <FromUserName><![CDATA[%s]]></FromUserName>
                  <CreateTime>$this->time</CreateTime>
                  <MsgType><![CDATA[text]]></MsgType>
                  <Content><![CDATA[%s]]></Content>
                </xml>";
        printf($xml, $this->fromUsername, $this->toUsername, $txt);

    }



    //====================== 文本 消息回复结束===============================================

    //====================== 视频 消息回复开始===============================================
    public function receiveVideo($mediald, $title, $description){ //回复视频
        $xml = "<xml>
                  <ToUserName><![CDATA[%s]]></ToUserName>
                  <FromUserName><![CDATA[%s]]></FromUserName>
                  <CreateTime>$this->time</CreateTime>
                  <MsgType><![CDATA[video]]></MsgType>
                  <Video>
                    <MediaId><![CDATA[%s]]></MediaId>
                    <Title><![CDATA[%s]]></Title>
                    <Description><![CDATA[%s]]></Description>
                  </Video>
                </xml>";

        printf($xml, $this->fromUsername, $this->toUsername, $mediald, $title, $description);
    }

//======================视频 回复结束===============================================

//====================== 音乐 消息回复开始===============================================


    public function receiveMusic($title, $description, $music_url, $hq_music_url)
    {

        $xml = "<xml>
                  <ToUserName><![CDATA[%s]]></ToUserName>
                  <FromUserName><![CDATA[%s]]></FromUserName>
                  <CreateTime>$this->time</CreateTime>

                    <MsgType><![CDATA[music]]></MsgType>
                    <Music>
                     <Title><![CDATA[%s]]></Title>
                     <Description><![CDATA[%s]]></Description>
                        <MusicUrl><![CDATA[%s]]></MusicUrl>
                        <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>

                    </Music>
                </xml>";
        printf($xml, $this->fromUsername, $this->toUsername, $title, $description, $music_url, $hq_music_url);


    }

//======================音乐 回复结束===============================================

//====================== 图片 消息回复开始===============================================

    public function receiveImage($mediald)
    {

        $xml = "<xml>
                  <ToUserName><![CDATA[%s]]></ToUserName>
                  <FromUserName><![CDATA[%s]]></FromUserName>
                  <CreateTime>$this->time</CreateTime>
                  <MsgType><![CDATA[image]]></MsgType>
                    <Image>
                     <MediaId><![CDATA[%s]]></MediaId>
                    </Image>

                </xml>";
        printf($xml, $this->fromUsername, $this->toUsername, $mediald);


    }

//======================消息 图片 回复结束===============================================
 public function receiveArticle(){
    $date =[
        [
            'title'=>'标题1',
            'description'=>'描述1',
            'pic_url'=>'http://wx.tcsvr.com/images/12.jpg',
            'url'=>'http://baidu.com',
        ],        [
            'title'=>'标题2',
            'description'=>'描述2',
            'pic_url'=>'http://wx.tcsvr.com/images/img1.jpg',
            'url'=>'http://hao123.com',
        ],        [
            'title'=>'标题333',
            'description'=>'描述33',
            'pic_url'=>'http://wx.tcsvr.com/images/img2.jpg',
            'url'=>'http://youku.com',
        ],
    ];

     $str= '';
     foreach($date as $v){
         $str .= "<item>
                         <Title><![CDATA[$v[title]]]></Title>
                        <Description><![CDATA[$v[description]]]></Description>
                        <PicUrl><![CDATA[$v[pic_url]]]></PicUrl>
                        <Url><![CDATA[$v[url]]]></Url>
                    </item> ";
     }
        $xml = "<xml>
                  <ToUserName><![CDATA[%s]]></ToUserName>
                  <FromUserName><![CDATA[%s]]></FromUserName>
                  <CreateTime>$this->time</CreateTime>
                    <MsgType><![CDATA[news]]></MsgType>
                    <ArticleCount>".count($date)."</ArticleCount>
                    <Articles>
                    ".$str."
                    </Articles>
                </xml>";
        printf($xml, $this->fromUsername, $this->toUsername);


    }

//======================消息 图片 回复结束===============================================

//======================消息回复结束==========================================================



}

/*


   responseMsg()
接受文本消息  receiveText()
接受图片消息  receiveImage()
发送文本消息  replayText()

}
*/














?>