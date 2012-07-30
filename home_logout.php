<?php
include 'connect_to_mysql.php'; 
$userid = $_SESSION['id'];
mysql_query("UPDATE users SET autologin = '0' WHERE id = $userid") or die(mysql_error());  

$schoolid = $_GET['schoolid']; 
session_start();
session_destroy();

header("Location: home.php?schoolid=".$schoolid."");
?>