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

$dataFile = "onlinevisitors.txt";

//Please do not edit bellow this line

error_reporting(E_ERROR | E_PARSE);

if(!file_exists($dataFile)) {
	$fp = fopen($dataFile, "w+");
	fclose($fp);
}

//getting
$fp = fopen($dataFile, "r");
flock($fp, LOCK_SH);
while(!feof($fp)) {
	$users[] = rtrim(fgets($fp, 32));
}
flock($fp, LOCK_UN);
fclose($fp);


//find online friends
$h = 0;
$alreadyIn = FALSE;
foreach($users as $key => $data) {

	$ipinfo= explode("|", $data);
	$onlineid = $ipinfo[0];
	$onlinechatid = $ipinfo[1];
	$onlineschoolid = $ipinfo[2];
	if($onlinechatid != $userchatid && $onlineschoolid == $schoolid){
	
	$result = mysql_query("SELECT * FROM chatname WHERE userid = '$onlineid' AND userchatid='$onlinechatid' AND schoolid='$schoolid' ORDER BY id ASC;") or die();
   	while($row = mysql_fetch_array($result)){
	$schoolmateid[$h] = $onlineid;
 	$schoolmatechatid[$h] = $onlinechatid;	
	$schoolmatenum[$h] = $row['id'];
   	$schoolmatename[$h] = $row['username'];
	$schoolmateplace[$h] = $row['place'];
	$schoolmatename_encode[$h] = utf8_encode($schoolmatename[$h]);
    $h++;
	}
	
	}
	
}

  $schoolmate = "";
  for($i=0; $i<$h; $i++){
  if ($schoolmate=="")
        {
        $schoolmate="<div class='chat_online_user' onmouseover=this.className='chat_online_user_onmouseover' onmouseout=this.className='chat_online_user' onclick=chatwith('$schoolmatenum[$i]','$schoolmateid[$i]','$schoolmatechatid[$i]','$schoolmatename_encode[$i]')><div class='chat_online_user_name'>".$schoolmatename[$i]."</div><div class='chat_online_user_place'>".$schoolmateplace[$i]."</div></div>";
        }
      else
        {
        $schoolmate=$schoolmate."<div class='chat_online_user' onmouseover=this.className='chat_online_user_onmouseover' onmouseout=this.className='chat_online_user' onclick=chatwith('$schoolmatenum[$i]','$schoolmateid[$i]','$schoolmatechatid[$i]','$schoolmatename_encode[$i]')><div class='chat_online_user_name'>".$schoolmatename[$i]."</div><div class='chat_online_user_place'>".$schoolmateplace[$i]."</div></div>";
        }
  }
  
  if ($h > 0){
  echo $schoolmate;
  } else {
  echo "noschoolmate";
  }

?>