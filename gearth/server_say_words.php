<?php
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';

function utf8_urldecode($str) 
{	
	$str = htmlspecialchars($str, ENT_QUOTES);
	$str = mysql_real_escape_string($str);
	return $str;
}	

$title = $_GET['title'];
$descr = utf8_urldecode($_GET['descr']);
$la = $_GET['la'];
$lo = $_GET['lo'];
$priority = $_GET['priority'];
$time = time();

$sql_insert = mysql_query("INSERT INTO words (userid,title,descr,latitude,longitude,priority,time) VALUES('0','$title','$descr','$la','$lo','$priority','$time')") or die(mysql_error()); 

echo "good";

?>