<?php
include 'connect_to_mysql.php';
$ip = $_SESSION['ip'];
$time = time();

$result_delete = mysql_query("SELECT * FROM duitasuoonline ORDER BY id ASC;") or die();
while ($row_delete = mysql_fetch_assoc($result_delete)){
$id_delete = $row_delete['id'];
$time_delete = $row_delete['time'];
if ($time - $time_delete > 300){
mysql_query("DELETE FROM duitasuogeili WHERE id ='$id_delete'") or die(mysql_error());
}
}

$result = mysql_query("SELECT * FROM duitasuoonline WHERE ip='$ip' ORDER BY id ASC;") or die();
$number = mysql_num_rows($result);
if ($number > 0) {
mysql_query ("UPDATE duitasuoonline SET time = '$time' WHERE ip='$ip'") or die(mysql_error());
} else {
mysql_query("INSERT INTO duitasuoonline (ip,time) VALUES('$ip','$time')") or die(mysql_error());
}

?>