<?php
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';
$id = intval($_GET['id']);
$priority = $_GET['priority'];

$number = 0;
$result = mysql_query("SELECT * FROM words WHERE id > '$id' AND priority <= '$priority' ORDER BY id ASC;") or die();
while ($row = mysql_fetch_assoc($result)){
echo $row['title']."|".$row['descr']."|".$row['latitude']."|".$row['longitude']."|".$row['id']."|".$row['priority'];
$number = 1;
break;
}

if ($number == 0){
echo "";
}

?>