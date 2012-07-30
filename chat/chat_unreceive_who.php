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

$schoolid = $_SESSION['schoolid'];


$result = mysql_query("SELECT * FROM chat WHERE touserid='$userid' AND touserchatid='$userchatid' AND recd = 0 AND confirm = 0 ORDER BY sendtimeinsecond ASC;") or die();
$number = mysql_num_rows($result);
if ($number > 0) {
   	$row = mysql_fetch_array($result);
   	$fromuserid[0] = $row['userid'];
	$fromuserchatid[0] = $row['userchatid'];
	$fromuser_id = $row['userid'];
	$fromuser_chatid = $row['userchatid'];
	/*
   	$chatwith_result = mysql_query("SELECT * FROM chatnum WHERE userid='$userid' AND userip='$userip' AND touserid='$touserid[0]' AND touserip='$touserip[0]' AND schoolid='$schoolid'");
 	*/
	$chatwith_result = mysql_query("SELECT * FROM chatname WHERE userid='$fromuser_id' AND userchatid='$fromuser_chatid' AND schoolid='$schoolid'");
	$chatwith_row = mysql_fetch_array($chatwith_result);
 	$num[0] = $chatwith_row['id'];	
        
  echo $num[0]."|".$fromuserid[0]."|".$fromuserchatid[0];	
  } else {
  echo "received";
  }

?>