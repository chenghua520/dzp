<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<title><?php echo ($name); ?>
</title>
<meta charset="utf-8" />
<meta name="apple-touch-fullscreen" content="YES" />
<meta name="format-detection" content="telephone=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta http-equiv="Expires" content="-1" />
<meta http-equiv="pragram" content="no-cache" />
<link rel="stylesheet" type="text/css" href="/tp_activity/Public/css/main.css"/>
<script type="text/javascript" src="/tp_activity/Public/js/jquery-1.7.2.min.js"></script>
<!--移动端版本兼容 -->
<script type="text/javascript">
        var phoneWidth = parseInt(window.screen.width);
        var phoneScale = phoneWidth / 640;

        var ua = navigator.userAgent;
        if (/Android (\d+\.\d+)/.test(ua)) {
                var version = parseFloat(RegExp.$1);
                // andriod 2.3
                if (version > 2.3) {
                        document.write('<meta name="viewport" content="width=640, minimum-scale = ' + phoneScale + ', maximum-scale = ' + phoneScale + ', target-densitydpi=device-dpi">');
                        // andriod 2.3以上
                } else {
                        document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi">');
                }
                // 其他系统
        } else {
                document.write('<meta name="viewport" content="width=640,height=1008, user-scalable=no, target-densitydpi=device-dpi">');
        }
</script>
<script type="text/javascript">
        var i = 0;
        var ShowQian = 0;
        //飞签数据
        var feiqian_sec = 0;
        var feiqian_zhen = 1;
        var feiqian_zhen_temp = 0;
        var feiqian_sec_jiange = 50;
        var Feiqian_Interval = null;
        //摇签数据
        var yaoqian_sec = 0;
        var yaoqian_zhen = 1;
        var yaoqian_zhen_temp = 0;
        var yaoqian_sec_jiange = 50;
        var Yaoqian_Interval = null;

        var qiantxt = '';

        if(window.DeviceMotionEvent) {
                var speed = 25;
                var x = y = z = lastX = lastY = lastZ = 0;
                window.addEventListener('devicemotion', function(){
                        var acceleration =event.accelerationIncludingGravity;
                        x = acceleration.x;
                        y = acceleration.y;
                        z = acceleration.z; 
                        if(Math.abs(x-lastX) > speed || Math.abs(y-lastY) > speed) {
                                i += parseInt(1);//自加变量

                                if(ShowQian ==0){

                                        ShowQian = 1;

                                        $.ajax({
                                     type: "POST",
                                     url: "<?php echo U('thq/rock');?>",
                                     dataType: "json",
                                     data:{
                                         activeid:"<?php echo ($activeid); ?>",
                                         trafficid:"<?php echo ($trafficid); ?>",
                                         openid:"<?php echo ($openid); ?>",
                                     },
                                     success: function(json){
                                        if(json.status=='disable'){
                                            alert(json.info);
                                        }else if(json.status=='overdue'){
                                            alert(json.info);
                                        }else if(json.status=='chance'){
                                            alert(json.info);
                                        }else if(json.status == 'success'){

                                                var qiantxt = json.msg;
                                                //更变签名
                                                $('#qiantxt_span').html(qiantxt);
                                                //签筒一直摇晃
                                                                Yaoqian_Interval = self.setInterval("yaoqian_fun()", feiqian_sec_jiange);
                                                                //晃动声音
                                                                audio.play();
                                                                //飞签开始运动等待开始
                                                                setTimeout('Feiqian_Interval = self.setInterval("feiqian_fun(5)", feiqian_sec_jiange);', 3000);
                                                                //关闭背景
                                                                $('#bg').hide();
                                                                $('#bg_mohu').show();

                                        }else{
                                                alert(json.msg);

                                        }

                                     }
                                        });
                                }

                        }
                        lastX = x;
                        lastY = y;
                        lastZ = z; 
                }, false);
        }

</script>
</head>
<body>
<div id="jieqian" style="<?php if($is_open == 0): ?>display:none;<?php endif; ?>position:absolute;left:150px;top:600px;z-index:105;"><img src="/tp_activity/Public/images/jieqian.png"></div>
<div id="bg" style="width:640px;height:1008px;background:url(/tp_activity/Public/images/bag.jpg) no-repeat;">
<div style="position:absolute;left:210px;top:850px;">
    <a href="javascript:;" onclick="$('#shuoming_div').show();" style="color:#FFF;font-size:28px;">点击查看活动规则</a>
</div>
<div id="shuoming_div" style="display:none;opacity: 0.6; color:#FFF; height:1008px; line-height:1008px;font-size:28px;background-color: black;text-align:center;z-index:999;" onclick="$('#shuoming_div').hide();"><?php echo ($regulation); ?></div>
</div>		
<div id="bg_mohu" style="display:none;z-index:101;width:640px;height:1008px;overflow:hidden;background:url(/tp_activity/Public/images/bg_mohu.jpg) no-repeat;">
        <div id="feiqian_div" style="display:none;position:absolute;left:210px;top:90px;"><img id="feiqian_img" src="/tp_activity/Public/images/feiqian/feiqian_1.png" /></div>
        <div id="yaoqian_div" style="position:absolute;left:10px;top:220px;"><img id="yaoqian_img" src="/tp_activity/Public/images/yaoqian/1.png" /></div>
        <div id="daqian_div" style="position:relative;left:140px;top:-780px;">
        <span style="font-family:隶书;position: absolute;left:140px;color:#8c4f60;top: 335px;font-size:58px;" id="qiantxt_span"></span>
            <!--<span id="shuoming" style="opacity:0; position: absolute;width:60px;left:270px;color:#FFF;top: 425px;font-size:26px;">-->
                <!--<div style="float:left;width:30px;">凭桃花签到大悦城</div> <div style="float:left;width:30px;">活动现场参与解签</div></span>-->-->
        <img src="/tp_activity/Public/images/daqian.png" /></div>
</div>		
<audio id="audio_bg" src="/tp_activity/Public/images/5018.mp3">
<audio id="audio_over" src="/tp_activity/Public/images/4092.mp3">
<div id="bg_mohu" style="z-index:101;width:640px;height:1008px;overflow:hidden;background:url(/tp_activity/Public/images/bg_mohu.jpg) no-repeat;">
    <div id="daqian_div" <?php if($is_open == 0): ?>onclick="jieqian();"<?php endif; ?> style="position:relative;left:140px;top:90px;"><span style="font-family:隶书;position: absolute;left:140px;color:#8c4f60;top: 335px;font-size:58px;" id="qiantxt_span"></span><span id="shuoming" style="position: absolute;width:60px;left:270px;color:#FFF;top: 425px;font-size:26px;"><div style="float:left;width:30px;">凭桃花签到大悦城</div> <div style="float:left;width:30px;">活动现场参与解签</div></span><img width="346" src="/tp_activity/Public/images/daqian.png" /></div>		
</div>
<script type="text/javascript">

var audio = $("#audio_bg")[0];  

var audio_over = $("#audio_over")[0];

        //飞签动画
        function feiqian_fun(){
                //增加秒数
                feiqian_sec = feiqian_sec + feiqian_sec_jiange;

                //出签音效
                audio_over.play();

                if(feiqian_zhen_temp != feiqian_zhen){
                        $("#feiqian_img").attr('src', '/tp_activity/Public/images/feiqian/feiqian_' + feiqian_zhen + '.png');
                        //备份签数
                        feiqian_zhen_temp = feiqian_zhen;
                }
                switch (feiqian_sec){

                        case 50:
                                $("#feiqian_div").show();
                                break;

                        case 100:
                                //签筒消失
                                $("#yaoqian_div").animate({opacity:'0'});
                                //调整位置
                                $("#feiqian_div").css('top', $("#feiqian_div").offset().top - 60 + 'px'); 
                                break;
                        case 150:
                                //增加帧数
                                feiqian_zhen ++ ;
                                //调整位置
                                $("#feiqian_div").css('top', $("#feiqian_div").offset().top - 80 + 'px'); 
                                break;
                        case 300:
                                //增加帧数
                                feiqian_zhen ++ ;
                                //调整位置
                                $("#feiqian_div").css('top', $("#feiqian_div").offset().top - 90 + 'px'); 
                                break;
                        case 450:
                                //增加帧数
                                feiqian_zhen ++ ;
                                //调整位置
                                $("#feiqian_div").css('top', $("#feiqian_div").offset().top - 120 + 'px'); 
                                break;
                        case 550:
                                //增加帧数
                                feiqian_zhen ++ ;
                                //调整位置
                                $("#feiqian_div").css('top', $("#feiqian_div").offset().top - 360 + 'px'); 
                                break;
                        case 650:
                                //停止签盒
                                setTimeout('window.clearInterval(Yaoqian_Interval);Yaoqian_Interval = null;', 3000);
                                //增加帧数
                                feiqian_zhen ++ ;
                                //调整位置
                                $("#feiqian_div").css('top', $("#feiqian_div").offset().top - 420 + 'px'); 
                                break;


                }

                if(feiqian_zhen >=5){

                        //准备下落签
                        setTimeout('qianxialuo();', 500);

                        window.clearInterval(Feiqian_Interval);
                        Feiqian_Interval = null;

                }

        }

//摇签动画
function yaoqian_fun(){
        //增加秒数
        yaoqian_sec = yaoqian_sec + yaoqian_sec_jiange;

        if(yaoqian_zhen_temp != yaoqian_zhen){
                $("#yaoqian_img").attr('src', '/tp_activity/Public/images/yaoqian/' + yaoqian_zhen + '.png');
                //备份签数
                yaoqian_zhen_temp = yaoqian_zhen;
        }
        switch (yaoqian_sec){

                case 150:
                        yaoqian_zhen ++ ;
                        break;
                case 250:
                        yaoqian_zhen ++ ;
                        break;
                case 400:
                        yaoqian_zhen ++ ;
                        break;
                case 500:
                        yaoqian_zhen ++ ;
                        break;
                case 600:
                        yaoqian_zhen ++ ;
                case 700:
                        yaoqian_zhen ++ ;
                        break;
                case 850:
                        yaoqian_zhen ++ ;
                        break;
                case 950:
                        yaoqian_zhen ++ ;
                        break;
        }

        if(yaoqian_zhen >= 8){
                //初始化帧数
                yaoqian_zhen = 1 ;
                //初始化
                yaoqian_sec = 50;

        }

}
//飞签下落动画
function qianxialuo(){

        //大签下落
        $("#daqian_div").animate({top:'90px'},function(){
                $('#shuoming').animate({opacity:'1'});
        }).click(function(){
                   jieqian();
        });

}
</script>
<script type="text/javascript">

	function jieqian(){
	   if(confirm("是否要开始解签?此操作只有大仙儿才能操作哦~私自操作将不会得到礼物~")){ 
	   		$.ajax({
	             type: "GET",
	             url: "<?php echo U('thq/jieqian',array('trafficid'=>$trafficid,'activeid'=>$activeid,'openid'=>$openid));?>",
	             dataType: "json",
	             success: function(json){
	             	$('#jieqian').show();
	             }
			 })
	   }else{
	    	return false;
	   }
	};
</script>
<div id="cacheimg" style="position:absolute;left:0px;top:0px;display:none;z-index:-9;">
        <img src="/tp_activity/Public/images/yaoqian/1.png" />
        <img src="/tp_activity/Public/images/yaoqian/2.png" />
        <img src="/tp_activity/Public/images/yaoqian/3.png" />
        <img src="/tp_activity/Public/images/yaoqian/4.png" />
        <img src="/tp_activity/Public/images/yaoqian/5.png" />
        <img src="/tp_activity/Public/images/yaoqian/6.png" />
        <img src="/tp_activity/Public/images/yaoqian/7.png" />
        <img src="/tp_activity/Public/images/yaoqian/8.png" />

        <img src="/tp_activity/Public/images/feiqian/feiqian_1.png" />
        <img src="/tp_activity/Public/images/feiqian/feiqian_2.png" />
        <img src="/tp_activity/Public/images/feiqian/feiqian_3.png" />
        <img src="/tp_activity/Public/images/feiqian/feiqian_4.png" />
        <img src="/tp_activity/Public/images/feiqian/feiqian_5.png" />
</div>
</body> 
</html>