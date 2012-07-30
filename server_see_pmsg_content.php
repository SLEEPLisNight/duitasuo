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

$pmsgid = $_GET['pmsgid'];
$updateread = $_GET['updateread'];

if ($updateread == 1){
mysql_query ("UPDATE duitasuopmsg SET readit = 1 WHERE id='$pmsgid'") or die(mysql_error());
mysql_query ("UPDATE duitasuopmsgreply SET readit = 1 WHERE pmsgid='$pmsgid'") or die(mysql_error());
}

$duitasuo_pmsg = mysql_query("SELECT * FROM duitasuopmsg WHERE id='$pmsgid' ORDER BY id ASC;") OR die(mysql_query());
$row = mysql_fetch_assoc($duitasuo_pmsg);

 $pmsgid = $row['id'];
 $msgid = $row['msgid'];
 $cmtid = $row['cmtid'];
 $touserid = $row['touserid'];
 $touserip = $row['touserip'];
 $fromuserid = $row['userid'];
 $fromuserip = $row['userip'];
 $title = $row['title'];
 $content = $row['content'];
 $timesubmit = $row['timesubmit'];
 $readit = $row['readit'];
 $block = $row['block'];
 
 if ($userid != 0 && $userid == $touserid) {
 $pmsgreceiver = 1;
 $otheruserid = $fromuserid;
 $otheruserip = $fromuserip;
 } else if ($userid != 0 && $userid == $fromuserid) {
 $pmsgreceiver = 0;
 $otheruserid = $touserid;
 $otheruserip = $touserip;
 } else if ($userid == 0 && $touserid == 0 && $ip == $touserip){
 $pmsgreceiver = 1;
 $otheruserid = $fromuserid;
 $otheruserip = $fromuserip;
 } else if ($userid == 0 && $fromuserid == 0 && $ip == $fromuserip){
 $pmsgreceiver = 0;
 $otheruserid = $touserid;
 $otheruserip = $touserip;
 } 
 
 $duitasuo_pmsg_user = mysql_query("SELECT * FROM users WHERE id='$otheruserid' ORDER BY id ASC;") OR die(mysql_query());      
 $row_pmsg_user = mysql_fetch_assoc($duitasuo_pmsg_user);
 $otherusername = $row_pmsg_user['username'];
 
 $sendpmsgtime = date('Y-m-d g:ia',strtotime("-4 hour",$timesubmit));
 
 echo "<div id='pmsg_rows_form'>
       <h3>主题： ".$title."</h3>
       <h4>参与人： ".$otherusername." 与 你</h4>";
 
 $duitasuo_msg = mysql_query("SELECT * FROM duitasuomsg WHERE id='$msgid' ORDER BY id ASC;") OR die(mysql_query());
 $row_msg = mysql_fetch_assoc($duitasuo_msg);
 
 $gender_msg = $row_msg['gender'];
 $time_msg = $row_msg['time'];
 $place_msg = $row_msg['place'];
 $descr_msg = $row_msg['descr'];
 $words_msg = $row_msg['words'];
 $timesubmit_msg = $row_msg['timesubmit'];
 
 $sendmsgtime = date('Y-m-d g:ia',strtotime("-4 hour",$timesubmit_msg));
 
 echo "<div class='pmsg_originalmsg'>
       <h5 onselectstart='return false'><a href='home.php?schoolid=".$schoolid."&gender=".$gender_msg."'>".$gender_msg."</a> 在 <a href='home.php?schoolid=".$schoolid."&time=".$time_msg."'>".$time_msg."</a>，<a href='home.php?schoolid=".$schoolid."&place=".$place_msg."'>".$place_msg."</a>：</h5>
       <p class='pmsg_originalmsg_descr'>".$descr_msg."</p>
       <p class='pmsg_originalmsg_words'>".$words_msg."</p>
       <ul class='post_bottom' onselectstart='return false'>
       <li class='pmsg_originalmsg_post_time'>".$sendmsgtime."</li>
       </ul>
       
       <div id='comments_".$msgid."' class='comments'>";
 
 $duitasuo_comment = mysql_query("SELECT * FROM duitasuocomment WHERE id='$cmtid' ORDER BY id ASC;") OR die(mysql_query());
 $row_comment = mysql_fetch_assoc($duitasuo_comment);
  
 $comment_userid = $row_comment['userid'];
 $comment_comment = $row_comment['comment'];
 $comment_timesubmit = $row_comment['timesubmit']; 
 
 $sendcommenttime_date = date('Y-m-d',strtotime("-4 hour",$comment_timesubmit));
 $sendcommenttime_time = date('g:ia',strtotime("-4 hour",$comment_timesubmit));
 
 $duitasuo_comment_user = mysql_query("SELECT * FROM users WHERE id='$comment_userid' ORDER BY id ASC;") OR die(mysql_query());      
 $row_comment_user = mysql_fetch_assoc($duitasuo_comment_user);
 $comment_username = $row_comment_user['username'];
 
 echo "<p class='comment_noid'>
       ".$comment_username." 在 ".$sendcommenttime_date." ".$sendcommenttime_time." 对以上消息的留言：".$comment_comment."</p>
       </div>
       </div>";
       
 $duitasuo_pmsg_fromuser = mysql_query("SELECT * FROM users WHERE id='$fromuserid' ORDER BY id ASC;") OR die(mysql_query());      
 $row_pmsg_fromuser = mysql_fetch_assoc($duitasuo_pmsg_fromuser);
 $fromusername = $row_pmsg_fromuser['username'];
      
 echo "<div class='pmsgs'>
       <h6 onselectstart='return false'>".$fromusername." 发于 ".$sendpmsgtime.":</h6>
       <p>".$content."</p>
       </div>";
       
 echo "<div id='pmsg_replys'>";  
 
 $duitasuo_pmsg_reply = mysql_query("SELECT * FROM duitasuopmsgreply WHERE pmsgid='$pmsgid' ORDER BY timesubmit ASC;") OR die(mysql_query());
 while ($row_pmsg_reply = mysql_fetch_assoc($duitasuo_pmsg_reply))
 {
 $pmsg_reply_fromuserid = $row_pmsg_reply['userid'];
 $pmsg_reply_timesubmit = $row_pmsg_reply['timesubmit'];
 $pmsg_reply_content = $row_pmsg_reply['content'];
 
 $duitasuo_pmsg_reply_fromuser = mysql_query("SELECT * FROM users WHERE id='$pmsg_reply_fromuserid' ORDER BY id ASC;") OR die(mysql_query());      
 $row_pmsg_reply_fromuser = mysql_fetch_assoc($duitasuo_pmsg_reply_fromuser);
 $pmsg_reply_fromusername = $row_pmsg_reply_fromuser['username'];
 
 $replypmsgtime = date('Y-m-d g:ia',strtotime("-4 hour",$pmsg_reply_timesubmit));
 
 echo "<div class='pmsgs'>
       <h6 onselectstart='return false'>".$pmsg_reply_fromusername." 发于 ".$replypmsgtime.":</h6>
       <p>".$pmsg_reply_content."</p>
       </div>";
 }
 
 echo "</div>";    
       
 if ($block == 0){      
 echo "<div id='reply_pmsg' onselectstart='return false'> 
       <textarea rows='3' type='text' id='reply_pmsg_text' class='reply_pmsg_textarea'></textarea>  
       <a id='reply_pmsg_button' class='leave_comment_input_submit' onclick='reply_pmsg(".$pmsgid.",".$otheruserid.",\"".$otheruserip."\")'>发送</a>
       <a class='close_pmsg_button' onclick='set_pmsg_close_question(".$pmsgid.")'>关闭对话</a>
       <a class='close_pmsg_button' onclick='set_pmsg_unread(".$pmsgid.")'>标记未读</a>
       <a class='close_pmsg_button' onclick='see_pmsg()'>返回邮箱</a>
       </div>
       </div>";
 } else {
 echo "</div>
       <div class='close_pmsg' onselectstart='return false'>
       <div class='close_pmsg_notice'>此次私密通话已被关闭。</div>
       <a class='backto_pmsg_button' onclick='see_pmsg()'>返回邮箱</a>
       </div>";
 } 

?>