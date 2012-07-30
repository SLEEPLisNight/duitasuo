<?php
include '../connect_to_mysql.php'; 
if (isset($_SESSION['id'])){
$userid = $_SESSION['id']; // assign SESSION 'id' value to $userid.
} else {
$userid = 0;
}
$schoolid = $_SESSION['schoolid'];

if (isset($_SESSION['chatid'])){
$userchatid = $_SESSION['chatid']; // assign SESSION 'id' value to $userid.
} else {
$result_chatid = mysql_query("SELECT * FROM chatid ORDER BY userchatid DESC;") or die();
$row_chatid = mysql_fetch_array($result_chatid);
$userchatid = $row_chatid['userchatid'] + 1;
mysql_query("INSERT INTO chatid (userchatid) VALUES('$userchatid')") or die(mysql_error());
$_SESSION['chatid'] = $userchatid;
}

$dataFile = "onlinevisitors.txt";

$sessionTime = 6; //this is the time in **seconds** to consider someone online before removing them from our file


function utf8_urldecode($str) {
    		$str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
    		return html_entity_decode($str,null,'utf-8');
    		}
//Please do not edit bellow this line

error_reporting(E_ERROR | E_PARSE);

if(!file_exists($dataFile)) {
	$fp = fopen($dataFile, "w+");
	fclose($fp);
}

//$ip = $_SERVER['REMOTE_ADDR'];
$users = array();
$onusers = array();

//getting
$fp = fopen($dataFile, "r");
flock($fp, LOCK_SH);
while(!feof($fp)) {
	$users[] = rtrim(fgets($fp, 32));
}
flock($fp, LOCK_UN);
fclose($fp);


//cleaning
$x = 0;
$alreadyIn = FALSE;
foreach($users as $key => $data) {
    $lastvisit = explode("|", $data);
	if(time() - $lastvisit[3] >= $sessionTime) {
		$users[$x] = "";
	} else {
		if($lastvisit[0] == $userid && $lastvisit[1] == $userchatid && $lastvisit[2] == $schoolid) {
			$alreadyIn = TRUE;
			$users[$x] = "$userid|$userchatid|$schoolid|" . time(); //updating
		}
	}
	$x++;
}

if($alreadyIn == FALSE) {
	$users[] = "$userid|$userchatid|$schoolid|" . time();
}

//writing
$fp = fopen($dataFile, "w+");
flock($fp, LOCK_EX);
$i = 0;
foreach($users as $single) {
	if($single != "") {
		fwrite($fp, $single . "\r\n");
		$i++;
	}
}
flock($fp, LOCK_UN);
fclose($fp);



if ($userid == 0){
$num = rand(1,1000);
$username = "匿名".$num;
//$username = utf8_decode($username);
} else {
$result = mysql_query("SELECT * FROM users WHERE id = '$userid' ORDER BY id ASC;") or die();
$row = mysql_fetch_array($result);
$username = $row['username'];
}

$result_chatname = mysql_query("SELECT * FROM chatname WHERE userchatid='$userchatid' AND userid='$userid' AND schoolid='$schoolid' ORDER BY id ASC;") or die();
$number_chatname = mysql_num_rows($result_chatname);
if ($number_chatname == 0) {
mysql_query("INSERT INTO chatname (userid,userchatid,username,schoolid,loginas,place,xpos,ypos) VALUES('$userid','$userchatid','$username','$schoolid','0','','0','0')") or die(mysql_error());
}

$result_chatname_delete = mysql_query("SELECT * FROM chatname ORDER BY id ASC;") or die();
while($row_chatname_delete = mysql_fetch_array($result_chatname_delete)){
$chatname_delete = 1;

foreach($users as $key2 => $data) {

	$ipinfo= explode("|", $data);
	$onlineid = $ipinfo[0];
	$onlinechatid = $ipinfo[1];
    $onlineschoolid = $ipinfo[2];
	if ($row_chatname_delete['userchatid'] == $onlinechatid && $row_chatname_delete['userid'] == $onlineid && $row_chatname_delete['schoolid'] == $onlineschoolid)
	{
	$chatname_delete = 0;
	}
	
}

if ($chatname_delete == 1){
$chatname_delete_id = $row_chatname_delete['id'];
$chatname_offline_num = $chatname_delete_id;
mysql_query("DELETE FROM chatname WHERE id = '$chatname_delete_id'") or die(mysql_error());
break;
}

}




$h = 0;
foreach($users as $key3 => $data) {

	$ipinfo= explode("|", $data);
	$onlinechatid = $ipinfo[1];
	$onlineschoolid = $ipinfo[2];
	if($onlinechatid != $userchatid && $onlineschoolid == $schoolid){
    $h++;	
	}
	
}

echo $h."|".$chatname_offline_num;

?>