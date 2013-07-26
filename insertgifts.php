<?php
include 'connect_to_mysql.php';
$name = mysql_real_escape_string($_GET['name']);
$descr = mysql_real_escape_string($_GET['descr']);
$price = mysql_real_escape_string($_GET['price']);
mysql_query("INSERT INTO gifts (name,descr,price) VALUES('$name','$descr','$price')") or die(mysql_error()); 
?>
