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

$nowsecond = time();

$h=0;
$result = mysql_query("SELECT * FROM chat WHERE userid='$touserid' AND userchatid='$touserchatid' AND touserid='$userid' AND touserchatid='$userchatid' AND recd = 1 AND confirm = 0 ORDER BY id ASC;") or die();
$number = mysql_num_rows($result);
if ($number > 0) {
   	while ($row = mysql_fetch_array($result)){
   		
   	  	$sendsecond = $row['sendtimeinsecond'];
   		if ( $sendsecond < $nowsecond){   		
   		$id = $row['id'];
		mysql_query("UPDATE chat SET confirm = 1 WHERE id='$id'") 
		or die(mysql_error());
		$h++;
		}
	}
	
	echo "done";

}