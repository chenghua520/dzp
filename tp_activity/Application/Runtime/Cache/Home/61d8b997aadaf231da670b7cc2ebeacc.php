<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=no”">
<title><?php echo ($name); ?></title>
<link href="/tp_activity/Public/css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/tp_activity/Public/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/tp_activity/Public/js/jQueryRotate.2.2.js"></script>
<script type="text/javascript">
var turnplate={
		restaraunts:[],				//大转盘奖品名称
		colors:[],					//大转盘奖品区块对应背景颜色
		outsideRadius:192,			//大转盘外圆的半径
		textRadius:155,				//大转盘奖品位置距离圆心的距离
		insideRadius:68,			//大转盘内圆的半径
		startAngle:0,				//开始角度
		bRotate:false				//false:停止;ture:旋转
};

$(document).ready(function(){
	//动态添加大转盘的奖品与奖品区域背景颜色
	turnplate.restaraunts = <?php echo ($awardName); ?>; 
        //奖品数组
	turnplate.colors = <?php echo ($colors); ?>;
        //转盘扇形的颜色数组

	
	var rotateTimeOut = function (){
		$('#wheelcanvas').rotate({
			angle:0,
			animateTo:2160,
			duration:8000,
			callback:function (){
				alert('网络超时，请检查您的网络设置！');
			}
		});
	};

	//旋转转盘 item:奖品位置; txt：提示语;
	var rotateFn = function (item, txt){
		var angles = item * (360 / turnplate.restaraunts.length) - (360 / (turnplate.restaraunts.length*2));
		if(angles<270){
			angles = 270 - angles; 
		}else{
			angles = 360 - angles + 270;
		}
		$('#wheelcanvas').stopRotate();
		$('#wheelcanvas').rotate({
			angle:0,
			animateTo:angles+1800,
			duration:8000,
			callback:function (){
				//alert(txt);跳转到中奖页面的js代码
                                var openid='<?php echo ($openid); ?>';
                                var activeid='<?php echo ($activeid); ?>';
                                var trafficid='<?php echo ($trafficid); ?>';
                                if(txt!='谢谢参与'){
                                location='<?php echo U("Home/Dzp/submit/openid/'+openid+'/activeid/'+activeid+'/trafficid/'+trafficid+'/grade/'+txt+'");?>';
                            }
                        }
		});
	};

	$('.pointer').click(function (){
//		if(turnplate.bRotate)return;
//		turnplate.bRotate = !turnplate.bRotate;
//ajax请求抽奖逻辑的代码
                $.ajax({
                    type:"post",
                    url:'<?php echo U("Dzp/draw");?>',
                    data:{
                        openid:'<?php echo ($openid); ?>',
                        activeid:'<?php echo ($activeid); ?>',
                        trafficid:'<?php echo ($trafficid); ?>'
                    },
                    dataType:'json',
                    success:function(data){
                        if(data.status=='disable'){
                            alert(data.info);
                 
                        }else if(data.status=='overdue'){
                            alert(data.info);
                     
                        }else if(data.status=='chance'){
                            alert(data.info);
                        
                        }else if(data.status=='winning'){
                            alert(data.info);
                        
                        }else{
                            
                            switch(data.prize_level){
                                case 1:
                                    //获取随机数(奖品个数范围内)
//                                    alert(data.prize_id);
//                                    var item = rnd(1,turnplate.restaraunts.length);
//                                    alert(item);
                                    //奖品数量等于10,指针落在对应奖品区域的中心角度[252, 216, 180, 144, 108, 72, 36, 360, 324, 288]
                                    rotateFn(data.prize_level, turnplate.restaraunts[data.prize_level-1]);
                                    break;
                                case 2:
//                                     alert(data.prize_id);
                                    //获取随机数(奖品个数范围内)
//                                    var item = rnd(1,turnplate.restaraunts.length);
//                                    alert(item);
                                    //奖品数量等于10,指针落在对应奖品区域的中心角度[252, 216, 180, 144, 108, 72, 36, 360, 324, 288]
                                    rotateFn(data.prize_level+1, turnplate.restaraunts[data.prize_level]);
                                    break;
                                case 3:
//                                     alert(data.prize_id);
                                    //获取随机数(奖品个数范围内)
//                                    var item = rnd(1,turnplate.restaraunts.length);
//                                    alert(item);
                                    //奖品数量等于10,指针落在对应奖品区域的中心角度[252, 216, 180, 144, 108, 72, 36, 360, 324, 288]
                                    rotateFn(data.prize_level+2, turnplate.restaraunts[data.prize_level+1]);
                                    break;
                                case 4:
//                                     alert(data.prize_id);
                                    //获取随机数(奖品个数范围内)
//                                    var item = rnd(1,turnplate.restaraunts.length);
//                                    alert(item);
                                    //奖品数量等于10,指针落在对应奖品区域的中心角度[252, 216, 180, 144, 108, 72, 36, 360, 324, 288]
                                    rotateFn(data.prize_level+3, turnplate.restaraunts[data.prize_level+2]);
                                    break;
                                case 5:
//                                     alert(data.prize_id);
//                                    //获取随机数(奖品个数范围内)
//                                    var item = rnd(1,turnplate.restaraunts.length);
//                                    alert(item);
                                    //奖品数量等于10,指针落在对应奖品区域的中心角度[252, 216, 180, 144, 108, 72, 36, 360, 324, 288]
                                    rotateFn(data.prize_level+4, turnplate.restaraunts[data.prize_level+3]);
                                    break;
                                case 6:
//                                     alert(data.prize_id);
//                                    //获取随机数(奖品个数范围内)
//                                    var item = rnd(1,turnplate.restaraunts.length);
//                                    alert(item);
                                    //奖品数量等于10,指针落在对应奖品区域的中心角度[252, 216, 180, 144, 108, 72, 36, 360, 324, 288]
                                    if(turnplate.restaraunts.length==2){
                                        rotateFn(data.prize_level, turnplate.restaraunts[2-1]);
                                        break;
                                    }else if(turnplate.restaraunts.length==4){
                                        rotateFn(data.prize_level, turnplate.restaraunts[4-3]);
                                        break;
                                    }else if(turnplate.restaraunts.length==6){
                                        rotateFn(data.prize_level, turnplate.restaraunts[6-5]);
                                        break;
                                    }else if(turnplate.restaraunts.length==8){
                                        rotateFn(data.prize_level, turnplate.restaraunts[8-7]);
                                        break;
                                    }else if(turnplate.restaraunts.length==10){
                                        rotateFn(data.prize_level, turnplate.restaraunts[10-9]);
                                        break;
                                    }
                                    
                            }
                        }
                    }
                    
                });
	});
});

function rnd(n, m){
	var random = Math.floor(Math.random()*(m-n+1)+n);
	return random;
	
}


//页面所有元素加载完毕后执行drawRouletteWheel()方法对转盘进行渲染
window.onload=function(){
	drawRouletteWheel();
};

function drawRouletteWheel() {    
  var canvas = document.getElementById("wheelcanvas");    
  if (canvas.getContext) {
	  //根据奖品个数计算圆周角度
	  var arc = Math.PI / (turnplate.restaraunts.length/2);
	  var ctx = canvas.getContext("2d");
	  //在给定矩形内清空一个矩形
	  ctx.clearRect(0,0,422,422);
	  //strokeStyle 属性设置或返回用于笔触的颜色、渐变或模式  
	  ctx.strokeStyle = "#FFBE04";
	  //font 属性设置或返回画布上文本内容的当前字体属性
	  ctx.font = '16px Microsoft YaHei';      
	  for(var i = 0; i < turnplate.restaraunts.length; i++) {       
		  var angle = turnplate.startAngle + i * arc;
		  ctx.fillStyle = turnplate.colors[i];
		  ctx.beginPath();
		  //arc(x,y,r,起始角,结束角,绘制方向) 方法创建弧/曲线（用于创建圆或部分圆）    
		  ctx.arc(211, 211, turnplate.outsideRadius, angle, angle + arc, false);    
		  ctx.arc(211, 211, turnplate.insideRadius, angle + arc, angle, true);
		  ctx.stroke();  
		  ctx.fill();
		  //锁画布(为了保存之前的画布状态)
		  ctx.save();   
		  
		  //----绘制奖品开始----
		  ctx.fillStyle = "#E5302F";
		  var text = turnplate.restaraunts[i];
		  var line_height = 17;
		  //translate方法重新映射画布上的 (0,0) 位置
		  ctx.translate(211 + Math.cos(angle + arc / 2) * turnplate.textRadius, 211 + Math.sin(angle + arc / 2) * turnplate.textRadius);
		  
		  //rotate方法旋转当前的绘图
		  ctx.rotate(angle + arc / 2 + Math.PI / 2);
		  
		  /** 下面代码根据奖品类型、奖品名称长度渲染不同效果，如字体、颜色、图片效果。(具体根据实际情况改变) **/
		  if(text.indexOf("M")>0){
                      //流量包
                      var texts = text.split("M");
                      for(var j = 0; j<texts.length; j++){
                          ctx.font = j == 0?'bold 20px Microsoft YaHei':'16px Microsoft YaHei';
                          if(j == 0)
                          {
                            ctx.fillText(texts[j]+"M", -ctx.measureText(texts[j]+"M").width / 2, j * line_height);
                          }else{
                            ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, j * line_height);
                          }
                      }
                  }else if(text.indexOf("M") == -1 && text.length>6){
                          //奖品名称长度超过一定范围 
                          text = text.substring(0,6)+"||"+text.substring(6);
			  var texts = text.split("||");
			  for(var j = 0; j<texts.length; j++){
				  ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, j * line_height);
			  }
			  
                  }else{
                 
                    //在画布上绘制填色的文本。文本的默认颜色是黑色
			  //measureText()方法返回包含一个对象，该对象包含以像素计的指定字体宽度
			  ctx.fillText(text, -ctx.measureText(text).width / 2, 0);
                  }
		  
		  //添加对应图标
		  if(text.indexOf("等奖")>0){
			  var img= document.getElementById("shan-img");
			  img.onload=function(){  
				  ctx.drawImage(img,-15,10);      
			  }; 
			  ctx.drawImage(img,-15,10);  
		  }else if(text.indexOf("谢谢参与")>=0){
			  var img= document.getElementById("sorry-img");
			  img.onload=function(){  
				  ctx.drawImage(img,-15,10);      
			  };  
			  ctx.drawImage(img,-15,10);  
		  }
		  //把当前画布返回（调整）到上一个save()状态之前 
		  ctx.restore();
		  //----绘制奖品结束----
	  }     
  } 
}

</script>
</head>
<body class="keBody">
<div style="margin: 0 auto;"><img src="<?php echo ($logo); ?>" height="64" width="64"/></div>
<div class="kePublic">
<!--效果html开始-->
    <div style="max-width:800px; margin:0 auto">
    <img src="/tp_activity/Public/images/1.png" id="shan-img" style="display:none;" />
    <img src="/tp_activity/Public/images/2.png" id="sorry-img" style="display:none;" />
	<div class="banner">
             
		<div class="turnplate" style="background-image:url(/tp_activity/Public/images/turnplate-bg.png);background-size:100% 100%;">
                    <canvas class="item" id="wheelcanvas" width="422px" height="422px"></canvas>
			<img class="pointer" src="/tp_activity/Public/images/turnplate-pointer.png"/>
		</div>
            <p><?php echo ($regulation); ?></p>
	</div>
    </div>
</div>
</body>
</html>