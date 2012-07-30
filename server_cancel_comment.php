<?php
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';  // connect to mysql database.

$cmtid = $_GET['cmtid'];

mysql_query ("DELETE FROM duitasuocomment WHERE id='$cmtid'") or die(mysql_error());

?>