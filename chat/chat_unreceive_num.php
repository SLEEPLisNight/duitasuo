<?php
include '../connect_to_mysql.php';
if (isset($_SESSION['id'])){
$userid = $_SESSION['id']; // assign SESSION 'id' value to $userid.
} else {
$userid = 0;
}

if (isset($_SESSION['chatid'])){
$userchatid = $_SESSION['chatid'];
} else {
$userchatid = 0;
}

$touserid = $_GET['otherid'];
$touserchatid = $_GET['otherchatid'];

$h = 0;
$result = mysql_query("SELECT * FROM chat WHERE userid='$touserid' AND userchatid='$touserchatid' AND touserid='$userid' AND touserchatid='$userchatid' AND recd = 0 AND confirm = 0 ORDER BY id ASC;") or die();
$number = mysql_num_rows($result);
if ($number > 0) {
   	while($row = mysql_fetch_array($result)){
	$id = $row['id'];
 	mysql_query("UPDATE chat SET recd = 1 WHERE id='$id'") or die(mysql_error());	
   	$h++;	
   	}
        
  echo $h;	
  } else {
  echo "received";
  }

?>