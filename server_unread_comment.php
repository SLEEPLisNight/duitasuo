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
$result_comment = mysql_query("SELECT * FROM duitasuocomment WHERE unread='0' ORDER BY timesubmit DESC;") or die();
$number_comment = mysql_num_rows($result_comment);
while ($row_comment = mysql_fetch_assoc($result_comment))
{
 $msgid = $row_comment['msgid'];
 $commentid = $row_comment['id'];
 $result_msg = mysql_query("SELECT * FROM duitasuomsg WHERE id='$msgid' ORDER BY timesubmit DESC;") or die();
 $row_msg = mysql_fetch_assoc($result_msg);
 if ($userid != 0 && $row_msg['userid'] == $userid){
 $unread++;
 } else if ($userid == 0 && $row_msg['userid'] == 0 && $row_msg['ip'] == $ip){
 $unread++;
 }
}

if ($unread > 0){
echo $unread;
} else {
echo "nonewupdate";
}

?>
 