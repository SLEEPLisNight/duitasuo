<?php
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';
if (isset($_SESSION['id'])){
$userid = $_SESSION['id']; // assign SESSION 'id' value to $userid.
} else {
$userid = 0;
}
$ip = $_SESSION['ip'];

function utf8_urldecode($str) 
{
	$str = htmlspecialchars($str, ENT_QUOTES);
	$str = mysql_real_escape_string($str);
    return $str;
}
  		
	   $timesubmit = time();	
 	   $id= $_GET['id'];
	   $comment = utf8_urldecode($_GET['comment']);
 	   
	   $sql_insert =  mysql_query("INSERT INTO duitasuocomment (msgid,userid,comment,timesubmit,likes,ip,unread) VALUES('$id','$userid','$comment','$timesubmit','0','$ip','0')") or die(mysql_error());                 

$duitasuo_comment = mysql_query("SELECT * FROM duitasuocomment WHERE msgid='$id' AND comment='$comment' AND userid='$userid' AND ip='$ip' ORDER BY timesubmit DESC;") OR die(mysql_query());
while ($row_comment = mysql_fetch_assoc($duitasuo_comment))
{ 
 $comment_userid = $row_comment['userid'];
 $comment_comment = $row_comment['comment'];
 $comment_id = $row_comment['id'];  
 $timeago_comment = $timesubmit - $row_comment['timesubmit'];
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
 
 if ($commentowner == 1){
 echo "<ul id='comment_bottom_".$comment_id."' class='comment_bottom_none' onselectstart='return false' >";
 } else if ($comment_userid != 0){
 echo "<ul id='comment_bottom_".$comment_id."' class='comment_bottom_none' onselectstart='return false' >";
 }
 else {
 echo "<ul id='comment_bottom_".$comment_id."' class='comment_bottom_none' onselectstart='return false' >";
 }
 
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
 
 if ($commentowner == 1){
 echo "<a><li class='post_action' onclick='cancel_comment(".$comment_id.")' onmouseover=this.className='post_action_onmouseover' onmouseout=this.className='post_action'>删除留言</li></a>";
 }  
       
 echo "</ul>
       </div>";

 break;

}   
?>