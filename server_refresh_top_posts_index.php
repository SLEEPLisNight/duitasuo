<?php
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';  // connect to mysql database.

$top_posts_num = 0;
$timenow = time();
$duitasuo_msg = mysql_query("SELECT * FROM duitasuomsg WHERE newmsg = 0 ORDER BY timesubmit DESC") OR die(mysql_query());
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

 echo "<div class='top_post_firstchild'>
 
       <h4 onselectstart='return false'><a href='home.php?schoolid=".$msg_schoolid."'>".$msg_schoolname."</a> 的 <a href=''>".$gender."</a> 在 <a href=''>".$time."</a>，<a href=''>".$place."</a>：</h4>
       <p class='descr'>".$descr."</p>
       <p class='words'>".$words."</p>
       
       <ul class='top_post_bottom' onselectstart='return false'>
       <li class='top_post_time'>".$timesubmit."</li>
       <li id='geili_".$msgid."' class='top_post_geili'>".$likes."</li>
       </ul>
       
       </div>";
       
  $top_posts_num++;
  if ($top_posts_num >0){
   break;
  }     
  
}

if ($top_posts_num == 0){
echo "nonewposts";
}

?>