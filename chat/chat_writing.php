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

$result = mysql_query("SELECT * FROM chatwriting WHERE userid='$touserid' AND userchatid='$touserchatid' AND touserid='$userid' AND touserchatid='$userchatid' ORDER BY id ASC;") or die();
$number = mysql_num_rows($result);
if ($number > 0) {
$row = mysql_fetch_array($result);
$writing = $row['writing'];
if ($writing == 1){
echo "1";
}
else {
echo "0";
}

}
else {
echo "0";
}	

?>