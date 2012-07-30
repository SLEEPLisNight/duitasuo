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
$schoolid = $_SESSION['schoolid'];

$h = 0;
$result = mysql_query("SELECT * FROM chat WHERE userid='$touserid' AND userchatid='$touserchatid' AND touserid='$userid' AND touserchatid='$userchatid' AND recd = 0 AND confirm = 0 ORDER BY id ASC;") or die();
$number = mysql_num_rows($result);
if ($number > 0) {
   	while($row = mysql_fetch_array($result)){
   	$chatwith_result = mysql_query("SELECT * FROM chatname WHERE userid='$touserid' AND userchatid='$touserchatid' AND schoolid='$schoolid'");
	$chatwith_number = mysql_num_rows($chatwith_result);
	if ($chatwith_number > 0){
 	$chatwith_row =  mysql_fetch_array($chatwith_result);
 	$sendername[$h] = $chatwith_row['username'];
	} else {
	if ($touserid != 0){
	$chatwithuser_result = mysql_query("SELECT * FROM users WHERE id='$touserid'");
	$chatwithuser_row =  mysql_fetch_array($chatwithuser_result);
 	$sendername[$h] = $chatwithuser_row['username'];
	} else {
	$sendername[$h] = "匿名";
	}
	}
   	$h++;
   		
   	}
        
  echo utf8_encode($sendername[0]);	
  } else {
  echo "received";
  }

?>