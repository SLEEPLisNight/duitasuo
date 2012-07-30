<?php
include 'connect_to_mysql.php';
$id = $_GET['id'];
$descr = $_GET['descr'];
$words = $_GET['words'];

function utf8_urldecode($str) 
{
	$str = htmlspecialchars($str, ENT_QUOTES);
	$str = mysql_real_escape_string($str);
    return $str;
}	

$descr = utf8_urldecode($descr);
$words = utf8_urldecode($words);
		
mysql_query ("UPDATE duitasuomsg SET descr='$descr', words='$words' WHERE id='$id'") or die(mysql_error());

$result = mysql_query("SELECT * FROM duitasuomsg WHERE id='$id'") or die();
$row =  mysql_fetch_array($result);
$descr_edit = $row['descr'];
$words_edit = $row['words'];
		
echo $descr_edit."|".$words_edit;

?>