<?php
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';

    function utf8_urldecode($str) 
	{
	$str = htmlspecialchars($str, ENT_QUOTES);
	$str = mysql_real_escape_string($str);
    return $str;
	}	
     
     $signup_username = utf8_urldecode($_GET['signup_username']);
	 $signup_email = utf8_urldecode($_GET['signup_email']);
     //get form data
     $username = addslashes(strip_tags($signup_username));
     $password = addslashes(strip_tags($_GET['signup_password']));
     $email = addslashes(strip_tags($signup_email));
     
     if (!$username||!$password||!$email){
        echo "请输入所有的信息。";
     }
	 else
     {
      
        
        //check if username already taken
        $check = mysql_query("SELECT * FROM users WHERE email='$email'");
        if (mysql_num_rows($check)>=1){
           echo "邮箱地址已经被注册。";
		}   
        else
        {
           //generate random code
           $code = rand(11111111,99999999);
           

$subject = "谢谢注册 duitasuo.com";
$body = "你好 $signup_username,\n\n谢谢注册 duitasuo.com! 为了激活您的账号，请点击下面的链接或者把它复制到您的浏览器地址栏里:\n\nhttp://www.duitasuo.com/index_activate.php?code=".$code."\n\n谢谢注册,祝你早日找到你的ta.\n\n\nKoollo Kingdom Inc.";
$from = "admin@duitasuo.com";
$host = "smtp.gmail.com";
$username_smtp = "jameswang218@gmail.com";
$password_smtp = "wjywjy218";
$to = $email;
// config -------- 

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
    if (!SMTP::data($c, $m)){
	echo "服务器正忙，请稍后再试。";
	} else {	
	$ip=$_SERVER['REMOTE_ADDR'];
	$renrenuserid = $_GET['renrenuserid'];
	mysql_query("INSERT INTO users VALUES ('','$username','$password','$email','$code','0','','','','','','','','','','','$ip',0,'$renrenuserid')");	
	echo "sent";
	}
	SMTP::quit($c);
    @fclose($c);   
	}  
   }
   
?>