<?php 
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';  // connect to mysql database.

$_SESSION['ip']=$_SERVER['REMOTE_ADDR'];
$ip = $_SESSION['ip'];

$autologinuser = mysql_query("SELECT * FROM users WHERE autologin = 1 ORDER BY id ASC;") OR die(mysql_query());
while ($row_autologinuser = mysql_fetch_assoc($autologinuser))
{
if ($ip = $row_autologinuser['ip']){
    $_SESSION['username']=$row_autologinuser['username']; //assign session
    $_SESSION['id']=$row_autologinuser['id']; //assign session
} 
}

//renren check id bangding
$API_KEY = "ca131a518fd642d0b20a72a897648aac";
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

if (isset($_SESSION['id'])){
$userid = $_SESSION['id']; // assign SESSION 'id' value to $userid.
$username = $_SESSION['username'];
} else {
$userid = 0; // assign SESSION 'id' value to $userid.
$username = "匿名";
}

$schoolid = $_GET["schoolid"];
$result_school = mysql_query("SELECT * FROM schools WHERE id='$schoolid' ORDER BY id ASC;") or die();
$row_school =  mysql_fetch_array($result_school);
$schoolname = $row_school['schoolname'];

$_SESSION['schoolid'] = $schoolid;
$_SESSION['schoolname'] = $schoolname;

if ($schoolid==null){
 header('Location: index.php'); //if user is not logged in, return to the sign in page.
}

if (isset($_GET["gender"])){
$getgender = $_GET["gender"];
}
if (isset($_GET["time"])){
$gettime = $_GET["time"];
}
if (isset($_GET["place"])){
$getplace = $_GET["place"];
}
?>

<!-- define DOCTYPE for the website at the top of the page -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:xn="http://www.renren.com/2009/xnml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>对ta说 - <?php echo $schoolname; ?></title>
<link rel="shortcut icon" type="image/x-icon" href="images/tuitasuo_icon.ico">
<link href="home.css" rel="stylesheet" type="text/css" />
<link href="button.css" rel="stylesheet" type="text/css" />
<!--[if IE]>
<link href="home_ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script type="text/javascript" src="home.js"></script>
<script type="text/javascript" src="init.js"></script>
<script type="text/javascript" src="home_chat.js"></script>
</head>

<body onload="init()">

<div id="wrapper">

<div id="main_content">

<div class="header">
<div class="header_bg">
<ul class='profile' onselectstart='return false'>
<a href='home.php?schoolid=<?php echo $schoolid; ?>'><li class='menu' onmouseover=this.className='menu_onmouseover' onmouseout=this.className='menu'>首页</li></a>
<a><li class='menu' onmouseover=this.className='menu_onmouseover' onmouseout=this.className='menu' onclick=see_my_msgs() >个人主页</li></a> 
<a><li class='menu' onmouseover=this.className='menu_onmouseover' onmouseout=this.className='menu' onclick=see_unread_comment() >提醒</li></a>
<a><li class='menu' onmouseover=this.className='menu_onmouseover' onmouseout=this.className='menu' onclick="see_pmsg()" >私密信</li></a>
<a><li class='menu' onmouseover=this.className='menu_onmouseover' onmouseout=this.className='menu' onclick="login_signup()" >登录</li></a>
</ul>
</div>
</div>

<div class="content">

<div id="duitasuo_post"> 

  <div class="details"> 
  
    <p class="label">我看到了一个:</p> 
    
    <p class="gender switch"> 
      <input type="text" id="gender" name="gender" style="display: none;" value="女生">
      <a id="gender1" class="cb-enable selected" onclick="gender_switch('1')"><span>女生</span></a> 
      <a id="gender2" class="cb-disable" onclick="gender_switch('2')"><span>男生</span></a> 
    </p> 
    
    <p class="label">时间: </p> 
    
    <p> <!-- p to float: left --> 
    <select class="time_switch" name="time" onchange="time_switch(this.options[this.selectedIndex].value);">      
        <option value="今天早上">今天早上</option>     
        <option value="今天中午">今天中午</option> 
        <option value="今天下午">今天下午</option> 
        <option value="今天晚上">今天晚上</option>       
        <option value="昨天">昨天</option>     
        <option value="昨天之前">昨天之前</option>      
    </select>
    <a id="time_display" class="time_display" style="display: inline-block; ">今天早上</a>
    </p>
    
    <p class="label">地点:</p> 
    
    <input autolocations="true" type="text" id="place" name="place" onkeypress="chat_animation_move(event)" onkeydown="chat_animation_move(event)"/>	
  	
  </div>
  
  <div class="descr">
   
    <p class="label">描述:</p> 
    
    <textarea rows="2" type="text" id="descr" name="descr" ></textarea>
   
  </div>
  
  <div class="flirt">
   
    <p class="label">想要说..</p> 
    
    <textarea rows="3" type="text" id="words" name="words" ></textarea>
  
  </div>  

  <?php echo "<a id='post_button' name='post_button' class='post_button' onclick='post_msg(".$schoolid.")' >对她说</a>"; ?>
  <?php //echo "<button id='post_button' name='post_button' class='punch' onclick='post_msg(".$schoolid.")' >对她说</button>"; ?>
  <div style="float:left;padding-top:5px;padding-left:20px;color:red;display:none;" id="post_error" class="email_message"></div> 

</div>


<div id="duitasuo_display">

<div id="post_status" onselectstart="return false">
<div id="post_status_control" class="post_status_control">
<?php 
echo "<a id='refresh_posts' class='refresh_posts' onclick=refresh_duitasuo('0','".$schoolid."')>刷新</a>";
?>
</div>
</div>

<div id="posts" class="posts">
<?php
if (isset($getgender)){
$sql = mysql_query("SELECT * FROM duitasuomsg WHERE schoolid='$schoolid' AND gender='$getgender' ORDER BY timesubmit DESC;") or die();
} else if (isset($gettime)){
$sql = mysql_query("SELECT * FROM duitasuomsg WHERE schoolid='$schoolid' AND time='$gettime' ORDER BY timesubmit DESC;") or die();
} else if (isset($getplace)){
$sql = mysql_query("SELECT * FROM duitasuomsg WHERE schoolid='$schoolid' AND place='$getplace' ORDER BY timesubmit DESC;") or die();
} else {
$sql = mysql_query("SELECT * FROM duitasuomsg WHERE schoolid='$schoolid' ORDER BY timesubmit DESC;") or die();
}
$nr = mysql_num_rows($sql); // Get total of Num rows from the database query
$pn = 1; 
$itemsPerPage = 5; 
$lastPage = ceil($nr / $itemsPerPage);
// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage; 

$timenow = time();
if (isset($getgender)){
$duitasuo_msg = mysql_query("SELECT * FROM duitasuomsg WHERE schoolid='$schoolid' AND gender='$getgender' ORDER BY timesubmit DESC") OR die(mysql_query());
} else if (isset($gettime)){
$duitasuo_msg = mysql_query("SELECT * FROM duitasuomsg WHERE schoolid='$schoolid' AND time='$gettime' ORDER BY timesubmit DESC") OR die(mysql_query());
} else if (isset($getplace)){
$duitasuo_msg = mysql_query("SELECT * FROM duitasuomsg WHERE schoolid='$schoolid' AND place='$getplace' ORDER BY timesubmit DESC") OR die(mysql_query());
} else {
$duitasuo_msg = mysql_query("SELECT * FROM duitasuomsg WHERE schoolid='$schoolid' ORDER BY timesubmit DESC $limit") OR die(mysql_query());
}
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
 
 $msg_userid = $row['userid'];
 $msg_ip = $row['ip'];
 
 if ($userid != 0 && $userid == $msg_userid) {
 $msgowner = 1;
 } else if ($userid == 0 && $msg_userid == 0 && $ip == $msg_ip){
 $msgowner = 1;
 } else {
 $msgowner = 0;
 }
 
 if ($msgowner == 1){
 echo "<div class='post_owner'>
       <h4 onselectstart='return false'><a id='gender_msg_".$msgid."' href='home.php?schoolid=".$schoolid."&gender=".$gender."'>".$gender."</a> 在 <a id='time_msg_".$msgid."' href='home.php?schoolid=".$schoolid."&time=".$time."'>".$time."</a>，<a id='place_msg_".$msgid."' href='home.php?schoolid=".$schoolid."&place=".$place."'>".$place."</a>：</h4>
       <div id='content_msg_".$msgid."'>
	   <p id='descr_msg_".$msgid."' class='post_descr_owner'>".$descr."</p>
       <p id='words_msg_".$msgid."' class='post_words_owner'>".$words."</p>   
	   </div>
	   <div id='content_msg_edit_".$msgid."' style='display:none'>
	   </div>";
 } else {
 echo "<div class='post'>
       <h4 onselectstart='return false'><a id='gender_msg_".$msgid."' href='home.php?schoolid=".$schoolid."&gender=".$gender."'>".$gender."</a> 在 <a id='time_msg_".$msgid."' href='home.php?schoolid=".$schoolid."&time=".$time."'>".$time."</a>，<a id='place_msg_".$msgid."' href='home.php?schoolid=".$schoolid."&place=".$place."'>".$place."</a>：</h4>
       <p id='descr_msg_".$msgid."' class='post_descr_girl'>".$descr."</p>
       <p id='words_msg_".$msgid."' class='post_words_girl'>".$words."</p>";
 }
       
 echo "<ul class='post_bottom' onselectstart='return false'>
       <li class='post_time'>".$timesubmit."</li>
       <li id='geili_".$msgid."' class='post_time'>".$likes."</li>
       <a><li class='post_action' id='leave_comment_".$msgid."' onclick='leave_comment(".$msgid.")' onmouseover=this.className='post_action_onmouseover' onmouseout=this.className='post_action'>留言</li></a>";
       
       if ($userid != 0){       
       $geili_result = mysql_query("SELECT * FROM duitasuogeili WHERE userid='$userid' AND msgid='$msgid'") or die();
       $geili_row = mysql_fetch_assoc($geili_result);
       if ($geili_row['geili'] == "1") {
       echo "<a><li class='post_action' id='like_msg_".$msgid."' onclick='like_msg(".$msgid.")' onmouseover=this.className='post_action_onmouseover' onmouseout=this.className='post_action'>不给力</li></a>";
       } else {
       echo "<a><li class='post_action' id='like_msg_".$msgid."' onclick='like_msg(".$msgid.")' onmouseover=this.className='post_action_onmouseover' onmouseout=this.className='post_action'>给力</li></a>";
       }       
       }
       else {
       $geili_result = mysql_query("SELECT * FROM duitasuogeili WHERE userid='0' AND ip='$ip' AND msgid='$msgid'") or die();
       $geili_row = mysql_fetch_assoc($geili_result);
       if ($geili_row['geili'] == "1") {
       echo "<a><li class='post_action' id='like_msg_".$msgid."' onclick='like_msg(".$msgid.")' onmouseover=this.className='post_action_onmouseover' onmouseout=this.className='post_action'>不给力</li></a>";
       } else {
       echo "<a><li class='post_action' id='like_msg_".$msgid."' onclick='like_msg(".$msgid.")' onmouseover=this.className='post_action_onmouseover' onmouseout=this.className='post_action'>给力</li></a>";
       }
       }
	   
 echo "<a href='javascript:void(0);'><li class='post_action' onclick='feed_link_renren(".$msgid.")' onmouseover=this.className='post_action_onmouseover' onmouseout=this.className='post_action'>告诉人人好友</li></a>"; 
 
 if ($msgowner == 1){
 echo "<a><li class='post_action' id='edit_msg_".$msgid."' onclick='edit_msg(".$msgid.")' onmouseover=this.className='post_action_onmouseover' onmouseout=this.className='post_action'>修改</li></a>
       <a><li class='post_action' id='cancel_msg_".$msgid."' onclick='cancel_msg(".$msgid.",".$schoolid.")' onmouseover=this.className='post_action_onmouseover' onmouseout=this.className='post_action'>删除通告</li></a>";
 }
 echo "</ul>
       
       <div id='leave_comment_input_".$msgid."' onselectstart='return false'>
       </div>
       
       <div id='comments_".$msgid."' class='comments'>";

$duitasuo_comment = mysql_query("SELECT * FROM duitasuocomment WHERE msgid='$msgid' ORDER BY timesubmit ASC;") OR die(mysql_query());
while ($row_comment = mysql_fetch_assoc($duitasuo_comment))
{ 
 $comment_userid = $row_comment['userid'];
 $comment_comment = $row_comment['comment'];
 $comment_id = $row_comment['id'];  
 $timeago_comment = $timenow - $row_comment['timesubmit'];
 		if ($timeago_comment < 60){
 		$timesubmit_comment = "刚刚更新";
 		}
   		else if ($timeago_comment < 3600){
   		$timesubmit_comment = (int)($timeago_comment/60);
   		$timesubmit_comment = $timesubmit_comment."分钟之前";
   		}
   		else if ($timeago_comment < 86400){
   		$timesubmit_comment = (int)($timeago_comment/3600);
   		$timesubmit_comment = $timesubmit_comment."小时之前";
   		}
   		else if ($timeago_comment >= 86400){
   		$timesubmit_comment = (int)($timeago_comment/86400);
   		$timesubmit_comment = $timesubmit_comment."天之前";
   		}
 
 $duitasuo_comment_user = mysql_query("SELECT * FROM users WHERE id='$comment_userid' ORDER BY id ASC;") OR die(mysql_query());      
 $row_comment_user = mysql_fetch_assoc($duitasuo_comment_user);
 $comment_username = $row_comment_user['username'];
 
 $comment_likes = $row_comment['likes'];
 if ($comment_likes == 0){
 $comment_likes = "不给力";
 }
 else {
 $comment_likes = $comment_likes."个给力";
 } 
 
 $comment_ip = $row_comment['ip'];
 
 if ($userid != 0 && $userid == $comment_userid) {
 $commentowner = 1;
 } else if ($userid == 0 && $comment_userid == 0 && $ip == $comment_ip){
 $commentowner = 1;
 } else {
 $commentowner = 0;
 }
 
 if ($commentowner == 1){
 echo "<div id='comment_".$comment_id."' onmouseover='show_comment_bottom(".$comment_id.",1)' onmouseout='unshow_comment_bottom(".$comment_id.")'>";
 } else if ($comment_userid != 0){
 echo "<div id='comment_".$comment_id."' onmouseover='show_comment_bottom(".$comment_id.",2)' onmouseout='unshow_comment_bottom(".$comment_id.")'>";
 }
 else {
 echo "<div id='comment_".$comment_id."' onmouseover='show_comment_bottom(".$comment_id.",3)' onmouseout='unshow_comment_bottom(".$comment_id.")'>";
 }
 
 if ($commentowner == 1){
 echo "<p class='comment_owner' >
       我 说：".$comment_comment."</p>";
 } else if ($comment_userid != 0){
 echo "<p class='comment_id' >
       ".$comment_username." 说：".$comment_comment."</p>";
 } else {
 echo "<p class='comment_noid' >
       ".$comment_username." 说：".$comment_comment."</p>";
 }
 
 echo "<ul id='comment_bottom_".$comment_id."' class='comment_bottom_none' onselectstart='return false' >";
 
 echo "<li class='post_time'>".$timesubmit_comment."</li>
       <li id='geili_comment_".$comment_id."' class='post_time'>".$comment_likes."</li>";
        
       if ($userid != 0){       
       $geili_comment_result = mysql_query("SELECT * FROM duitasuocommentgeili WHERE userid='$userid' AND commentid='$comment_id'") or die();
       $geili_comment_row = mysql_fetch_assoc($geili_comment_result);
       if ($geili_comment_row['geili'] == "1") {
       echo "<a><li class='post_action' id='like_comment_".$comment_id."' onclick='like_comment(".$comment_id.")' onmouseover=this.className='post_action_onmouseover' onmouseout=this.className='post_action'>不给力</li></a>";
       } else {
       echo "<a><li class='post_action' id='like_comment_".$comment_id."' onclick='like_comment(".$comment_id.")' onmouseover=this.className='post_action_onmouseover' onmouseout=this.className='post_action'>给力</li></a>";
       }       
       }
       else {
       $geili_comment_result = mysql_query("SELECT * FROM duitasuocommentgeili WHERE userid='0' AND ip='$ip' AND commentid='$comment_id'") or die();
       $geili_comment_row = mysql_fetch_assoc($geili_comment_result);
       if ($geili_comment_row['geili'] == "1") {
       echo "<a><li class='post_action' id='like_comment_".$comment_id."' onclick='like_comment(".$comment_id.")' onmouseover=this.className='post_action_onmouseover' onmouseout=this.className='post_action'>不给力</li></a>";
       } else {
       echo "<a><li class='post_action' id='like_comment_".$comment_id."' onclick='like_comment(".$comment_id.")' onmouseover=this.className='post_action_onmouseover' onmouseout=this.className='post_action'>给力</li></a>";
       }
       }
 
 if ($msgowner == 1 && $commentowner == 0){      
 echo "<a><li class='post_action' onclick='open_pmsg(".$comment_id.",\"".$comment_username."\",".$comment_userid.",\"".$comment_ip."\",".$msgid.")' onmouseover=this.className='post_action_onmouseover' onmouseout=this.className='post_action'>发私人信</li></a>
      <a><li class='post_action' onclick='cancel_comment(".$comment_id.")' onmouseover=this.className='post_action_onmouseover' onmouseout=this.className='post_action'>删除留言</li></a>";
 } else if ($commentowner == 1){
 echo "<a><li class='post_action' onclick='cancel_comment(".$comment_id.")' onmouseover=this.className='post_action_onmouseover' onmouseout=this.className='post_action'>删除留言</li></a>";
 }  
       
 echo "</ul>
       </div>";
 
}   
       
 echo  "</div>
       </div>";

}

if (isset($getgender)){
} else if (isset($gettime)){
} else if (isset($getplace)){
} else {
if ($lastPage != "1" && $pn != $lastPage){
    echo "<a id='nextpage' class='nextpage' onclick=refresh_duitasuo(".$pn.",'".$schoolid."')>更多惊喜</a>";
    }
}
	
?>       
</div>
</div>

</div>

<div id="sidebar" class="sidebar">
<div id="sidebar_box" class="sidebar_box">

<div id="location">
<b><font color="#6A6A6A"><?php echo $username ?></font></b> 正在学校: 
<b><font color="#6A6A6A"><?php echo $schoolname ?></font></b> (<a href='index.php'>离开学校</a>)
</div>

<div id="renren_connect">
<div class="renren_connect_box">
<?php 
if (isset($_COOKIE[$API_KEY.'_user'])){
?>
<p class="renren_connect_pic"><xn:profile-pic uid="loggedinuser" size="tiny" linked="true" connect-logo="false"></xn:profile-pic></p>
<p class="renren_connect_username">人人网登录：<xn:name uid="loggedinuser"></xn:name></p><br>
<p class="renren_connect_logout"><xn:login-button autologoutlink="true"></xn:login-button></p>
<?php
} else {
?>
<p class="renren_connect_login"><xn:login-button autologoutlink="true"></xn:login-button></p>
<?php
}
?>
</div>
</div>

<div id="schoollikes">
<span class="schoollikes_name"><b><?php echo $schoolname ?></b> 人品：</span>
<?php 
echo "<iframe scrolling='no' frameborder='0' allowtransparency='true' src='http://www.connect.renren.com/like?url=http%3A%2F%2Fwww.duitasuo.com%2Fhome.php%3Fschoolid%3D".$schoolid."&showfaces=false' style='width: 120px;height: 22px;'></iframe>"; 
?>
</div>

<div id="schoolshares">
<span class="schoolshares_name"><b><?php echo $schoolname ?></b> 分享：</span>
<?php 
echo "<a name='xn_share' type='button_count_right' href='http://www.duitasuo.com/home.php?schoolid=".$schoolid."'>分享</a>
<script src='http://static.connect.renren.com/js/share.js' type='text/javascript'>
</script>";
?>
</div>

<div id="renren_live_talk">
<xn:live-stream xid="test_xid" width="316" height="280"></xn:live-stream>
<?php
/*
echo "<iframe scrolling='no' frameborder='0' src='http://www.connect.renren.com/widget/liveWidget?api_key=ca131a518fd642d0b20a72a897648aac&xid=".$schoolname."&desp=%E5%A4%A7%E5%AE%B6%E6%9D%A5%E8%AE%A8%E8%AE%BA' style='width: 316px;height: 280px;'></iframe>";
*/
?>
</div>

<!-- 暂时取消功能
<div id="renren_guanzhu">
<iframe scrolling="no" frameborder="0" src="http://widget.renren.com/fanBoxWidget?appId=139738&pageImg=true&pageName=true&pageFriend=true&characterColor=ff0000&linkColor=255&borderColor=0&mainBackground=0&subBackground=0&desc=%E5%85%B3%E6%B3%A8%E6%9C%80%E6%96%B0%E5%8A%A8%E6%80%81" style="width: 316px;height: 170px;"></iframe>
</div>
-->

<div id="top_msgs">
<h2><?php echo $schoolname ?> 通告 前十名 </h2>
<div id="top_posts">
<?php 

$top_posts_num = 0;
$timenow = time();
$top_duitasuo_msg = mysql_query("SELECT * FROM duitasuomsg WHERE schoolid='$schoolid' ORDER BY likes DESC") OR die(mysql_query());
while ($top_row = mysql_fetch_assoc($top_duitasuo_msg))
{
 $gender = $top_row['gender'];
 $time = $top_row['time'];
 $place = $top_row['place'];
 $descr = $top_row['descr'];
 $words = $top_row['words'];
 $timeago = $timenow - $top_row['timesubmit'];
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
 $likes = $top_row['likes'];
 if ($likes == 0){
 $likes = "不给力";
 }
 else {
 $likes = $likes."个给力";
 }
 $msgid = $top_row['id'];
 
 echo "<div class='top_post'>
 
       <h4 onselectstart='return false'><a href='home.php?schoolid=".$schoolid."&gender=".$gender."'>".$gender."</a> 在 <a href='home.php?schoolid=".$schoolid."&time=".$time."'>".$time."</a>，<a href='home.php?schoolid=".$schoolid."&place=".$place."'>".$place."</a>：</h4>
       <p class='top_post_descr'>".$descr."</p>
       <p class='top_post_words'>".$words."</p>
       
       <ul class='top_post_bottom' onselectstart='return false'>
       <li class='top_post_time'>".$timesubmit."</li>
       <li id='geili_".$msgid."' class='top_post_geili'>".$likes."</li>
       </ul>
       
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

<br clear="left" />
<div id="new_notification" ></div>
<div id="new_message" ></div>

<div id="campus_search"> 
<input type="text" id="campus_search_input" onkeyup="campus_search()" oninput="campus_search()" onpropertychange="campus_search()" onfocus="if(this.value=='请输入你要找的学校...'){this.value=''}; this.style.color='black';" onblur="if(this.value==''){this.value='请输入你要找的学校...'; this.style.color='black';};" value="请输入你要找的学校..."/>
<span id="search_results">
</span> 
</div>

</div>


<div id="login_signup" class="login_signup">

<div class="login">
<div class="login_box">
<div id="login_form">
<h2>登录</h2>
<?php
if (isset($_SESSION['id']))
      {
      if ($renren_bangdingcheck == 1){
	  echo "<div id='login_successful'>人人绑定登录：".$_SESSION['username']."   (<a href='home_cancel_bangding.php?schoolid=".$schoolid."'>取消绑定</a>)</div>";
      } else {
	  echo "<div id='login_successful'>您已经登录：".$_SESSION['username']."   (<a href='home_logout.php?schoolid=".$schoolid."'>退出</a>)</div>";
      }
	  echo "<div class='buttons'>
      <p class='cancel_login_button2' onclick=close_signup()>取消</p>
      </div>
	  <div id='login_message'></div>";
      }
      else
      {
      ?>
<div id="login_field">
帐号：<input type="text" style="width: 195px; color: #999;" id="login_email" value="用户邮箱" onfocus="if(this.value=='用户邮箱'){this.value=''}; this.style.color='black';" onblur="if(this.value==''){this.value='用户邮箱'; this.style.color='#999';};">
密码：<input type="password" style="width: 195px;" id="login_password">
<div class="savepassword">
<form name="autologinform" title="为了确保您的信息安全，请不要在网吧或者公共机房勾选此项！" class="logincheckbox">
<input type="checkbox" name="autologin" id="autologin" value="1" />下次自动登录
</form>
</div>
<div class="buttons">
<?php echo "<p id='login_button' class='login_button' onclick=login(".$schoolid.")>登录</p>"; ?>
<p class="cancel_login_button" onclick="close_signup()">取消</p>
</div>
<div id="login_message">
</div>
</div>
<?php
}
?>
</div>
</div>
</div>

<div class="signup">
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

</div>

<div id="private_msg" class="private_msg">
<div class="private_msg_box">
<div class="login_box">
<div id="private_msg_form">
<h2>私人邮件</h2>
<div id="private_msg_field">
</div>
</div>
</div>
</div>
</div>

<div id="chat_animation" class="chat_animation" onselectstart='return false'>
<div class="chat_animation_shade">
<div class="chat_animation_box">
<div class="refresh_others_pn" title="查看下一组用户" onclick="chat_animation_others()"></div>
<div id="chat_animation_background" onmousedown="chat_animation_click_move(event)"> 
<div class="kfc_logo" title="欢迎大家光临肯德基！"></div>
<div class="nba_logo" title="喜欢NBA的朋友就过来！"></div>
<div class="houstonrockets_logo" title="我们一起支持火箭！支持姚明！"></div>
<div id="chat_animation_user" class="chat_animation_user">
<div id="chat_animation_user_pic" class="chat_animation_user_pic" title="我在这里！"></div>
<div id="chat_animation_user_name" class="chat_animation_user_name" title="这是我的名字！"></div>
</div>
<div id="redflag">
</div>
<div id="chat_animation_other_users"></div>
</div>
</div>
</div>
</div>

<!---
<div id="send_gift" class="send_gift">

<div class="send_gift_main">
<div class="login_box">
<div id="private_msg_form">
<h2>送礼物</h2>
<div id="send_gift_field">
</div>
</div>
</div>
</div>

<div class="send_gift_pic">
<div class="login_box">
<div id="send_gift_pic_form">
<h2><div id="send_gift_pic_name">礼物照片</div></h2>
<div id="send_gift_pic_field" style="height: 235px;">
</div>
</div>
</div>
</div>

</div>
--->

<div id="copyright">
Koollo Kingdom Inc. &copy; 2011
</div>

</div>

<div id="bottombar" class="chat_bottom" onclick="show_chat_panel()" onmouseover="if(this.className=='chat_bottom'){this.className='chat_bottom_onmouseover'};" onmouseout="if(this.className=='chat_bottom_onmouseover'){this.className='chat_bottom'};" onselectstart='return false'>
<div id="chat">在线用户</div>
<div id="chat_friends"></div>
</div>

<div id="chat_panel" onselectstart='return false'>
<div class='chat_panel_head'>
<div class='chatbox_name'>在线用户</div>
<div class='chatbox_close' onmouseover=this.className='chatbox_close_onmouseover' onmouseout=this.className='chatbox_close' onclick='show_chat_panel()'>-</div>
</div>
<div id="chat_panel_users"></div>
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
	
	function feed_link_renren(id){
    XN_RequireFeatures(["EXNML"], function()
    {
      XN.Main.init("ca131a518fd642d0b20a72a897648aac", "/xd_receiver.html");
      XN.Connect.requireSession(sendFeed(id));   
    });
    }
	
	function sendFeed(id){
	var schoolid = "<?php echo $schoolid ?>";
	var schoolname = "<?php echo $schoolname ?>";
	var gender = document.getElementById("gender_msg_"+id+"").innerHTML;
	var time = document.getElementById("time_msg_"+id+"").innerHTML;
	var place = document.getElementById("place_msg_"+id+"").innerHTML;
	var descr = document.getElementById("descr_msg_"+id+"").innerHTML;
	var words = document.getElementById("words_msg_"+id+"").innerHTML;
	var content = time+"，我在"+place+"看到一个"+gender+"。"+descr+" "+words;
	
  		feedSettings = {
  			"template_bundle_id": 1,
			"template_data": {"images":[{"src":"http://www.duitasuo.com/images/tuitasuo_logo.jpg","href":"http://www.duitasuo.com/home.php?schoolid="+schoolid+""}], "site":"<a href=\"http://www.duitasuo.com\">对ta说</a>","feedtype":""+schoolname+"","content":""+content+"","action":"click"},
  			"user_message_prompt": "邀请大家都来看看吧！",
  			"user_message": "好精彩啊！快来看看！"
  		};
  		XN.Connect.showFeedDialog(feedSettings);
  	}
</script>
</body>
</html>