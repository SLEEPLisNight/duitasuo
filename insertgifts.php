<?php
include 'connect_to_mysql.php';
$name = $_GET['name'];
$descr = $_GET['descr'];
$price = $_GET['price'];
mysql_query("INSERT INTO gifts (name,descr,price) VALUES('$name','$descr','$price')") or die(mysql_error()); 
?>