<?php
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';  // connect to mysql database.
if (isset($_SESSION['id'])){
$userid = $_SESSION['id']; // assign SESSION 'id' value to $userid.
} else {
$userid = 0;
}
$ip = $_SESSION['ip'];
$schoolid = $_SESSION['schoolid'];

$sql = mysql_query("SELECT * FROM duitasuomsg WHERE schoolid='$schoolid' ORDER BY timesubmit DESC;") or die();
$nr = mysql_num_rows($sql); // Get total of Num rows from the database query
$pn = $_GET['pn']; 
$itemsPerPage = 5; 
$lastPage = ceil($nr / $itemsPerPage);

if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else {
$pn++; 
if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
} 
}
// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage; 

$timenow = time();
$duitasuo_msg = mysql_query("SELECT * FROM duitasuomsg WHERE schoolid='$schoolid' ORDER BY timesubmit DESC $limit") OR die(mysql_query());
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

$comment_color = "a";
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

if ($lastPage != "1" && $pn != $lastPage){
    echo "<div id='nextpage' class='nextpage' onclick=refresh_duitasuo(".$pn.",'".$schoolid."')>更多惊喜</div>";
    }
?>       