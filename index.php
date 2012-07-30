<?php 
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';  // connect to mysql database.

$ip = $_SERVER['REMOTE_ADDR'];
$autologinuser = mysql_query("SELECT * FROM users WHERE autologin = 1 ORDER BY id ASC;") OR die(mysql_query());
while ($row_autologinuser = mysql_fetch_assoc($autologinuser))
{ 
if ($ip = $row_autologinuser['ip']){
    $_SESSION['username']=$row_autologinuser['username']; //assign session
    $_SESSION['id']=$row_autologinuser['id']; //assign session
} 
}

//renren check cookie
$API_KEY = "ca131a518fd642d0b20a72a897648aac";
if (isset($_COOKIE[$API_KEY.'_expires'])){
if ($_COOKIE[$API_KEY.'_expires']>time()){
$checkcookie = $_COOKIE[$API_KEY.'_user'].$_COOKIE[$API_KEY.'_ss'].$_COOKIE[$API_KEY.'_session_key'].$_COOKIE[$API_KEY.'_expires']."6961f890ed2486fa7a1739f6e945a3b";
if (md5($checkcookie) == $_COOKIE[$API_KEY]){
$renrenlogin = 1;
} else {
$renrenlogin = 0;
}
} else {
$renrenlogin = 0;
}
} else {
$renrenlogin = 0;
}

//renren check id bangding
if (isset($_COOKIE[$API_KEY.'_user'])){
$renren_userid = $_COOKIE[$API_KEY.'_user'];
$renrenbangding = mysql_query("SELECT * FROM users WHERE renrenuserid = '$renren_userid' AND active='1' ORDER BY id ASC;") OR die(mysql_query());
$rownum_renrenbangding = mysql_num_rows($renrenbangding);
if ($rownum_renrenbangding == 1){
$row_renrenbangding = mysql_fetch_assoc($renrenbangding);
$_SESSION['username']=$row_renrenbangding['username']; //assign session
$_SESSION['id']=$row_renrenbangding['id']; //assign session
$renren_bangdingcheck = 1;
} else {
$renren_bangdingcheck = 0;
}
} else {
$renren_bangdingcheck = 2;
}

?>

<!-- define DOCTYPE for the website at the top of the page -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:xn="http://www.renren.com/2009/xnml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
<title>对ta说 - 首页</title>
<link rel="shortcut icon" type="image/x-icon" href="images/tuitasuo_icon.ico">
<!-- include all the css and js files. -->
<link href="index.css" rel="stylesheet" type="text/css" />
<!--[if IE]>
<link href="index_ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script type="text/javascript" src="index.js"></script>
<script type="text/javascript" src="jquery-1.5.2.js"></script>
</head>

<body onload="init()">
<div id="wrapper">

<div id="header">
<h1>喜欢一个人，但不知道如何开口，怎么办？</h1>
<h2>找到你的学校，然后对他/她大声说出来!<font size=4 color=red>(匿名哟)</font></h2>  
</div> 

<div id="main_content">

<div class="new_msgs">
<div class="new_msgs_box">
<div id="five_new_msgs">
<h2>最新通告</h2>
<div id="five_msgs">
<?php

$top_posts_num = 0;
$timenow = time();
$duitasuo_msg = mysql_query("SELECT * FROM duitasuomsg ORDER BY timesubmit DESC") OR die(mysql_query());
while ($row = mysql_fetch_assoc($duitasuo_msg))
{
 $gender = $row['gender'];
 $time = $row['time'];
 $place = $row['place'];
 $descr = $row['descr'];
 $words = $row['words'];
 $timeago = $timenow - $row['timesubmit'];
 		if ($timeago < 60){
 		$timesubmit = "刚刚更新";
 		}
   		else if ($timeago < 3600){
   		$timesubmit = (int)($timeago/60);
   		$timesubmit = $timesubmit."分钟之前";
   		}
   		else if ($timeago < 86400){
   		$timesubmit = (int)($timeago/3600);
   		$timesubmit = $timesubmit."小时之前";
   		}
   		else if ($timeago >= 86400){
   		$timesubmit = (int)($timeago/86400);
   		$timesubmit = $timesubmit."天之前";
   		}
 $likes = $row['likes'];
 if ($likes == 0){
 $likes = "不给力";
 }
 else {
 $likes = $likes."个给力";
 }
 
 $msgid = $row['id'];
 mysql_query("UPDATE duitasuomsg SET newmsg='1' WHERE id='$msgid'") or die(mysql_error());
 
 $msg_schoolid = $row['schoolid'];
 $duitasuo_schoolname = mysql_query("SELECT * FROM schools where id='$msg_schoolid'") OR die(mysql_query());
 $row_schoolname = mysql_fetch_assoc($duitasuo_schoolname);
 $msg_schoolname = $row_schoolname['schoolname'];
 
 echo "<div class='top_post'>
 
       <h4 onselectstart='return false'><a href='home.php?schoolid=".$msg_schoolid."'>".$msg_schoolname."</a> 的 <a href='home.php?schoolid=".$msg_schoolid."&gender=".$gender."'>".$gender."</a> 在 <a href='home.php?schoolid=".$msg_schoolid."&time=".$time."'>".$time."</a>，<a href='home.php?schoolid=".$msg_schoolid."&place=".$place."'>".$place."</a>：</h4>
       <p class='descr'>".$descr."</p>
       <p class='words'>".$words."</p>
       
       <ul class='top_post_bottom' onselectstart='return false'>
       <li class='top_post_time'>".$timesubmit."</li>
       <li id='geili_".$msgid."' class='top_post_geili'>".$likes."</li>
       </ul>
       
       </div>";
       
  $top_posts_num++;
  if ($top_posts_num >4){
   break;
  }     

}
?>
</div>
</div>
</div>
</div>


<div class="pop_schs">
<div class="pop_schs_box">
<div id="five_pop_schs">
<h2 title="学校通告数量排名前十！">最受欢迎的学校 前十名</h2>
<div id="five_schs">
<?php

$top_posts_num = 0;
$timenow = time();
$duitasuo_msg = mysql_query("SELECT * FROM schools ORDER BY likes DESC") OR die(mysql_query());
while ($row = mysql_fetch_assoc($duitasuo_msg))
{
 $schoolid = $row['id'];
 $schoolname = $row['schoolname'];
 $likes = $row['likes'];

 echo "<div class='top_school'>
 
       <div class='schoolname' onselectstart='return false'><a href='home.php?schoolid=".$schoolid."'>".$schoolname."</a></div>
       <div class='schoollikes' title='还等什么？要看到自己的学校上光荣榜，快去为你的学校发通告吧！'>".$likes."</div>
       
       </div>";
       
  $top_posts_num++;
  if ($top_posts_num >9){
   break;
  }     

}
?>
</div>
</div>
</div>
</div>


<div class="login">
<div class="login_box">
<div id="login_form">
<h2>登录</h2>
<?php
if (isset($_SESSION['id']))
      {
	  if ($renren_bangdingcheck == 1){
	  echo "<div id='login_successful'>人人绑定登录：".$_SESSION['username']."   (<a href='index_cancel_bangding.php' text-align='right'>取消绑定</a>)</div>";
      } else {
	  echo "<div id='login_successful'>您已经登录：".$_SESSION['username']."   (<a href='index_logout.php' text-align='right'>退出</a>)</div>";
      }
	  }
      else
      {
      ?>
<div id="login_field">
帐号：<input type="text" style="width: 205px; color: #999;" id="login_email" value="用户邮箱" onfocus="if(this.value=='用户邮箱'){this.value=''}; this.style.color='black';" onblur="if(this.value==''){this.value='用户邮箱'; this.style.color='#999';};">
密码：<input type="password" style="width: 205px;" id="login_password">
<div class="savepassword">
<form name="autologinform" title="为了确保您的信息安全，请不要在网吧或者公共机房勾选此项！" for="autologin" class="logincheckbox">
<input type="checkbox" name="autologin" id="autologin" value="1" />下次自动登录
</form>
</div>
<div class="buttons">
<p id="login_button" class="login_button" onclick="login()">登录</p>
<p id="signup_button" class="signup_button" onclick="signup()">注册</p>
</div>
<div id="login_message">
</div>
</div>
<?php
}
?>
</div>


<div id="other_login_form">
<h2>其他登录方式</h2>
<div id="other_logins">
<div class="other_login_buttons">
<?php 
if (isset($_COOKIE[$API_KEY.'_user'])){
?>
<p class="renren_connect_pic"><xn:profile-pic uid="loggedinuser" size="tiny" linked="true" connect-logo="false"></xn:profile-pic></p>
<p class="renren_connect_username">人人网登录：<xn:name uid="loggedinuser"></xn:name></p><br>
<p class="renren_connect_login"><xn:login-button autologoutlink="true"></xn:login-button></p>
<?php
} else {
?>
<p class="renren_connect_username"><xn:login-button autologoutlink="true"></xn:login-button></p>
<?php
}

if ($renren_bangdingcheck == 0){
echo "<p id='renren_bangding_button' class='renren_bangding_button' onclick='renren_bangding()'>人人绑定</p>";
}
?>
</div>
<!--
<xn:login-button size="medium" background="blue" label="与人人连接" show-faces="true" face-size="small" max-rows="2" face-space="5" width="255"></xn:login-button>
-->
<?php 
if (isset($_COOKIE[$API_KEY.'_user'])){
?>
<xn:friendpile show-faces="connected" face-size="small" max-rows="5" face-space="5" width="255"></xn:friendpile>
<?php
}
?>
</div>
</div>

</div>
</div>

<div id="copyright">
Koollo Kingdom Inc. &copy; 2011
</div>

</div>

<div id="signup" class="signup">
<div class="login_box">
<div id="login_form">
<h2>注册</h2>
<div id="signup_field">
名字：<input type="text" style="width: 195px;" id="signup_username">
邮箱：<input type="text" style="width: 195px;" id="signup_email">
密码：<input type="password" style="width: 195px;" id="signup_password">
<div class="buttons">
<p id="finish_signup_button" class="finish_signup_button" onclick="finish_signup()">完成</p>
<p class="cancel_signup_button" onclick="close_signup()">取消</p>
</div>
<div id="signup_message">
</div>
</div>
</div>
</div>
</div>

<div id="campus_search"> 
<input type="text" id="campus_search_input" onkeyup="campus_search()" oninput="campus_search()" onpropertychange="campus_search()" onfocus="if(this.value=='请输入你要找的学校...'){this.value=''}; this.style.color='black';" onblur="if(this.value==''){this.value='请输入你要找的学校...'; this.style.color='black';};" value="请输入你要找的学校..."/>
<span id="search_results">
</span> 
</div>

<div id="bangding_login_signup" class="bangding_login_signup">

<div class="bangding_login">
<div class="login_box">
<div id="login_form">
<h2>用已有账号与人人绑定</h2>
<div id="login_field">
帐号：<input type="text" style="width: 195px; color: #999;" id="bangding_login_email" value="用户邮箱" onfocus="if(this.value=='用户邮箱'){this.value=''}; this.style.color='black';" onblur="if(this.value==''){this.value='用户邮箱'; this.style.color='#999';};">
密码：<input type="password" style="width: 195px;" id="bangding_login_password">
<div class="savepassword">
<form name="bangding_autologinform" title="为了确保您的信息安全，请不要在网吧或者公共机房勾选此项！" class="logincheckbox">
<input type="checkbox" name="bangding_autologin" id="bangding_autologin" value="1" />下次自动登录
</form>
</div>
<div class="buttons">
<?php echo "<p id='bangding_login_button' class='bangding_login_button' onclick=bangding_login(".$renren_userid.")>绑定</p>"; ?>
<p class="cancel_bangding_login_button" onclick="close_bangding()">取消</p>
</div>
<div id="bangding_login_message">
</div>
</div>
</div>
</div>
</div>

<div class="bangding_signup">
<div class="login_box">
<div id="login_form">
<h2>注册账号并与人人绑定</h2>
<div id="signup_field">
名字：<input type="text" style="width: 195px;" id="bangding_signup_username">
邮箱：<input type="text" style="width: 195px;" id="bangding_signup_email">
密码：<input type="password" style="width: 195px;" id="bangding_signup_password">
<div class="buttons">
<?php echo "<p id='bangding_signup_button' class='bangding_signup_button' onclick='bangding_signup(".$renren_userid.")'>绑定</p>"; ?>
<p class="cancel_bangding_signup_button" onclick="close_bangding()">取消</p>
</div>
<div id="bangding_signup_message">
</div>
</div>
</div>
</div>
</div>

</div>


</div>
<script type="text/javascript" src="http://static.connect.renren.com/js/v1.0/FeatureLoader.jsp"></script>
  <script type="text/javascript">
    XN_RequireFeatures(["EXNML"], function()
    {
      XN.Main.init("ca131a518fd642d0b20a72a897648aac", "/xd_receiver.html");
    });
	
	function refresh_after_renrenlogin(){
	window.location="index.php";
	}
</script>
</body>
</html>