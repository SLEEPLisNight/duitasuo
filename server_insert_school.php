<?php
header('Content-type: text/html; charset=UTF-8');
include 'connect_to_mysql.php';

$schoolname = $_GET['schoolname'];

function utf8_urldecode($str) {
			$str = nl2br($str);
			$str = str_replace("'","\'",$str);
			$str = str_replace("<","&lt;",$str);
    		$str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
    		return html_entity_decode($str,null,'gb2312');
    		}

$schoolname = utf8_urldecode($schoolname);   			
$schoolname_result =  mysql_query("SELECT * FROM schools WHERE schoolname = '$schoolname' ORDER BY id ASC;") or die(mysql_error());          
$schoolname_num = mysql_num_rows($schoolname_result);
if ($schoolname_num > 0){
echo "数据库中已有此学校名字";
} else {	 	   	
$sql_insert =  mysql_query("INSERT INTO schools (schoolname,likes) VALUES('$schoolname','0')") or die(mysql_error());          
echo "成功插入数据库：".$schoolname;
}


/*
$schoolname_result =  mysql_query("SELECT * FROM schools ORDER BY id ASC;") or die(mysql_error());          
while ($row = mysql_fetch_assoc($schoolname_result)){
if ($row['id'] > 60){
$id = $row['id'];
mysql_query ("DELETE FROM schools WHERE id='$id'") or die(mysql_error());
echo "删除数据库：".$row['schoolname']."<br>";
}
}
*/

?>