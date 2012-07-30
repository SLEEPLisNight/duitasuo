<?php
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';

function utf8_urldecode($str) {
			$str = nl2br($str);
			$str = str_replace("'","\'",$str);
			$str = str_replace("<","&lt;",$str);
    		$str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
    		return html_entity_decode($str,null,'gb2312');
    		}

$h=0;
$result = mysql_query("SELECT * FROM schools ORDER BY likes DESC;") or die();
$number = mysql_num_rows($result);
if ($number > 0) {
   		while ($row =  mysql_fetch_array($result)){
   		$schoolname[$h] = $row['schoolname'];
   		$schoolid[$h] = $row['id'];
		$schoollike[$h] = $row['likes'];
   	 	$h++;
   	 	}
    	}

$name = utf8_urldecode($_GET["name"]);

//lookup all hints from array if length of name > 0
if (strlen($name) > 0)
  {
  $totalnum = 0;
  for($i=0; $i<count($schoolname); $i++)
    {
    if (preg_match("/".$name."/i",$schoolname[$i]))
      {
      $totalnum++;
      }
    }
  
  $hint="";
  $totalnum_break = 0;
  for($i=0; $i<count($schoolname); $i++)
    {
    if (preg_match("/".$name."/i",$schoolname[$i]))
      {
      if ($hint=="")
        {
        $hint="<div class='choose_school' onmouseover=this.className='choose_school_onmouseover' onmouseout=this.className='choose_school'><a href='home.php?schoolid=".$schoolid[$i]."'><div class='choose_school_name'>".$schoolname[$i]."</div><div class='choose_school_likes'>".$schoollike[$i]."个通告</div></a></div>";
        }
      else
        {
        $hint=$hint."<div class='choose_school' onmouseover=this.className='choose_school_onmouseover' onmouseout=this.className='choose_school'><a href='home.php?schoolid=".$schoolid[$i]."'><div class='choose_school_name'>".$schoolname[$i]."</div><div class='choose_school_likes'>".$schoollike[$i]."个通告</div></a></div>";
        }
        $totalnum_break++;
      }
    if ($totalnum_break >9){
    break;
    }
    
    }
  
if ($hint == ""){
  echo "<div class='choose_school_more'>这个学校还未开通</div>";
} else {
  $result_left = $totalnum - 10;
  if ($result_left > 0){
  $hint=$hint."<div class='choose_school_more'>还有".$result_left."个搜索结果...</div>";
  }
  echo $hint; 
}

}

?>