<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<title><?php echo ($name); ?>
</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=no" /> 
<!--移动端版本兼容 end -->
<style type="text/css">
    body{font: normal 100% Helvetica, Arial, sans-serif;color:#fff;background-color: #e62d2d;}
</style>
</head>
<body>

    <div style="margin: 0 auto;"><img src="<?php echo ($logo); ?>" height="64" width="64"/></div>

<div style="margin: 0 auto;">
        <div style="color:#FFF;text-align: center;font-size:20px;" id="msgspan">
         恭喜获得<?php echo ($grade); ?>哦~~
        </div>
        <div style="color:#FFF;text-align: center;">
            <form id="from1" method="POST">
            <table width="300" align="center">
                <tr><td height="60" width="80" align="center"><span style="color:#FFF;">姓名</span></td>
                    <td width="220" align="left"><input type="text" id="name" name="name" value="<?php echo ($username); ?>" placeholder="您的姓名" onblur="if(this.value==''){$('#name').attr('placeholder','您的姓名不能为空'); return false;}" style="font-size: 16px;height:40px;width: 200px; background-color: #FFF; border:#FFF solid 1px; border-radius: 5px;"></td></tr>
                <tr><td height="60" width="80" align="center"><span style="color:#FFF;">电话</span></td>
                    <td width="220" align="left"><input type="text" id="phone" name="phone" value="<?php echo ($phone); ?>" placeholder="您的手机号码" onblur="if(this.value==''){$('#phone').attr('placeholder','您的手机号码不能为空'); return false;}" style=" font-size: 16px;height:40px;width: 200px; background-color: #FFF; border:#FFF solid 1px; border-radius: 5px;"></td></tr>
                <tr><td height="60" width="80" align="center"><span style="color:#FFF;">地址</span></td>
                    <td width="220" align="left"><input type="text" id="address" name="address" value="<?php echo ($address); ?>" placeholder="您的地址" style="font-size: 16px;height:40px;width: 200px; background-color: #FFF; border:#FFF solid 1px; border-radius: 5px;"></td></tr>
            </table>
                <div><input type="submit" value="提交信息" style=" border-radius:5px;background-color: #fff; width:260px;height:50px;" /></div>
            </form>   
        </div>
            <!--<div style="text-align:left; width:auto; margin: 0 auto;">请提交您的个人信息<br>我们会在第一时间联系您哦~</div>-->

</div>
<script type="text/javascript" src="/tp_activity/Public/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/tp_activity/Public/js/jquery.form.js"></script>
<script type="text/javascript">
//验证手机号码

function checkTel(){
var tel = $("#phone").val(); //获取手机号
if(tel==''){
  $('#phone').attr('placeholder','您的手机号码不能为空');
  return false;
}else{
var telReg = !!tel.match(/^(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/);
//如果手机号码不能通过验证
if(telReg == false){
 // alert('ok');
$('#phone').val('');
$('#phone').attr('placeholder','您的手机号码格式不对');
return false;
}


}
}

$(function(){
    
       $("#from1").ajaxForm({
            
            url:'<?php echo U("Dzp/post");?>',
            dataType:'json',
            beforeSubmit:  checkForm,
            data:{
                trafficid:"<?php echo ($trafficid); ?>",
                activeid:"<?php echo ($activeid); ?>",
                prizeid:"<?php echo ($grade); ?>",
                openid:"<?php echo ($openid); ?>"
            },
            success:function(data){
                alert(data.info);
                var trafficid='<?php echo ($trafficid); ?>';
                var grade= '<?php echo ($grade); ?>';
                var activeid="<?php echo ($activeid); ?>";
                var openid = "<?php echo ($openid); ?>";
                location='<?php echo U("Home/Dzp/showMes/openid/'+openid+'/trafficid/'+trafficid+'/grade/'+grade+'/activeid/'+activeid+'");?>';
            }
           
       });
    
    
});

function checkForm(){
    if($('#name').val()==''){
       $('#name').attr('placeholder','您的姓名不能为空');
       return false;
    }else{
       return checkTel();
    }
}


</script>



</body> 

</html>