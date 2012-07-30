<?php
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';  // connect to mysql database.

$pmsgid = $_GET['pmsgid'];

mysql_query ("UPDATE duitasuopmsg SET block = 1 WHERE id='$pmsgid'") or die(mysql_error());

?>