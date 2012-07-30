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
 	   $pmsgid= $_GET['pmsgid'];
 	   $touserid= $_GET['otheruserid'];
 	   $touserip= $_GET['otheruserip'];
 	   $content = utf8_urldecode($_GET['content']);
 	  
 $sql_insert = mysql_query("INSERT INTO duitasuopmsgreply (touserid,touserip,userid,userip,content,timesubmit,readit,pmsgid) VALUES('$touserid','$touserip','$userid','$ip','$content','$timesubmit','0','$pmsgid')") or die(mysql_error());  

 $result = mysql_query("SELECT * FROM duitasuopmsgreply WHERE touserid='$touserid' AND touserip='$touserip' AND userid='$userid' AND userip='$ip' AND timesubmit='$timesubmit'") or die();
 $row =  mysql_fetch_array($result);
 $content_reply = $row['content'];
 
 $duitasuo_pmsg_reply_fromuser = mysql_query("SELECT * FROM users WHERE id='$userid' ORDER BY id ASC;") OR die(mysql_query());      
 $row_pmsg_reply_fromuser = mysql_fetch_assoc($duitasuo_pmsg_reply_fromuser);
 $fromusername = $row_pmsg_reply_fromuser['username'];

 $replypmsgtime = date('Y-m-d g:ia',strtotime("-4 hour",$timesubmit));

 echo "<div class='pmsgs'>
       <h6 onselectstart='return false'>".$fromusername." 发于 ".$replypmsgtime.":</h6>
       <p>".$content_reply."</p>
       </div>";
       
?>   