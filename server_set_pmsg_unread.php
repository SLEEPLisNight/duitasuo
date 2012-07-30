<?php
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';  // connect to mysql database.

 $pmsgid = $_GET['pmsgid'];

 $reply = 0;
 $duitasuo_pmsg_lastreply = mysql_query("SELECT * FROM duitasuopmsgreply WHERE pmsgid='$pmsgid' ORDER BY timesubmit DESC") OR die(mysql_query());
 while ($row_pmsg_lastreply = mysql_fetch_assoc($duitasuo_pmsg_lastreply)){
 $id_reply = $row_pmsg_lastreply['id'];
 
 mysql_query ("UPDATE duitasuopmsgreply SET readit = 0 WHERE id='$id_reply'") or die(mysql_error());

 $reply = 1;
 break;
 }
 
 if ($reply == 1){
 } else { 
 mysql_query ("UPDATE duitasuopmsg SET readit = 0 WHERE id='$pmsgid'") or die(mysql_error());
 }

?>