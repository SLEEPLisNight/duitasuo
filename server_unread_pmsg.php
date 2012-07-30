<?php
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';  // connect to mysql database.
if (isset($_SESSION['id'])){
$userid = $_SESSION['id']; // assign SESSION 'id' value to $userid.
} else {
$userid = 0;
}
$ip = $_SESSION['ip'];

$unread = 0;
$duitasuo_pmsg = mysql_query("SELECT * FROM duitasuopmsg WHERE touserid='$userid' OR userid='$userid' ORDER BY timesubmit DESC") OR die(mysql_query());
while ($row = mysql_fetch_assoc($duitasuo_pmsg))
{
 $touserid = $row['touserid'];
 $touserip = $row['touserip'];
 $fromuserid = $row['userid'];
 $fromuserip = $row['userip'];
 
 if ($userid != 0 && $userid == $touserid) {
 $pmsgowner = 1;
 $pmsgreceiver = 1;
 } else if ($userid != 0 && $userid == $fromuserid) {
 $pmsgowner = 1;
 $pmsgreceiver = 0;
 } else if ($userid == 0 && $touserid == 0 && $ip == $touserip){
 $pmsgowner = 1;
 $pmsgreceiver = 1;
 } else if ($userid == 0 && $fromuserid == 0 && $ip == $fromuserip){
 $pmsgowner = 1;
 $pmsgreceiver = 0;
 } else {
 $pmsgowner = 0;
 }
 
 if ($pmsgowner == 1){
 $pmsgid = $row['id'];
 $readit = $row['readit'];
 
 $reply = 0;
 $duitasuo_pmsg_lastreply = mysql_query("SELECT * FROM duitasuopmsgreply WHERE pmsgid='$pmsgid' ORDER BY timesubmit DESC") OR die(mysql_query());
 while ($row_pmsg_lastreply = mysql_fetch_assoc($duitasuo_pmsg_lastreply)){
 $touserid_reply = $row_pmsg_lastreply['touserid'];
 $touserip_reply = $row_pmsg_lastreply['touserip'];
 $fromuserid_reply = $row_pmsg_lastreply['userid'];
 $fromuserip_reply = $row_pmsg_lastreply['userip'];
 
 if ($userid != 0 && $userid == $touserid_reply) {
 $pmsg_reply_receiver = 1;
 } else if ($userid != 0 && $userid == $fromuserid_reply) {
 $pmsg_reply_receiver = 0;
 } else if ($userid == 0 && $touserid_reply == 0 && $ip == $touserip_reply){
 $pmsg_reply_receiver = 1;
 } else if ($userid == 0 && $fromuserid_reply == 0 && $ip == $fromuserip_reply){
 $pmsg_reply_receiver = 0;
 }
 
 $pmsgreplyid = $row_pmsg_lastreply['id'];
 $readit_reply = $row_pmsg_lastreply['readit'];
 
 if ($pmsg_reply_receiver == 1 && $readit_reply == 0){
 $unread++;
 }
 
 $reply = 1;
 break;
 }
 
 if ($reply == 1){
 } else { 
 if ($pmsgreceiver == 1 && $readit == 0){
 $unread++;
 } else {
 }
 }
 
 }

}

if ($unread > 0){
echo $unread;
} else {
echo "nonewupdate";
}

?>