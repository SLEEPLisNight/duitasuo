<?php
include '../connect_to_mysql.php'; 

$userchatid = $_SESSION['chatid'];
$schoolid = $_SESSION['schoolid'];

$h = 0;
$result = mysql_query("SELECT * FROM chatname WHERE userchatid != '$userchatid' AND schoolid = '$schoolid' ORDER BY id ASC;") or die();
while($row = mysql_fetch_array($result)){
$num[$h] = $row['id'];	
$otheruserid[$h] = $row['userid'];	
$h++;
}

$i = (int)$_GET['i'];
$timenow = time();
$x = 0;
$msg = "";
if ($otheruserid[$i] != 0){
$msg_result = mysql_query("SELECT * FROM duitasuomsg WHERE userid = '$otheruserid[$i]' ORDER BY timesubmit DESC;") or die();
while($msg_row = mysql_fetch_array($msg_result)){
$otherschoolid = $msg_row['schoolid'];	
$schools_result = mysql_query("SELECT * FROM schools WHERE id = '$otherschoolid' ORDER BY id ASC;") or die();
$schools_row = mysql_fetch_array($schools_result);
$otherschoolname[$x] = $schools_row['schoolname'];	

$othergender[$x] = $msg_row['gender'];	
$othertime[$x] = $msg_row['time'];	
$otherplace[$x] = $msg_row['place'];	
$otherdescr[$x] = $msg_row['descr'];	
$otherwords[$x] = $msg_row['words'];

$timeago = $timenow - $msg_row['timesubmit'];
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

$msg = $msg.		
$x++；
}
} else {
$msg = "对方是匿名登录，无法显示对方的留言。";
}

echo $num[$i]."|".$msg;

?>