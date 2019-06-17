<?php
include('jssdk.class.php');

$sdk = new jssdk();

$signArr = $sdk->signature();



?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>JSSDK DEMO</title>
    <script src="js/jweixin-1.4.0.js"></script>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script>
        wx.config({
            debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: '<?php echo $signArr['appId']; ?>', // 必填，公众号的唯一标识
            timestamp: <?php echo $signArr['timestamp']; ?>, // 必填，生成签名的时间戳
            nonceStr: '<?php echo $signArr['nonceStr']; ?>', // 必填，生成签名的随机串
            signature: '<?php echo $signArr['signature']; ?>', // 必填，签名
            jsApiList: [
                'onMenuShareTimeline',
                'chooseImage'
            ] // 必填，需要使用的JS接口列表
        });
    </script>
</head>

<body>
    <h1>测试 JSSDK 调用手机硬件，分享等接口</h1>
    <input style="width:100%;height:60px;background:red;" type="button" value="打开照相机" />
    <img src="" alt="图片" />
</body>

</html>
<script>
    $('h1').css({
        background: 'blue'
    });

    $('input').click(function() {
        wx.chooseImage({
            count: 1, // 默认9
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function(res) {
                var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                $('img').attr('src', localIds);
            }
        });
    });


    wx.ready(function() { //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '天下士', // 分享标题
            //            desc: '文豆科技网络有限公司是一家很好的公司！', // 分享描述
            link: '<?php echo $signArr['url']; ?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'http://wx.tcsvr.com/images/12.jpg', // 分享图标
            success: function() {
                // 设置成功
                alert('分享成功');
            }
        })
    });
</script>