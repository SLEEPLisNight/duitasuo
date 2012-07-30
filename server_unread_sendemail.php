<?php
include 'connect_to_mysql.php';  // connect to mysql database.
if (isset($_SESSION['id'])){
$userid = $_SESSION['id']; // assign SESSION 'id' value to $userid.
} else {
$userid = 0;
}
if (isset($_SESSION['schoolid'])){
$schoolid = $_SESSION['schoolid']; // assign SESSION 'id' value to $userid.
} else {
$schoolid = 1;
}
$ip = $_SESSION['ip'];

if ($userid != 0){
$duitasuo_user = mysql_query("SELECT * FROM users WHERE id='$userid' ORDER BY id ASC;") OR die(mysql_query());      
$row_user = mysql_fetch_assoc($duitasuo_user);
$username = $row_user['username'];
$email = $row_user['email'];
} else {
$username = $ip;
$email = "admin@duitasuo.com";
}

$update = $_GET['update'];

if ($update == 0){
$subject = "您有来自duitasuo.com的新消息";
$body = "你好 $username, \n\n谢谢使用 duitasuo.com!\n\n您现在有未读新消息，请点击下面的链接进行查看:\n\nhttp://www.duitasuo.com/home.php?schoolid=".$schoolid."\n\n谢谢您的支持,祝你早日找到你的ta.\n\n\nKoollo Kingdom Inc.";
} else {
$subject = "您有来自duitasuo.com的新邮件";
$body = "你好 $username, \n\n谢谢使用 duitasuo.com!\n\n您现在有未读新邮件，请点击下面的链接进行查看:\n\nhttp://www.duitasuo.com/home.php?schoolid=".$schoolid."\n\n谢谢您的支持,祝你早日找到你的ta.\n\n\nKoollo Kingdom Inc.";
}
$from = "admin@duitasuo.com";
$host = "smtp.gmail.com";
$username_smtp = "jameswang218@gmail.com";
$password_smtp = "wjywjy218";
$to = $email;

	// manage errors
    error_reporting(E_ALL); // php errors
	define('DISPLAY_XPM4_ERRORS', true); // display XPM4 errors
	 
	// path to 'SMTP.php' file from XPM4 package
	require_once 'XPM4/SMTP.php'; // path to 'SMTP.php' file from XPM4 package
	 
	// standard mail message RFC2822
	$m = 'From: duitasuo 团队'."\r\n".
	     'To:'.$to."\r\n".
	     'Subject:'.$subject."\r\n".
	     'Content-Type: text/plain'."\r\n\r\n".
	      $body;	 
	// connect to 'smtp.gmail.com' via SSL (TLS encryption) using port '465' and timeout '10' secounds
	// make sure you have OpenSSL module (extension) enable on your php configuration
	//error_reporting(0);
	//phpinfo();
    //$c = fsockopen('ssl://smtphm.sympatico.ca', 25);
	$c = fsockopen('ssl://smtp.gmail.com', 465, $errno, $errstr, 10) or die($errstr);
	// expect response code '220'
	if (!SMTP::recv($c, 220)) die(print_r($_RESULT));
	// EHLO/HELO
	if (!SMTP::ehlo($c, 'localhost')) SMTP::helo($c, 'localhost') or die(print_r($_RESULT));
	// AUTH LOGIN/PLAIN
	if (!SMTP::auth($c, $username_smtp, $password_smtp, 'login')) SMTP::auth($c, $username_smtp, $password_smtp, 'plain') or die(print_r($_RESULT));
	// MAIL FROM
	SMTP::from($c, $from) or die(print_r($_RESULT));	// RCPT TO
	SMTP::to($c, $to) or die(print_r($_RESULT));	// DATA
	//SMTP::data($c, $m) or die(print_r($_RESULT));	// RSET, optional if you need to send another mail using this connection '$c'
    SMTP::data($c, $m) or die(print_r($_RESULT));
	SMTP::quit($c);
    @fclose($c);	
	
?>