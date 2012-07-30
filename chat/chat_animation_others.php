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


$nr = 0;
foreach($users as $key => $data) {
	$ipinfo= explode("|", $data);
	$onlineid = $ipinfo[0];
	$onlinechatid = $ipinfo[1];
	$onlineschoolid = $ipinfo[2];
	if($onlinechatid != $userchatid && $onlineschoolid == $schoolid){
	$result = mysql_query("SELECT * FROM chatname WHERE userid = '$onlineid' AND userchatid='$onlinechatid' AND schoolid='$schoolid' ORDER BY id ASC;") or die();
   	while($row = mysql_fetch_array($result)){
	$nr++;
	}
	}
}
$others_pn = $_GET['others_pn'];
$itemsPerPage = 2; 
$lastPage = ceil($nr / $itemsPerPage);

if ($others_pn < 1) { // If it is less than 1
    $others_pn = 1; // force if to be 1
} else {
$others_pn++; 
if ($others_pn > $lastPage) { // if it is greater than $lastpage
    $others_pn = $lastPage; // force it to be $lastpage's value
} 
}
// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = ($others_pn - 1)*$itemsPerPage; 
//find online friends
$h = 0;
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
	$schoolmatexpos[$h] = $row['xpos'].'px';
	$schoolmateypos[$h] = $row['ypos'].'px';
	$schoolmatename_encode[$h] = utf8_encode($schoolmatename[$h]);
    $h++;
	}
	
	}
	
}

  $schoolmate = "";
  $schoolmate_num = 0;
  if ($h >= $limit + 2){
  for($i=$limit; $i<$limit+2; $i++){
  
  if ($schoolmate==""){
      $schoolmate="<div id='chat_animation_user_$schoolmatenum[$i]' class='chat_animation_other_user' style='left: $schoolmatexpos[$i]; top: $schoolmateypos[$i];'>
	  <div id='chat_animation_user_pic_$schoolmatenum[$i]' class='chat_animation_other_user_pic' onmouseover=change_chat_animation_other_user_name_class('chat_animation_user_name_$schoolmatenum[$i]') onmouseout=changeback_chat_animation_other_user_name_class('chat_animation_user_name_$schoolmatenum[$i]') onclick=chat_animation_see_other_features('$schoolmatenum[$i]') title='点我！点我！'></div>
	  <div id='chat_animation_user_name_$schoolmatenum[$i]' class='chat_animation_other_user_name' onmouseover=this.className='chat_animation_other_user_name_onmouseover2' onmouseout=this.className='chat_animation_other_user_name' onmousedown=this.className='chat_animation_other_user_name_onmouseover' onmouseup=this.className='chat_animation_other_user_name2' onclick=chatwith('$schoolmatenum[$i]','$schoolmateid[$i]','$schoolmatechatid[$i]','$schoolmatename_encode[$i]') title='向 $schoolmatename[$i] 发出聊天请求'>$schoolmatename[$i]</div>
	  <div id='chat_animation_user_msg_$schoolmatenum[$i]' class='chat_animation_other_user_msg_displaynone' onmouseover=this.className='chat_animation_other_user_msg_onmouseover2' onmouseout=this.className='chat_animation_other_user_msg' onmousedown=this.className='chat_animation_other_user_msg_onmouseover' onmouseup=this.className='chat_animation_other_user_msg2' onclick=chat_animation_see_msgs('$schoolmateid[$i]','$schoolmatename_encode[$i]')>留言记录</div>
	  </div>";
  } else {
      $schoolmate=$schoolmate."<div id='chat_animation_user_$schoolmatenum[$i]' class='chat_animation_other_user' style='left: $schoolmatexpos[$i]; top: $schoolmateypos[$i];'>
	  <div id='chat_animation_user_pic_$schoolmatenum[$i]' class='chat_animation_other_user_pic' onmouseover=change_chat_animation_other_user_name_class('chat_animation_user_name_$schoolmatenum[$i]') onmouseout=changeback_chat_animation_other_user_name_class('chat_animation_user_name_$schoolmatenum[$i]') onclick=chat_animation_see_other_features('$schoolmatenum[$i]') title='点我！点我！'></div>
	  <div id='chat_animation_user_name_$schoolmatenum[$i]' class='chat_animation_other_user_name' onmouseover=this.className='chat_animation_other_user_name_onmouseover2' onmouseout=this.className='chat_animation_other_user_name' onmousedown=this.className='chat_animation_other_user_name_onmouseover' onmouseup=this.className='chat_animation_other_user_name2' onclick=chatwith('$schoolmatenum[$i]','$schoolmateid[$i]','$schoolmatechatid[$i]','$schoolmatename_encode[$i]') title='向 $schoolmatename[$i] 发出聊天请求'>$schoolmatename[$i]</div>
	  <div id='chat_animation_user_msg_$schoolmatenum[$i]' class='chat_animation_other_user_msg_displaynone' onmouseover=this.className='chat_animation_other_user_msg_onmouseover2' onmouseout=this.className='chat_animation_other_user_msg' onmousedown=this.className='chat_animation_other_user_msg_onmouseover' onmouseup=this.className='chat_animation_other_user_msg2' onclick=chat_animation_see_msgs('$schoolmateid[$i]','$schoolmatename_encode[$i]')>留言记录</div>
	  </div>";
  }
  }
  if ($h == $limit + 2){
  $schoolmate_num = 1;
  } else {
  $schoolmate_num = 2;
  }
  } else {
  for($i=$limit; $i<$h; $i++){
  
  if ($schoolmate==""){
      $schoolmate="<div id='chat_animation_user_$schoolmatenum[$i]' class='chat_animation_other_user' style='left: $schoolmatexpos[$i]; top: $schoolmateypos[$i];'>
	  <div id='chat_animation_user_pic_$schoolmatenum[$i]' class='chat_animation_other_user_pic' onmouseover=change_chat_animation_other_user_name_class('chat_animation_user_name_$schoolmatenum[$i]') onmouseout=changeback_chat_animation_other_user_name_class('chat_animation_user_name_$schoolmatenum[$i]') onclick=chat_animation_see_other_features('$schoolmatenum[$i]') title='点我！点我！'></div>
	  <div id='chat_animation_user_name_$schoolmatenum[$i]' class='chat_animation_other_user_name' onmouseover=this.className='chat_animation_other_user_name_onmouseover2' onmouseout=this.className='chat_animation_other_user_name' onmousedown=this.className='chat_animation_other_user_name_onmouseover' onmouseup=this.className='chat_animation_other_user_name2' onclick=chatwith('$schoolmatenum[$i]','$schoolmateid[$i]','$schoolmatechatid[$i]','$schoolmatename_encode[$i]') title='向 $schoolmatename[$i] 发出聊天请求'>$schoolmatename[$i]</div>
	  <div id='chat_animation_user_msg_$schoolmatenum[$i]' class='chat_animation_other_user_msg_displaynone' onmouseover=this.className='chat_animation_other_user_msg_onmouseover2' onmouseout=this.className='chat_animation_other_user_msg' onmousedown=this.className='chat_animation_other_user_msg_onmouseover' onmouseup=this.className='chat_animation_other_user_msg2' onclick=chat_animation_see_msgs('$schoolmateid[$i]','$schoolmatename_encode[$i]')>留言记录</div>
	  </div>";
  } else {
      $schoolmate=$schoolmate."<div id='chat_animation_user_$schoolmatenum[$i]' class='chat_animation_other_user' style='left: $schoolmatexpos[$i]; top: $schoolmateypos[$i];'>
	  <div id='chat_animation_user_pic_$schoolmatenum[$i]' class='chat_animation_other_user_pic' onmouseover=change_chat_animation_other_user_name_class('chat_animation_user_name_$schoolmatenum[$i]') onmouseout=changeback_chat_animation_other_user_name_class('chat_animation_user_name_$schoolmatenum[$i]') onclick=chat_animation_see_other_features('$schoolmatenum[$i]') title='点我！点我！'></div>
	  <div id='chat_animation_user_name_$schoolmatenum[$i]' class='chat_animation_other_user_name' onmouseover=this.className='chat_animation_other_user_name_onmouseover2' onmouseout=this.className='chat_animation_other_user_name' onmousedown=this.className='chat_animation_other_user_name_onmouseover' onmouseup=this.className='chat_animation_other_user_name2' onclick=chatwith('$schoolmatenum[$i]','$schoolmateid[$i]','$schoolmatechatid[$i]','$schoolmatename_encode[$i]') title='向 $schoolmatename[$i] 发出聊天请求'>$schoolmatename[$i]</div>
	  <div id='chat_animation_user_msg_$schoolmatenum[$i]' class='chat_animation_other_user_msg_displaynone' onmouseover=this.className='chat_animation_other_user_msg_onmouseover2' onmouseout=this.className='chat_animation_other_user_msg' onmousedown=this.className='chat_animation_other_user_msg_onmouseover' onmouseup=this.className='chat_animation_other_user_msg2' onclick=chat_animation_see_msgs('$schoolmateid[$i]','$schoolmatename_encode[$i]')>留言记录</div>
	  </div>";
  }
  }
  $schoolmate_num = $h - $limit;
  }
  
  if ($h > 0){
  echo $schoolmate_num."|".$schoolmate;
  } else {
  echo "noschoolmate|";
  }

?>