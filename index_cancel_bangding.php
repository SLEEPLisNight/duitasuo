<?php
include 'connect_to_mysql.php';  
$userid = $_SESSION['id'];
mysql_query("UPDATE users SET renrenuserid = 0 WHERE id = $userid") or die(mysql_error());  
header('Location: index.php');
?>