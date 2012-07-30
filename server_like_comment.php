<?php
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';
if (isset($_SESSION['id'])){
$userid = $_SESSION['id']; // assign SESSION 'id' value to $userid.
} else {
$userid = 0;
}
$ip = $_SESSION['ip'];
$time = time();

$id = $_GET['id'];
$like = $_GET['like'];

//deleting unregistered users for unactive more than 5 minutes in duitasuocommentgeili

$result_delete = mysql_query("SELECT * FROM duitasuocommentgeili WHERE userid='0' ORDER BY id ASC;") or die();
while ($row_delete = mysql_fetch_assoc($result_delete))
{
$id_delete = $row_delete['id'];
$ip_delete = $row_delete['ip'];

$result_delete_online = mysql_query("SELECT * FROM duitasuoonline WHERE ip='$ip_delete' ORDER BY id ASC;") or die();
$number_delete_online = mysql_num_rows($result_delete_online);
if ($number_delete_online == 0) {
mysql_query("DELETE FROM duitasuocommentgeili WHERE ip ='$ip_delete'") or die(mysql_error());
}
}

$duitasuo_comment = mysql_query("SELECT * FROM duitasuocomment WHERE id='$id'") OR die(mysql_query());
$row = mysql_fetch_assoc($duitasuo_comment);
$likes = $row['likes'];

if ($like == "1"){
$likes++;

if ($userid != 0){

$result = mysql_query("SELECT * FROM duitasuocommentgeili WHERE userid='$userid' AND commentid='$id'") or die();
$number = mysql_num_rows($result);
if ($number > 0) {
mysql_query ("UPDATE duitasuocommentgeili SET geili = 1 WHERE userid='$userid' AND commentid='$id'") or die(mysql_error());
} else {
mysql_query("INSERT INTO duitasuocommentgeili (commentid,userid,geili,ip,time) VALUES('$id','$userid',1,'$ip','$time')") or die(mysql_error());
}

}
else {

$result = mysql_query("SELECT * FROM duitasuocommentgeili WHERE userid='$userid' AND ip='$ip' AND commentid='$id'") or die();
$number = mysql_num_rows($result);
if ($number > 0) {
mysql_query ("UPDATE duitasuocommentgeili SET geili = 1 WHERE userid='$userid' AND ip='$ip' AND commentid='$id'") or die(mysql_error());
} else {
mysql_query("INSERT INTO duitasuocommentgeili (commentid,userid,geili,ip,time) VALUES('$id','$userid',1,'$ip','$time')") or die(mysql_error());
}

}

}
else {
if ($likes =="0"){
$likes = 0;
}
else {
$likes--;
}

if ($userid != 0){

$result = mysql_query("SELECT * FROM duitasuocommentgeili WHERE userid='$userid' AND commentid='$id'") or die();
$number = mysql_num_rows($result);
if ($number > 0) {
mysql_query ("UPDATE duitasuocommentgeili SET geili = 0 WHERE userid='$userid' AND commentid='$id'") or die(mysql_error());
} else {
mysql_query("INSERT INTO duitasuocommentgeili (commentid,userid,geili,ip,time) VALUES('$id','$userid',0,'$ip','$time')") or die(mysql_error());
}

}
else {

$result = mysql_query("SELECT * FROM duitasuocommentgeili WHERE userid='$userid' AND ip='$ip' AND commentid='$id'") or die();
$number = mysql_num_rows($result);
if ($number > 0) {
mysql_query ("UPDATE duitasuocommentgeili SET geili = 0 WHERE userid='$userid' AND ip='$ip' AND commentid='$id'") or die(mysql_error());
} else {
mysql_query("INSERT INTO duitasuocommentgeili (commentid,userid,geili,ip,time) VALUES('$id','$userid',0,'$ip','$time')") or die(mysql_error());
}

}

}

mysql_query ("UPDATE duitasuocomment SET likes='$likes' WHERE id='$id'") or die(mysql_error());

 if ($likes == 0){
 $likestr = "不给力";
 }
 else {
 $likestr = $likes."个给力";
 }
 
echo $likestr;

?>