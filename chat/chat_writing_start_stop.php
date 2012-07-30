<?php
include '../connect_to_mysql.php';
if (isset($_SESSION['id'])){
$userid = $_SESSION['id']; // assign SESSION 'id' value to $userid.
} else {
$userid = 0;
}
$userchatid = $_SESSION['chatid'];
$touserid = $_GET['otherid'];
$touserchatid = $_GET['otherchatid'];
$writing = $_GET['writing'];

if ($writing == 1){
$result = mysql_query("SELECT * FROM chatwriting WHERE userid='$userid' AND userchatid='$userchatid' AND touserid='$touserid' AND touserchatid='$touserchatid' ORDER BY id ASC;") or die();
$number = mysql_num_rows($result);
if ($number > 0) {
$row = mysql_fetch_array($result);
mysql_query("UPDATE chatwriting SET writing='1' WHERE userid='$userid' AND userchatid='$userchatid' AND touserid='$touserid' AND touserchatid='$touserchatid'") or die(mysql_error());
}
else {
mysql_query("INSERT INTO chatwriting (userid,userchatid,touserid,touserchatid,writing) VALUES('$userid','$userchatid','$touserid','$touserchatid','1')") or die(mysql_error());
}

}
else {
mysql_query("UPDATE chatwriting SET writing='0' WHERE userid='$userid' AND userchatid='$userchatid' AND touserid='$touserid' AND touserchatid='$touserchatid'") or die(mysql_error());
}	

?>