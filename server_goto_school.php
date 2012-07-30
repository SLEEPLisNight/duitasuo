<?php
include 'connect_to_mysql.php';

$schoolid=$_GET["id"];

$result = mysql_query("SELECT * FROM schools WHERE id='$schoolid' ORDER BY id ASC;") or die();
$row =  mysql_fetch_array($result);
$schoolname = $row['schoolname'];

$_SESSION['schoolname'] = $schoolname;
$_SESSION['schoolid'] = $schoolid;

?>