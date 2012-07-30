<?php
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';
if (isset($_SESSION['id'])){
$userid = $_SESSION['id']; // assign SESSION 'id' value to $userid.
} else {
$userid = 0;
}
$ip = $_SESSION['ip'];
/*
function utf8_urldecode($str) {
			$str = nl2br($str);
	        $str = str_replace("'","\'",$str);
	        $str = str_replace("<","&lt;",$str);
    		$str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
    		return html_entity_decode($str,null,'gb2312');;
    		}	
			*/
function utf8_urldecode($str) 
{
	$str = htmlspecialchars($str, ENT_QUOTES);
	$str = mysql_real_escape_string($str);
	return $str;
}	
     
	   $timesubmit = time();
	   $schoolid = $_GET['schoolid'];
 	   $gender = utf8_urldecode($_GET['gender']);
 	   $time = utf8_urldecode($_GET['time']);
 	   $place = utf8_urldecode($_GET['place']);
	   $descr = utf8_urldecode($_GET['descr']);
	   $words = utf8_urldecode($_GET['words']);
	     
	   if ($place!="" && $descr!="" && $words!="" ){	 	   	
	   $sql_insert =  mysql_query("INSERT INTO duitasuomsg (gender,time,place,descr,words,timesubmit,likes,userid,schoolid,ip) VALUES('$gender','$time','$place','$descr','$words','$timesubmit','0','$userid','$schoolid','$ip')") or die(mysql_error());       
           } 
                   
	   $schoollikes = mysql_query("SELECT * FROM schools WHERE id='$schoolid'") OR die(mysql_query());
	   $row = mysql_fetch_assoc($schoollikes);
	   $likes = $row['likes'];
	   $likes++;
	   mysql_query ("UPDATE schools SET likes = '$likes' WHERE id='$schoolid'") or die(mysql_error());

?>