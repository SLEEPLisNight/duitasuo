<?php 
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';  
    
    $code = $_GET['code'];

    if (!$code){
        echo "无此代码。";
    } 
    else
    {
        $check = mysql_query("SELECT * FROM users WHERE code='$code' AND active='1'");
        if (mysql_num_rows($check)==1){
            echo "您的账号已经激活。";
        }
        else
        {
            $activate = mysql_query("UPDATE users SET active='1' WHERE code='$code'");
            header('Location: index.php');
            echo "您的账号被激活了！";
        }
        
    }
    
   ?>