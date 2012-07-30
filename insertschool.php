<!-- define DOCTYPE for the website at the top of the page -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" lang="zh-CN"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<script type="text/javascript" src="index.js"></script>
<script type="text/javascript" src="jquery-1.5.2.js"></script>
<script type="text/javascript">

function onload(n){
var a = 0;
while (a<n){
var schoolsid = "schs_"+a;
document.getElementById(schoolsid).onclick();
a++;
}
}
</script>

</head>

<div id="results">
<?php

$schoolname_arr = array();
$n_arr = array();

$url = "http://www.sleeplisnight.com/duitasuo/universitynames.html";
$script = file_get_contents($url);
preg_match_all('|<a(.*)>(.*)</a>|U', $script, $univerisitynames, PREG_PATTERN_ORDER);

$n = 0;
While ($univerisitynames[2][$n]!=""){
$schoolname =  $univerisitynames[2][$n];
echo "<div id='schs_".$n."' onclick=insertschool(\"".$schoolname."\",".$n.") ><font color=red>".$schoolname."</font></div><div id='results_".$n."'></div><br>";

$n++;
}
echo "<body onload=onload(".$n.")>";
?>
</div>
</html>