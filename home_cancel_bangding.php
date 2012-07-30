<?php
include 'connect_to_mysql.php'; 
$userid = $_SESSION['id'];
mysql_query("UPDATE users SET renrenuserid = 0 WHERE id = $userid") or die(mysql_error());  

$schoolid = $_GET['schoolid']; 
header("Location: home.php?schoolid=".$schoolid."");
?>