<?php
include '../connect_to_mysql.php'; 
if (isset($_SESSION['id'])){
$userid = $_SESSION['id']; // assign SESSION 'id' value to $userid.
} else {
$userid = 0;
}
$userchatid = $_SESSION['chatid'];
$schoolid = $_SESSION['schoolid'];

$h = 0;
$result = mysql_query("SELECT * FROM chatname WHERE userchatid != '$userchatid' AND schoolid = '$schoolid' ORDER BY id ASC;") or die();
while($row = mysql_fetch_array($result)){
$num[$h] = $row['id'];	
$xpos[$h] = $row['xpos'];	
$ypos[$h] = $row['ypos'];
$h++;
}

$i = (int)$_GET['i'];
echo $num[$i]."|".$xpos[$i]."|".$ypos[$i];

?>