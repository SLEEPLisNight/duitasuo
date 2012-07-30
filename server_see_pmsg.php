<?php
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';  // connect to mysql database.
if (isset($_SESSION['id'])){
$userid = $_SESSION['id']; // assign SESSION 'id' value to $userid.
} else {
$userid = 0;
}
$ip = $_SESSION['ip'];

if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
}


$pmsgs_num = 0;
$sql2 = mysql_query("SELECT * FROM duitasuopmsg WHERE touserid='$userid' OR userid='$userid' ORDER BY timesubmit DESC") OR die(mysql_query());
while ($row_sql2 = mysql_fetch_assoc($sql2))
{
 $touserid = $row_sql2['touserid'];
 $touserip = $row_sql2['touserip'];
 $fromuserid = $row_sql2['userid'];
 $fromuserip = $row_sql2['userip'];
 
 if ($userid != 0 && $userid == $touserid) {
 $pmsgowner = 1;
 $pmsgreceiver = 1;
 } else if ($userid != 0 && $userid == $fromuserid) {
 $pmsgowner = 1;
 $pmsgreceiver = 0;
 } else if ($userid == 0 && $touserid == 0 && $ip == $touserip){
 $pmsgowner = 1;
 $pmsgreceiver = 1;
 } else if ($userid == 0 && $fromuserid == 0 && $ip == $fromuserip){
 $pmsgowner = 1;
 $pmsgreceiver = 0;
 } else {
 $pmsgowner = 0;
 }
 
 if ($pmsgowner == 1){
 $pmsgs_num++;
 }
} 

$sql = mysql_query("SELECT * FROM duitasuopmsg WHERE touserid='$userid' OR userid='$userid' ORDER BY timesubmit DESC") OR die(mysql_query());
$nr = mysql_num_rows($sql); 

//This is where we set how many database items to show on each page 
$itemsPerPage = 20; 
// Get the value of the last page in the pagination result set
$lastPage = ceil($nr / $itemsPerPage);
// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
} 
// This creates the numbers to click in between the next and back buttons
// This section is explained well in the video that accompanies this script
$centerPages = "";
$sub1 = $pn - 1;
$sub2 = $pn - 2;
$add1 = $pn + 1;
$add2 = $pn + 2;

if ($pn == 1) {
    $centerPages .= '<a class="pmsg_pages_number_selected">'.$pn.'</a>';
    $centerPages .= '<a class="pmsg_pages_number" onclick="see_pmsg_page('.$add1.')">'.$add1.'</a>';
} else if ($pn == $lastPage) {
    $centerPages .= '<a class="pmsg_pages_number" onclick="see_pmsg_page('.$sub1.')">'.$sub1.'</a>';
    $centerPages .= '<a class="pmsg_pages_number_selected">'.$pn.'</a>';
} else if ($pn > 2 && $pn < ($lastPage - 1)) {
    $centerPages .= '<a class="pmsg_pages_number" onclick="see_pmsg_page('.$sub2.')">'.$sub2.'</a>';
    $centerPages .= '<a class="pmsg_pages_number" onclick="see_pmsg_page('.$sub1.')">'.$sub1.'</a>';
    $centerPages .= '<a class="pmsg_pages_number_selected">'.$pn.'</a>';
    $centerPages .= '<a class="pmsg_pages_number" onclick="see_pmsg_page('.$add1.')">'.$add1.'</a>';
    $centerPages .= '<a class="pmsg_pages_number" onclick="see_pmsg_page('.$add2.')">'.$add2.'</a>';
} else if ($pn > 1 && $pn < $lastPage) {
    $centerPages .= '<a class="pmsg_pages_number" onclick="see_pmsg_page('.$sub1.')">'.$sub1.'</a>';
    $centerPages .= '<a class="pmsg_pages_number_selected">'.$pn.'</a>';
    $centerPages .= '<a class="pmsg_pages_number" onclick="see_pmsg_page('.$add1.')">'.$add1.'</a>';
}

$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is ot equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    /*
    $paginationDisplay .='页面：<div class="pmsg_pages_number_selected">'.$pn.'</div> of <div class="pmsg_pages_number_selected">'.$lastPage.'</div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    */
    $paginationDisplay .= '<a class="pmsg_pages_nav" onclick="see_pmsg_page(1)">第一页</a>';
    // If we are not on page 1 we can place the Back button
    if ($pn != 1) {
        $previous = $pn - 1;
        $paginationDisplay .= '<a class="pmsg_pages_nav" onclick="see_pmsg_page('.$previous.')">上一页</a>';
    } 
    // Lay in the clickable numbers display here between the Back and Next links
    $paginationDisplay .= $centerPages;
    // If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .= '<a class="pmsg_pages_nav" onclick="see_pmsg_page('.$nextPage.')">下一页</a>';
    } 
    $paginationDisplay .= '<a class="pmsg_pages_nav" onclick="see_pmsg_page('.$lastPage.')">最后页</a>';
}

// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage; 

echo "<div id='pmsg_rows_form'>
      <h2>私密留言信</h2>
      <div id='pmsg_rows_box'>";

if ($pmsgs_num > 0){  
echo "<div class='pmsg_pages'>
      <div class='pmsg_pages_total_number'>共".$pmsgs_num."封</div>
      <div class='pmsg_pages_control'>".$paginationDisplay."</div>
      </div>";
}
	  
echo "<table class='pmsg_rows'>";

if ($pmsgs_num > 0){
$duitasuo_pmsg = mysql_query("SELECT * FROM duitasuopmsg WHERE touserid='$userid' OR userid='$userid' ORDER BY timesubmit DESC $limit") OR die(mysql_query());
while ($row = mysql_fetch_assoc($duitasuo_pmsg))
{
 $touserid = $row['touserid'];
 $touserip = $row['touserip'];
 $fromuserid = $row['userid'];
 $fromuserip = $row['userip'];
 
 if ($userid != 0 && $userid == $touserid) {
 $pmsgowner = 1;
 $pmsgreceiver = 1;
 } else if ($userid != 0 && $userid == $fromuserid) {
 $pmsgowner = 1;
 $pmsgreceiver = 0;
 } else if ($userid == 0 && $touserid == 0 && $ip == $touserip){
 $pmsgowner = 1;
 $pmsgreceiver = 1;
 } else if ($userid == 0 && $fromuserid == 0 && $ip == $fromuserip){
 $pmsgowner = 1;
 $pmsgreceiver = 0;
 } else {
 $pmsgowner = 0;
 }
 
 if ($pmsgowner == 1){
 $pmsgid = $row['id'];
 $msgid = $row['msgid'];
 $cmtid = $row['cmtid'];
 $fromuserid = $row['userid'];
 $title = $row['title'];
 $content = $row['content'];
 $timesubmit = $row['timesubmit'];
 $readit = $row['readit'];
 $block = $row['block'];
 
 $duitasuo_pmsg_user = mysql_query("SELECT * FROM users WHERE id='$fromuserid' ORDER BY id ASC;") OR die(mysql_query());      
 $row_pmsg_user = mysql_fetch_assoc($duitasuo_pmsg_user);
 $fromusername = $row_pmsg_user['username'];
 
 $sendtime = date('Y-m-d g:ia',strtotime("-4 hour",$timesubmit));
 
 $reply = 0;
 $duitasuo_pmsg_lastreply = mysql_query("SELECT * FROM duitasuopmsgreply WHERE pmsgid='$pmsgid' ORDER BY timesubmit DESC") OR die(mysql_query());
 while ($row_pmsg_lastreply = mysql_fetch_assoc($duitasuo_pmsg_lastreply)){
 $touserid_reply = $row_pmsg_lastreply['touserid'];
 $touserip_reply = $row_pmsg_lastreply['touserip'];
 $fromuserid_reply = $row_pmsg_lastreply['userid'];
 $fromuserip_reply = $row_pmsg_lastreply['userip'];
 
 if ($userid != 0 && $userid == $touserid_reply) {
 $pmsg_reply_receiver = 1;
 } else if ($userid != 0 && $userid == $fromuserid_reply) {
 $pmsg_reply_receiver = 0;
 } else if ($userid == 0 && $touserid_reply == 0 && $ip == $touserip_reply){
 $pmsg_reply_receiver = 1;
 } else if ($userid == 0 && $fromuserid_reply == 0 && $ip == $fromuserip_reply){
 $pmsg_reply_receiver = 0;
 }
 
 $readit_reply = $row_pmsg_lastreply['readit'];
 $timesubmit_reply = $row_pmsg_lastreply['timesubmit'];
 $content_reply = $row_pmsg_lastreply['content'];
 
 $duitasuo_pmsg_reply_user = mysql_query("SELECT * FROM users WHERE id='$fromuserid_reply' ORDER BY id ASC;") OR die(mysql_query());      
 $row_pmsg_reply_user = mysql_fetch_assoc($duitasuo_pmsg_reply_user);
 $fromusername_reply = $row_pmsg_reply_user['username'];
 
 $replytime = date('Y-m-d g:ia',strtotime("-4 hour",$timesubmit_reply));
 
 if ($pmsg_reply_receiver == 1 && $readit_reply == 0){
 echo "<tr id='pmsg_".$pmsgid."' class='unread_pmsg'>";
 echo "<td class='name_and_date'><span class='fromusername'>".$fromusername_reply."</span>
           <span class='date'>".$replytime."</span></td>";
 echo "<td class='title_and_content' onclick=see_pmsg_content(".$pmsgid.",\"1\")><a><span class='title'>回复：".$title."</span></a>
           <a><span class='words'>".$content_reply."</span></a></td>";
 } else {
 echo "<tr id='pmsg_".$pmsgid."' class='read_pmsg'>";
 echo "<td class='name_and_date'><span class='fromusername'>".$fromusername_reply."</span>
           <span class='date'>".$replytime."</span></td>";
 echo "<td class='title_and_content' onclick=see_pmsg_content(".$pmsgid.",\"0\")><a><span class='title'>回复：".$title."</span></a>
           <a><span class='words'>".$content_reply."</span></a></td>";
 }
 echo "</tr>";
 
 
 $reply = 1;
 break;
 }
 
 if ($reply == 1){
 
 } else { 
 if ($pmsgreceiver == 1 && $readit == 0){
 echo "<tr id='pmsg_".$pmsgid."' class='unread_pmsg'>";
 echo "<td class='name_and_date'><span class='fromusername'>".$fromusername."</span>
           <span class='date'>".$sendtime."</span></td>";
 echo "<td class='title_and_content' onclick=see_pmsg_content(".$pmsgid.",\"1\")><a><span class='title'>".$title."</span></a>
           <a><span class='words'>".$content."</span></a></td>";
 } else {
 echo "<tr id='pmsg_".$pmsgid."' class='read_pmsg'>";
 echo "<td class='name_and_date'><span class='fromusername'>".$fromusername."</span>
           <span class='date'>".$sendtime."</span></td>";
 echo "<td class='title_and_content' onclick=see_pmsg_content(".$pmsgid.",\"0\")><a><span class='title'>".$title."</span></a>
           <a><span class='words'>".$content."</span></a></td>";
 }
 echo "</tr>";
 }
 
 }

}

} //if ($pmsgs_num > 0)

echo "</table>";

if ($pmsgs_num == 0){
echo "<div class='no_pmsgs'>您还没有留言信，要多多留言哟。</div>";
} else if($pmsgs_num > 0) {
echo  "<div class='pmsg_pages_bottom'>
      <div class='pmsg_pages_total_number'>共".$pmsgs_num."封</div>
      <div class='pmsg_pages_control'>".$paginationDisplay."</div>
      </div>";
}  

echo "</div>
      </div>";

?>