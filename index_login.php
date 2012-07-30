<?php
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';

       //get form data
       $useremail = addslashes(strip_tags($_GET['login_email']));
       $password = addslashes(strip_tags($_GET['login_password']));

       if (!$useremail||!$password){
       echo "请输入您的帐号和密码。";
       }
       else
       {
        //log in
        $login = mysql_query("SELECT * FROM users WHERE email='$useremail'");
        if (mysql_num_rows($login)==0){
        echo "无此用户。";
        }
        else
        {
          while ($login_row = mysql_fetch_assoc($login))
          {
     
           //get database password
           $password_db = $login_row['password'];
     
           
           //check password
           if ($password!=$password_db){
           echo "密码错误。";
           }
           else
           {
              //check if active
              $active = $login_row['active'];
              $id = $login_row['id'];
              $username = $login_row['username'];
              $university = $login_row['university'];
              $gender = $login_row['gender'];
	      $relationship = $login_row['relationship'];
	      $birthday = $login_row['birthday'];
	      $city = $login_row['city'];
	      $highschool = $login_row['highschool'];
	      $phone = $login_row['phone'];
	      $website = $login_row['website'];
	      

              if ($active==0){
              echo "请去您的邮箱激活您的帐号。";
              }
              else
              {
            
                $_SESSION['username']=$username; //assign session
                $_SESSION['id']=$id; //assign session
                
                //get ip address              
      		    $ip=$_SERVER['REMOTE_ADDR'];
    		
                $update_ip =  mysql_query("UPDATE users SET ip = '$ip' WHERE id = $id") or die(mysql_error());
                if ($_GET['autologin'] == 1){
                mysql_query("UPDATE users SET autologin = '1' WHERE id = $id") or die(mysql_error());
                } else {
                mysql_query("UPDATE users SET autologin = '0' WHERE id = $id") or die(mysql_error());
                }
				
				$renrenuserid = $_GET['renrenuserid'];
                mysql_query("UPDATE users SET renrenuserid = '$renrenuserid' WHERE id = $id") or die(mysql_error());
                
                echo "login";
              }
           }
          }
        }
       }
    ?>