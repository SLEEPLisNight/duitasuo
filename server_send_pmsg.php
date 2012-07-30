<?php
include 'connect_to_mysql.php';
$userid = $_SESSION['id'];
if ($userid == ""){
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
 	   $msgid= $_GET['msgid'];
 	   $cmtid= $_GET['cmtid'];
 	   $touserid= $_GET['touserid'];
 	   $touserip= $_GET['touserip'];
	   $title = utf8_urldecode($_GET['title']);
 	   $content = utf8_urldecode($_GET['content']);
 	  
$sql_insert = mysql_query("INSERT INTO duitasuopmsg (msgid,cmtid,touserid,touserip,userid,userip,title,content,timesubmit,readit,block) VALUES('$msgid','$cmtid','$touserid','$touserip','$userid','$ip','$title','$content','$timesubmit','0','0')") or die(mysql_error());  

?>               