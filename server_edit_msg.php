<?php
include 'connect_to_mysql.php';
$id = $_GET['id'];

function replace_br($str) 
{	
	$str = str_replace(" ","",$str);
    return $str;
}

$duitasuo_msg = mysql_query("SELECT * FROM duitasuomsg WHERE id='$id'") OR die(mysql_query());
$row = mysql_fetch_assoc($duitasuo_msg);
$descr = replace_br($row['descr']);
$words = replace_br($row['words']);

echo $descr."|".$words;

?>