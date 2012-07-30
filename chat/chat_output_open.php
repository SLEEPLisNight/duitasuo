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
$schoolid = $_SESSION['schoolid'];

$chat = "";
$h = 0;
$result = mysql_query("SELECT * FROM chat WHERE userid='$touserid' AND userchatid='$touserchatid' AND touserid='$userid' AND touserchatid='$userchatid' AND recd = 1 AND confirm = 0 ORDER BY id ASC;") or die();
$number = mysql_num_rows($result);
if ($number > 0) {
   	while($row = mysql_fetch_array($result)){
   	/*
   	$nhour = (int)(date("G"));
   	$nowminute = $nhour*60 + (int)(date("i"));
   	$shour = (int)(date("G",strtotime($row['sendtime'])));
   	$sendminute = $shour*60 + (int)(date("i",strtotime($row['sendtime'])));
   	
   	if (date("d m Y",strtotime($row['sendtime'])) == date("d m Y") && ($nowminute-60) <= $sendminute)
   	*/
   	$chatwith_result = mysql_query("SELECT * FROM chatname WHERE userid='$touserid' AND userchatid='$touserchatid' AND schoolid='$schoolid'");
 	$chatwith_row =  mysql_fetch_array($chatwith_result);
 	$sendername = $chatwith_row['username'];	
   	$message[$h] = $row['message'];
   	$sendtime[$h] = $row['sendtime'];
   	
$message[$h] = str_replace("(谄笑)","<img src='smileys/1.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(吃饭)","<img src='smileys/2.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(调皮)","<img src='smileys/3.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(尴尬)","<img src='smileys/4.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(汗)","<img src='smileys/5.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(惊恐)","<img src='smileys/6.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(囧)","<img src='smileys/7.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(可爱)","<img src='smileys/8.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(酷)","<img src='smileys/9.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(流口水)","<img src='smileys/10.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(色迷迷)","<img src='smileys/11.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(生病)","<img src='smileys/12.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(叹气)","<img src='smileys/13.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(淘气)","<img src='smileys/14.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(舔)","<img src='smileys/15.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(偷笑)","<img src='smileys/16.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(呕吐)","<img src='smileys/17.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(吻)","<img src='smileys/18.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(晕)","<img src='smileys/19.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(住嘴)","<img src='smileys/20.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(大笑)","<img src='smileys/21.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(害羞)","<img src='smileys/22.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(防流感)","<img src='smileys/23.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(哭)","<img src='smileys/24.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(困)","<img src='smileys/25.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(难过)","<img src='smileys/26.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(生气)","<img src='smileys/27.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(书呆子)","<img src='smileys/28.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(微笑)","<img src='smileys/29.gif'style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(不)","<img src='smileys/30.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(惊讶)","<img src='smileys/31.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(抠鼻)","<img src='smileys/32.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(烧香)","<img src='smileys/33.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(给力)","<img src='smileys/34.gif' style='border:0;' />",$message[$h]);
$message[$h] = str_replace("(鸭梨)","<img src='smileys/35.gif' style='border:0;' />",$message[$h]);
	
	$h++;	
	}
       
		
  for($i=0; $i<$h; $i++){
  if ($chat==""){
        $chat="<div class='chatbox_content_box'>
        <p class='chatbox_content_box_sender'>".$sendername."</p><p class='chatbox_content_box_time'>".date("g:ia",strtotime("-4 hour",strtotime($sendtime[$i])))."</p>
        <p class='chatbox_content_box_message'>".$message[$i]."</p>
        </div>";
		} else {
        $chat=$chat."<div class='chatbox_content_box'>
        <p class='chatbox_content_box_sender'>".$sendername."</p><p class='chatbox_content_box_time'>".date("g:ia",strtotime("-4 hour",strtotime($sendtime[$i])))."</p>
        <p class='chatbox_content_box_message'>".$message[$i]."</p>
        </div>";
		}
  }
  
}

if ($chat != ""){
echo $chat;	
} else {
echo "nochatoutput";
}

?>