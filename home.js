
function refresh_duitasuo(pn,schoolid)
{

if (pn != "0"){
document.getElementById("nextpage").innerHTML ="<img src='images/loading.gif'>";

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_refresh_duitasuo=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_refresh_duitasuo=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_refresh_duitasuo.onreadystatechange=function()
  {
  if (xmlhttp_refresh_duitasuo.readyState==4 && xmlhttp_refresh_duitasuo.status==200)
    {
    var div=document.getElementById("nextpage"); 
    div.parentNode.removeChild(div); 
    document.getElementById("posts").innerHTML=document.getElementById("posts").innerHTML + xmlhttp_refresh_duitasuo.responseText;
    }
  }
xmlhttp_refresh_duitasuo.open("GET","server_refresh_love.php?pn="+pn+"&schoolid="+schoolid,true);
xmlhttp_refresh_duitasuo.send();
} else {
document.getElementById("refresh_posts").innerHTML="<img src='images/loading.gif'>";

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_refresh_duitasuo=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_refresh_duitasuo=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_refresh_duitasuo.onreadystatechange=function()
  {
  if (xmlhttp_refresh_duitasuo.readyState==4 && xmlhttp_refresh_duitasuo.status==200)
    {
    document.getElementById("refresh_posts").innerHTML="刷新";
    document.getElementById("posts").innerHTML=xmlhttp_refresh_duitasuo.responseText;
    }
  }
xmlhttp_refresh_duitasuo.open("GET","server_refresh_love.php?pn="+pn+"&schoolid="+schoolid,true);
xmlhttp_refresh_duitasuo.send();
}

}

function $_(id) {
    return document.getElementById(id);
}

function gender_switch(gender)
{

if (gender=='1'){
$_("gender").value = "女生";
$_("gender1").className = "cb-enable selected";
$_("gender2").className = "cb-disable";
document.getElementById("post_button").innerHTML = "对她说";
} else {
$_("gender").value = "男生";
$_("gender1").className = "cb-enable";
$_("gender2").className = "cb-disable selected";
document.getElementById("post_button").innerHTML = "对他说";
}

}

function time_switch(time)
{
$_("time_display").innerHTML = time;
}

function sayit()
{
document.getElementById("post_sayit").innerHTML = "请稍后";
}

function leave_comment(id)
{
var leave_comment_input_id = "leave_comment_input_"+id;

document.getElementById(leave_comment_input_id).innerHTML = "<textarea rows='2' type='text' id='leave_comment_textarea_"+id+"' class='leave_comment_textarea'></textarea>"+
"<a id='leave_comment_input_submit_"+id+"' class='leave_comment_input_submit' onclick='leave_comment_input_submit("+id+")'>回复</a>"+
"<a class='cancel_comment_input_submit' onclick='cancel_comment_input_submit("+id+")'>取消</a>";
}

function cancel_comment_input_submit(id) {
var leave_comment_input_id = "leave_comment_input_"+id;
document.getElementById(leave_comment_input_id).innerHTML = "";
}

function leave_comment_input_submit(id)
{
var leave_comment_input_submit_id = "leave_comment_input_submit_"+id;
document.getElementById(leave_comment_input_submit_id).innerHTML = "请稍后";

var leave_comment_input_id = "leave_comment_input_"+id;
var leave_comment_textarea_id = "leave_comment_textarea_"+id;
var comment = document.getElementById(leave_comment_textarea_id).value;
comment = encodeURIComponent(comment);
if (comment ==""){
alert("请输入你想对他/她说的话 :)");
} else {
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_leave_comment_input_submit=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_leave_comment_input_submit=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_leave_comment_input_submit.onreadystatechange=function()
  {
  if (xmlhttp_leave_comment_input_submit.readyState==4 && xmlhttp_leave_comment_input_submit.status==200 && xmlhttp_leave_comment_input_submit.responseText != "")
    {
    document.getElementById(leave_comment_input_id).innerHTML = "";
    document.getElementById("comments_"+id).innerHTML = document.getElementById("comments_"+id).innerHTML + xmlhttp_leave_comment_input_submit.responseText;
    }
  }
xmlhttp_leave_comment_input_submit.open("GET","server_leave_comment.php?id="+id+"&comment="+comment,true);
xmlhttp_leave_comment_input_submit.send();
}

}

function edit_msg(id)
{
var content_msg_id = "content_msg_"+id;
var content_msg_edit_id = "content_msg_edit_"+id;
var descr_msg_id = "descr_msg_"+id;
var words_msg_id = "words_msg_"+id;
var descr_msg = document.getElementById(descr_msg_id).innerHTML;
var words_msg = document.getElementById(words_msg_id).innerHTML;

	document.getElementById(content_msg_id).style.display = "none";
	document.getElementById(content_msg_edit_id).style.display = "";
	document.getElementById(content_msg_edit_id).innerHTML = 
	"<textarea type='text' rows='3' id='descr_msg_textarea_"+id+"' class='content_msg_edit_textarea'>"+descr_msg.replace(/\s+/g,' ')+"</textarea>"+
	"<textarea type='text' rows='3' id='words_msg_textarea_"+id+"' class='content_msg_edit_textarea'>"+words_msg.replace(/\s+/g,' ')+"</textarea>"+
	"<a id='content_msg_edit_submit_"+id+"' class='content_msg_edit_submit' onclick='edit_msg_submit("+id+")'>确定</a>"+
	"<a class='cancel_content_msg_edit_submit' onclick='cancel_edit_msg_submit("+id+")'>取消</a>";

}

function edit_msg_submit(id)
{
var content_msg_edit_submit_id = "content_msg_edit_submit_"+id;
document.getElementById(content_msg_edit_submit_id).innerHTML = "请稍后";

var content_msg_id = "content_msg_"+id;
var content_msg_edit_id = "content_msg_edit_"+id;
var descr_msg_id = "descr_msg_"+id;
var words_msg_id = "words_msg_"+id;

var descr_msg_textarea_id = "descr_msg_textarea_"+id;
var words_msg_textarea_id = "words_msg_textarea_"+id;
var descr_msg_textarea = document.getElementById(descr_msg_textarea_id).value;
var words_msg_textarea = document.getElementById(words_msg_textarea_id).value;
var descr = encodeURIComponent(descr_msg_textarea);
var words = encodeURIComponent(words_msg_textarea);

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_edit_msg_submit=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_edit_msg_submit=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_edit_msg_submit.onreadystatechange=function()
  {
  if (xmlhttp_edit_msg_submit.readyState==4 && xmlhttp_edit_msg_submit.status==200)
    {
	var edit_msg_submit = new Array();
	edit_msg_submit = xmlhttp_edit_msg_submit.responseText.split("|");
	document.getElementById(descr_msg_id).innerHTML = edit_msg_submit[0];
    document.getElementById(words_msg_id).innerHTML = edit_msg_submit[1];
    document.getElementById(content_msg_id).style.display = "";
    document.getElementById(content_msg_edit_id).style.display = "none";
    }
  }
xmlhttp_edit_msg_submit.open("GET","server_edit_msg_submit.php?id="+id+"&descr="+descr+"&words="+words,true);
xmlhttp_edit_msg_submit.send();

}

function cancel_edit_msg_submit(id)
{
var content_msg_id = "content_msg_"+id;
var content_msg_edit_id = "content_msg_edit_"+id;

document.getElementById(content_msg_id).style.display = "";
document.getElementById(content_msg_edit_id).style.display = "none";
}

function cancel_msg(id,schoolid) 
{
    document.getElementById("private_msg").style.visibility = "visible";
    document.getElementById("private_msg_form").innerHTML =
    "<h2>删除通告</h2>"+ 
    "<div id=\"private_msg_field\">"+
    "<div id=\"pmsg_close_question\">您确定要删除此通告么？通告删除后将无法复原。</div>"+
    "<div class=\"buttons\">"+
    "<p class=\"pmsg_close_question_yes\" onclick=\"cancel_msg_confirm("+id+","+schoolid+")\">确定</p>"+
    "<p class=\"pmsg_close_question_no\" onclick=\"close_pmsg()\">取消</p>"+
    "</div>";
    "</div>";
    window.scrollTo(0,0);
}

function cancel_msg_confirm(id,schoolid)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_cancel_msg=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_cancel_msg=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_cancel_msg.onreadystatechange=function()
  {
  if (xmlhttp_cancel_msg.readyState==4 && xmlhttp_cancel_msg.status==200)
    {
	document.getElementById("private_msg").style.visibility = "visible";
    document.getElementById("private_msg_form").innerHTML =
    "<h2>删除通告</h2>"+ 
    "<div id=\"private_msg_field\">"+
    "<div id=\"login_successful\">已经成功删除此通告。</div>"+
    "</div>";
    window.scrollTo(0,0);
    setTimeout("close_pmsg()",1800);
	refresh_duitasuo('0',schoolid);
    }
  }
xmlhttp_cancel_msg.open("GET","server_delete_msg.php?id="+id,true);
xmlhttp_cancel_msg.send();
}

function cancel_msg_my_msgs(id)
{
    document.getElementById("private_msg").style.visibility = "visible";
    document.getElementById("private_msg_form").innerHTML =
    "<h2>删除通告</h2>"+ 
    "<div id=\"private_msg_field\">"+
    "<div id=\"pmsg_close_question\">您确定要删除此通告么？通告删除后将无法复原。</div>"+
    "<div class=\"buttons\">"+
    "<p class=\"pmsg_close_question_yes\" onclick=\"cancel_msg_my_msgs_confirm("+id+")\">确定</p>"+
    "<p class=\"pmsg_close_question_no\" onclick=\"close_pmsg()\">取消</p>"+
    "</div>";
    "</div>";
    window.scrollTo(0,0);
}

function cancel_msg_my_msgs_confirm(id)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_cancel_msg_my_msgs=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_cancel_msg_my_msgs=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_cancel_msg_my_msgs.onreadystatechange=function()
  {
  if (xmlhttp_cancel_msg_my_msgs.readyState==4 && xmlhttp_cancel_msg_my_msgs.status==200)
    {
	document.getElementById("private_msg").style.visibility = "visible";
    document.getElementById("private_msg_form").innerHTML =
    "<h2>删除通告</h2>"+ 
    "<div id=\"private_msg_field\">"+
    "<div id=\"login_successful\">已经成功删除此通告。</div>"+
    "</div>";
    window.scrollTo(0,0);
    setTimeout("close_pmsg()",1800);
	see_my_msgs();
    }
  }
xmlhttp_cancel_msg_my_msgs.open("GET","server_delete_msg.php?id="+id,true);
xmlhttp_cancel_msg_my_msgs.send();
}

function cancel_msg_unread_comment(id)
{
    document.getElementById("private_msg").style.visibility = "visible";
    document.getElementById("private_msg_form").innerHTML =
    "<h2>删除通告</h2>"+ 
    "<div id=\"private_msg_field\">"+
    "<div id=\"pmsg_close_question\">您确定要删除此通告么？通告删除后将无法复原。</div>"+
    "<div class=\"buttons\">"+
    "<p class=\"pmsg_close_question_yes\" onclick=\"cancel_msg_unread_comment_confirm("+id+")\">确定</p>"+
    "<p class=\"pmsg_close_question_no\" onclick=\"close_pmsg()\">取消</p>"+
    "</div>";
    "</div>";
    window.scrollTo(0,0);
}

function cancel_msg_unread_comment_confirm(id)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_cancel_msg_unread_comment=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_cancel_msg_unread_comment=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_cancel_msg_unread_comment.onreadystatechange=function()
  {
  if (xmlhttp_cancel_msg_unread_comment.readyState==4 && xmlhttp_cancel_msg_unread_comment.status==200)
    {
	document.getElementById("private_msg").style.visibility = "visible";
    document.getElementById("private_msg_form").innerHTML =
    "<h2>删除通告</h2>"+ 
    "<div id=\"private_msg_field\">"+
    "<div id=\"login_successful\">已经成功删除此通告。</div>"+
    "</div>";
    window.scrollTo(0,0);
    setTimeout("close_pmsg()",1800);
	see_unread_comment();
    }
  }
xmlhttp_cancel_msg_unread_comment.open("GET","server_delete_msg.php?id="+id,true);
xmlhttp_cancel_msg_unread_comment.send();
}

function like_msg(id)
{
var like_msg_id = "like_msg_"+id;
var geili_id = "geili_"+id;

if (document.getElementById(like_msg_id).innerHTML == "给力")
{
document.getElementById(like_msg_id).innerHTML = "不给力";
var like = 1;
}
else 
{
document.getElementById(like_msg_id).innerHTML = "给力";
var like = 0;
}

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_like_msg=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_like_msg=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_like_msg.onreadystatechange=function()
  {
  if (xmlhttp_like_msg.readyState==4 && xmlhttp_like_msg.status==200 && xmlhttp_like_msg.responseText != "")
    {
    document.getElementById(geili_id).innerHTML=xmlhttp_like_msg.responseText;
    }
  }
xmlhttp_like_msg.open("GET","server_like_msg.php?id="+id+"&like="+like,true);
xmlhttp_like_msg.send();
}

function like_comment(id)
{
var like_comment_id = "like_comment_"+id;
var geili_id = "geili_comment_"+id;

if (document.getElementById(like_comment_id).innerHTML == "给力")
{
document.getElementById(like_comment_id).innerHTML = "不给力";
var like = 1;
}
else 
{
document.getElementById(like_comment_id).innerHTML = "给力";
var like = 0;
}

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_like_comment=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_like_comment=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_like_comment.onreadystatechange=function()
  {
  if (xmlhttp_like_comment.readyState==4 && xmlhttp_like_comment.status==200 && xmlhttp_like_comment.responseText != "")
    {
    document.getElementById(geili_id).innerHTML=xmlhttp_like_comment.responseText;
    }
  }
xmlhttp_like_comment.open("GET","server_like_comment.php?id="+id+"&like="+like,true);
xmlhttp_like_comment.send();
}

function online_user_counter()
{

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_online_user_counter=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_online_user_counter=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_online_user_counter.onreadystatechange=function()
  {
  if (xmlhttp_online_user_counter.readyState==4 && xmlhttp_online_user_counter.status==200)
    {
    
    }
  }
xmlhttp_online_user_counter.open("GET","server_online_count.php", true);
xmlhttp_online_user_counter.send(null);

}

var unread_comment_change = 0;
var unread_comment_duitasuo_title = "";

function unread_comment()
{
if (unread_comment_duitasuo_title == ""){
unread_comment_duitasuo_title = document.title;
}

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_unread_comment=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_unread_comment=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_unread_comment.onreadystatechange=function()
  {
  if (xmlhttp_unread_comment.readyState==4 && xmlhttp_unread_comment.status==200)
    {
    var unread_comment = xmlhttp_unread_comment.responseText.replace(/\s+/g,'');
    if (unread_comment=="nonewupdate"){
    document.getElementById("new_notification").className = "";
	document.getElementById("new_notification").innerHTML = "";
	unread_comment_change = 0;
	if (unread_pmsg_change == 0){
	document.title = unread_comment_duitasuo_title;
	}
    } else {
    document.getElementById("new_notification").className = "new_notification";
	
	if (unread_comment_change != unread_comment){
	if (unread_comment_change == 0){
	unread_comment_sendemail();
	}
	document.getElementById("new_notification").innerHTML = unread_comment;
	document.title = "对ta说【"+unread_comment+"条新消息】";
	}
	unread_comment_change = unread_comment;
	
	}
    
	}
  }
xmlhttp_unread_comment.open("GET","server_unread_comment.php", true);
xmlhttp_unread_comment.send(null);
}

function unread_comment_sendemail()
{
var update = 0;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_unread_comment_sendemail=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_unread_comment_sendemail=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_unread_comment_sendemail.onreadystatechange=function()
  {
  if (xmlhttp_unread_comment_sendemail.readyState==4 && xmlhttp_unread_comment_sendemail.status==200)
    {
    }
  }
xmlhttp_unread_comment_sendemail.open("GET","server_unread_sendemail.php?update="+update,true);
xmlhttp_unread_comment_sendemail.send();
}

function see_unread_comment()
{
document.getElementById("duitasuo_display").innerHTML = 
"<div id=\"post_status\" onselectstart=\"return false\">"+
"<div id=\"post_status_control\" class=\"post_status_control\">"+
"<a id=\"refresh_posts\" class=\"refresh_posts\" onclick=\"see_unread_comment()\"><img src=\"images/loading.gif\"></a>"+
"</div></div>"+
"<div id=\"posts\" class=\"posts\"></div>";

document.getElementById("new_notification").className = "";
document.getElementById("new_notification").innerHTML = "";

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_see_unread_comment=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_see_unread_comment=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_see_unread_comment.onreadystatechange=function()
  {
  if (xmlhttp_see_unread_comment.readyState==4 && xmlhttp_see_unread_comment.status==200)
    {
    document.getElementById("posts").innerHTML=xmlhttp_see_unread_comment.responseText;
    document.getElementById("refresh_posts").innerHTML="刷新";
    }
  }
xmlhttp_see_unread_comment.open("GET","server_see_unread_comment.php",true);
xmlhttp_see_unread_comment.send();
}

function refresh_top_posts()
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_refresh_top_posts=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_refresh_top_posts=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_refresh_top_posts.onreadystatechange=function()
  {
  if (xmlhttp_refresh_top_posts.readyState==4 && xmlhttp_refresh_top_posts.status==200)
    {
    document.getElementById("top_posts").innerHTML=xmlhttp_refresh_top_posts.responseText;
    }
  }
xmlhttp_refresh_top_posts.open("GET","server_refresh_top_posts.php",true);
xmlhttp_refresh_top_posts.send();
}

function login_signup()
{
 document.getElementById("login_signup").style.visibility = "visible";
}

function login(schoolid)
{
var renrenuserid = 0;
if (document.autologinform.autologin.checked == true){
var autologin = 1;
} else {
var autologin = 0;
}
var email = document.getElementById("login_email").value;
var password= document.getElementById("login_password").value;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_login=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_login=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_login.onreadystatechange=function()
  {
  if (xmlhttp_login.readyState==4 && xmlhttp_login.status==200)
    {
    if (xmlhttp_login.responseText=="login"){
    window.location="home.php?schoolid="+schoolid+"";
    }
    else {
	document.getElementById("login_message").className="login_error";
    document.getElementById("login_message").style.visibility="visible";
    document.getElementById("login_message").innerHTML=xmlhttp_login.responseText;
    }
    }
  }
xmlhttp_login.open("GET","index_login.php?login_email="+email+"&login_password="+password+"&autologin="+autologin+"&renrenuserid="+renrenuserid,true);
xmlhttp_login.send();
}

function finish_signup()
{
document.getElementById("finish_signup_button").innerHTML = "请稍后..";
var renrenuserid = 0;
var username = document.getElementById("signup_username").value;
username = encodeURIComponent(username);
var email = document.getElementById("signup_email").value;
var password= document.getElementById("signup_password").value;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_finish_signup=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_finish_signup=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_finish_signup.onreadystatechange=function()
  {
  if (xmlhttp_finish_signup.readyState==4 && xmlhttp_finish_signup.status==200)
    {
    if (xmlhttp_finish_signup.responseText=="sent"){
	document.getElementById("finish_signup_button").innerHTML = "完成";
    document.getElementById("signup_message").className="signup_successful";
    document.getElementById("signup_message").style.visibility="visible";
    document.getElementById("signup_message").innerHTML="注册成功！请查看邮箱去激活账户。";
    }
    else {
	document.getElementById("finish_signup_button").innerHTML = "完成";
    document.getElementById("signup_message").className="signup_error";
    document.getElementById("signup_message").style.visibility="visible";
    document.getElementById("signup_message").innerHTML=xmlhttp_finish_signup.responseText;
    }
    }
  }
xmlhttp_finish_signup.open("GET","index_signup.php?signup_email="+email+"&signup_password="+password+"&signup_username="+username+"&renrenuserid="+renrenuserid,true);
xmlhttp_finish_signup.send();
}

function close_signup()
{
 document.getElementById("login_signup").style.visibility = "hidden";
 document.getElementById("signup_message").style.visibility = "hidden";
 document.getElementById("login_message").style.visibility = "hidden";
}

function show_comment_bottom(id,classnum) 
{
var comment_bottom_id = "comment_bottom_"+id;
if (classnum == 1){
document.getElementById(comment_bottom_id).className = 'comment_bottom_owner';
} else if (classnum == 2){
document.getElementById(comment_bottom_id).className = 'comment_bottom_id';
} else {
document.getElementById(comment_bottom_id).className = 'comment_bottom_noid';
} 

}

function unshow_comment_bottom(id) 
{
var comment_bottom_id = "comment_bottom_"+id;
document.getElementById(comment_bottom_id).className = 'comment_bottom_none';
}

function open_pmsg(cmtid,cmtusername,cmtuserid,cmtuserip,msgid)
{
var cmtusername = encodeURIComponent(cmtusername);
cmtusername = decodeURIComponent(cmtusername);

document.getElementById("private_msg_field").innerHTML =
"<table class=\"private_msg_field_set\">"+
"<tr><td class=\"private_msg_field_set\">收件人：</td><td><div style=\"width: 455px;\" id=\"pmsg_to_username\">"+cmtusername+"</div></td></tr>"+
"<tr><td class=\"private_msg_field_set\">主题：</td><td><input type=\"text\" style=\"width: 455px;\" id=\"pmsg_title\"></td></tr>"+
"<tr><td class=\"private_msg_field_set\">内容：</td><td><textarea rows=\"4\" type=\"text\" style=\"width: 455px;\" id=\"pmsg_content\"></textarea></td></tr>"+
"</table>"+
"<div id=\"pmsg_cmtid\">"+cmtid+"</div>"+
"<div id=\"pmsg_msgid\">"+msgid+"</div>"+
"<div id=\"pmsg_to_userid\">"+cmtuserid+"</div>"+
"<div id=\"pmsg_to_userip\">"+cmtuserip+"</div>"+
"<div class=\"buttons\">"+
"<p id=\"finish_send_pmsg_button\" class=\"finish_send_pmsg_button\" onclick=\"send_pmsg()\">发送</p>"+
"<p class=\"cancel_send_pmsg_button\" onclick=\"close_pmsg()\">取消</p>"+
"</div>";

document.getElementById("private_msg").style.visibility = "visible";

window.scrollTo(0,0);
}

function close_pmsg() 
{
document.getElementById("private_msg").style.visibility = "hidden";
}

function send_pmsg()
{
var cmtid = document.getElementById("pmsg_cmtid").innerHTML;
var msgid = document.getElementById("pmsg_msgid").innerHTML;
var touserid = document.getElementById("pmsg_to_userid").innerHTML;
var touserip = document.getElementById("pmsg_to_userip").innerHTML;
var title= document.getElementById("pmsg_title").value;
var content= document.getElementById("pmsg_content").value;
title = encodeURIComponent(title);
content = encodeURIComponent(content);

if (title ==""){
alert("请输入邮件主题 :)");
} else if (content ==""){
alert("请输入邮件内容 :)");
} else {
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_send_pmsg=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_send_pmsg=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_send_pmsg.onreadystatechange=function()
  {
  if (xmlhttp_send_pmsg.readyState==4 && xmlhttp_send_pmsg.status==200)
    {
    document.getElementById("private_msg_field").innerHTML = "<div id=\"login_successful\">成功发送您的私密邮件。</div>";
    setTimeout("close_pmsg()",1800);
    }
  }
xmlhttp_send_pmsg.open("GET","server_send_pmsg.php?cmtid="+cmtid+"&msgid="+msgid+"&touserid="+touserid+"&touserip="+touserip+"&title="+title+"&content="+content,true);
xmlhttp_send_pmsg.send();
}

}

var unread_pmsg_change = 0;
var unread_pmsg_duitasuo_title = "";

function unread_pmsg()
{
if (unread_pmsg_duitasuo_title == ""){
unread_pmsg_duitasuo_title = document.title;
}

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_unread_pmsg=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_unread_pmsg=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_unread_pmsg.onreadystatechange=function()
  {
  if (xmlhttp_unread_pmsg.readyState==4 && xmlhttp_unread_pmsg.status==200)
    {
    var unread_pmsg = xmlhttp_unread_pmsg.responseText.replace(/\s+/g,'');
    if (unread_pmsg=="nonewupdate"){
    document.getElementById("new_message").className = "";
    document.getElementById("new_message").innerHTML = "";
	unread_pmsg_change = 0;
	if (unread_comment_change == 0){
	document.title = unread_pmsg_duitasuo_title;
	} 
    } else {
    document.getElementById("new_message").className = "new_message";
    
	if (unread_pmsg_change != unread_pmsg){
	if (unread_pmsg_change == 0){
	unread_pmsg_sendemail();
	}
	document.getElementById("new_message").innerHTML = unread_pmsg;
    document.title = "对ta说【"+unread_pmsg+"封新邮件】";
	}
	unread_pmsg_change = unread_pmsg;
	
	}
	
    }
  }
xmlhttp_unread_pmsg.open("GET","server_unread_pmsg.php", true);
xmlhttp_unread_pmsg.send(null);
}

function unread_pmsg_sendemail()
{
var update = 1;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_unread_pmsg_sendemail=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_unread_pmsg_sendemail=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_unread_pmsg_sendemail.onreadystatechange=function()
  {
  if (xmlhttp_unread_pmsg_sendemail.readyState==4 && xmlhttp_unread_pmsg_sendemail.status==200)
    {
    }
  }
xmlhttp_unread_pmsg_sendemail.open("GET","server_unread_sendemail.php?update="+update,true);
xmlhttp_unread_pmsg_sendemail.send();
}

function see_pmsg()
{
var pn = 1;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_see_pmsg=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_see_pmsg=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_see_pmsg.onreadystatechange=function()
  {
  if (xmlhttp_see_pmsg.readyState==4 && xmlhttp_see_pmsg.status==200)
    {
    document.getElementById("duitasuo_display").innerHTML = xmlhttp_see_pmsg.responseText;
    }
  }
xmlhttp_see_pmsg.open("GET","server_see_pmsg.php?pn="+pn,true);
xmlhttp_see_pmsg.send();
}

function see_pmsg_content(pmsgid,updateread)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_see_pmsg_content=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_see_pmsg_content=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_see_pmsg_content.onreadystatechange=function()
  {
  if (xmlhttp_see_pmsg_content.readyState==4 && xmlhttp_see_pmsg_content.status==200)
    {
    document.getElementById("duitasuo_display").innerHTML = xmlhttp_see_pmsg_content.responseText;
    }
  }
xmlhttp_see_pmsg_content.open("GET","server_see_pmsg_content.php?pmsgid="+pmsgid+"&updateread="+updateread,true);
xmlhttp_see_pmsg_content.send();
}

function reply_pmsg(pmsgid,otheruserid,otheruserip)
{
var content= document.getElementById("reply_pmsg_text").value;
content = encodeURIComponent(content);
document.getElementById("reply_pmsg_button").innerHTML = "请稍后";

if (content ==""){
alert("请输入回复的内容 :)");
} else {
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_reply_pmsg=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_reply_pmsg=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_reply_pmsg.onreadystatechange=function()
  {
  if (xmlhttp_reply_pmsg.readyState==4 && xmlhttp_reply_pmsg.status==200)
    {
	document.getElementById("reply_pmsg_button").innerHTML = "发送";
    document.getElementById("reply_pmsg_text").value = "";
    document.getElementById("pmsg_replys").innerHTML = document.getElementById("pmsg_replys").innerHTML + xmlhttp_reply_pmsg.responseText;
    }
  }
xmlhttp_reply_pmsg.open("GET","server_pmsg_reply.php?pmsgid="+pmsgid+"&otheruserid="+otheruserid+"&otheruserip="+otheruserip+"&content="+content,true);
xmlhttp_reply_pmsg.send();
}

}

function cancel_comment(cmtid)
{
var commentid = "comment_"+cmtid;
var removediv = document.getElementById(commentid);

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_cancel_comment=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_cancel_comment=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_cancel_comment.onreadystatechange=function()
  {
  if (xmlhttp_cancel_comment.readyState==4 && xmlhttp_cancel_comment.status==200)
    {
    document.getElementById("private_msg").style.visibility = "visible";
    document.getElementById("private_msg_form").innerHTML =
    "<h2>删除留言</h2>"+ 
    "<div id=\"private_msg_field\">"+
    "<div id=\"login_successful\">成功删除留言。</div>"+
    "</div>";
    setTimeout("close_pmsg()",1800);
    removediv.parentNode.removeChild(removediv);
    }
  }
xmlhttp_cancel_comment.open("GET","server_cancel_comment.php?cmtid="+cmtid,true);
xmlhttp_cancel_comment.send();
}

function set_pmsg_close_question(pmsgid)
{
    document.getElementById("private_msg").style.visibility = "visible";
    document.getElementById("private_msg_form").innerHTML =
    "<h2>关闭对话</h2>"+ 
    "<div id=\"private_msg_field\">"+
    "<div id=\"pmsg_close_question\">您确定要关闭此对话么？私密对话关闭后将不可返回，永远关闭。</div>"+
    "<div class=\"buttons\">"+
    "<p class=\"pmsg_close_question_yes\" onclick=\"set_pmsg_close("+pmsgid+")\">确定</p>"+
    "<p class=\"pmsg_close_question_no\" onclick=\"close_pmsg()\">取消</p>"+
    "</div>";
    "</div>";
    window.scrollTo(0,0);
}


function set_pmsg_close(pmsgid)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_set_pmsg_close=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_set_pmsg_close=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_set_pmsg_close.onreadystatechange=function()
  {
  if (xmlhttp_set_pmsg_close.readyState==4 && xmlhttp_set_pmsg_close.status==200)
    {
    document.getElementById("private_msg").style.visibility = "visible";
    document.getElementById("private_msg_form").innerHTML =
    "<h2>关闭对话</h2>"+ 
    "<div id=\"private_msg_field\">"+
    "<div id=\"login_successful\">已经成功关闭此私密对话。</div>"+
    "</div>";
    window.scrollTo(0,0);
    setTimeout("close_pmsg()",1800);
    see_pmsg();
    }
  }
xmlhttp_set_pmsg_close.open("GET","server_set_pmsg_close.php?pmsgid="+pmsgid,true);
xmlhttp_set_pmsg_close.send();
}

function set_pmsg_unread(pmsgid)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_set_pmsg_unread=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_set_pmsg_unread=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_set_pmsg_unread.onreadystatechange=function()
  {
  if (xmlhttp_set_pmsg_unread.readyState==4 && xmlhttp_set_pmsg_unread.status==200)
    {
    document.getElementById("private_msg").style.visibility = "visible";
    document.getElementById("private_msg_form").innerHTML =
    "<h2>标记未读</h2>"+ 
    "<div id=\"private_msg_field\">"+
    "<div id=\"login_successful\">已经成功标记此私密对话为未读。</div>"+
    "</div>";
    window.scrollTo(0,0);
    setTimeout("close_pmsg()",1800);
    see_pmsg();
    }
  }
xmlhttp_set_pmsg_unread.open("GET","server_set_pmsg_unread.php?pmsgid="+pmsgid,true);
xmlhttp_set_pmsg_unread.send();
}


function see_my_msgs()
{
document.getElementById("duitasuo_display").innerHTML = 
"<div id=\"post_status\" onselectstart=\"return false\">"+
"<div id=\"post_status_control\" class=\"post_status_control\">"+
"<a id=\"refresh_posts\" class=\"refresh_posts\" onclick=\"see_my_msgs()\"><img src=\"images/loading.gif\"></a>"+
"</div></div>"+
"<div id=\"posts\" class=\"posts\"></div>";

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_see_my_msgs=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_see_my_msgs=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_see_my_msgs.onreadystatechange=function()
  {
  if (xmlhttp_see_my_msgs.readyState==4 && xmlhttp_see_my_msgs.status==200)
    {
    document.getElementById("posts").innerHTML=xmlhttp_see_my_msgs.responseText;
    document.getElementById("refresh_posts").innerHTML="刷新";
    }
  }
xmlhttp_see_my_msgs.open("GET","server_see_my_msgs.php",true);
xmlhttp_see_my_msgs.send();
}

function post_msg(schoolid)
{
var gender = document.getElementById("gender").value;
var time = document.getElementById("time_display").innerHTML;
var place = document.getElementById("place").value;
var descr = document.getElementById("descr").value;
var words = document.getElementById("words").value;
gender = encodeURIComponent(gender);
time = encodeURIComponent(time);
place = encodeURIComponent(place);
descr = encodeURIComponent(descr);
words = encodeURIComponent(words);

if (place ==""){
alert("请输入您看到她/他的地点 :)");
} else if (descr ==""){
alert("请写下您对她/他的第一印象，描述的越详细，找到她/他的机会就越大！");
} else if (words ==""){
alert("请写下您想对她/他说的第一句话，她/他会看到哟 :)");
} else {
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_post_msg=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_post_msg=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_post_msg.onreadystatechange=function()
  {
  if (xmlhttp_post_msg.readyState==4 && xmlhttp_post_msg.status==200)
    {
    window.location="home.php?schoolid="+schoolid+"";
    }
  }
xmlhttp_post_msg.open("GET","server_post_love.php?gender="+gender+"&time="+time+"&place="+place+"&descr="+descr+"&words="+words+"&schoolid="+schoolid,true);
xmlhttp_post_msg.send();
}

}

function see_pmsg_page(pn)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_see_pmsg_page=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_see_pmsg_page=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_see_pmsg_page.onreadystatechange=function()
  {
  if (xmlhttp_see_pmsg_page.readyState==4 && xmlhttp_see_pmsg_page.status==200)
    {
    document.getElementById("duitasuo_display").innerHTML = xmlhttp_see_pmsg_page.responseText;
    }
  }
xmlhttp_see_pmsg_page.open("GET","server_see_pmsg.php?pn="+pn,true);
xmlhttp_see_pmsg_page.send();
}

var user_points = "";
function open_send_gift()
{
user_points = document.getElementById("user_points").innerHTML;

document.getElementById("send_gift_field").innerHTML = 
"<table class=\"send_gift_field_set\">"+
"<tr><td class=\"send_gift_field_set\">发送时间：</td><td><input type=\"text\" style=\"width: 250px;\" id=\"send_gift_time\" />（例子：2011/5/26 下午3点10分）</td></tr>"+
"<tr><td class=\"send_gift_field_set\">发送地址：</td><td><textarea rows=\"2\" type=\"text\" style=\"width: 453px;\" id=\"send_gift_location\"></textarea></td></tr>"+
"<tr><td class=\"send_gift_field_set\">要说的话：</td><td><textarea rows=\"4\" type=\"text\" style=\"width: 453px;\" id=\"send_gift_words\"></textarea></td></tr>"+
"<tr><td class=\"send_gift_field_set\">选择礼物：</td><td><div id=\"send_gift_choice\" style=\"width: 453px;\">"+
"<form name=\"select_gift\">"+
"<table width=\"460\" class=\"select_gift_table\">"+
"<tr>"+
"<td><img src=\"images/rose.png\" class=\"gift_pic\" onclick=\"show_gift_pic(0)\" /></td>"+
"<td width=\"90\">1.暗恋表白：</td>"+
"<td><input type=\"checkbox\" name=\"gift\" onclick=\"select_gift_checkbox(this)\" />玫瑰一朵，巧克力一块。 (说币：4500)</td>"+
"</tr>"+
"<tr>"+
"<td><img src=\"images/pen.gif\" class=\"gift_pic\" onclick=\"show_gift_pic(1)\" /></td>"+
"<td>2.学生礼物：</td>"+
"<td><input type=\"checkbox\" name=\"gift\" onclick=\"select_gift_checkbox(this)\" />彩色荧光笔一支，牛奶饮料一瓶，圆珠笔一支。 (说币：5500)</td>"+
"</tr>"+
"<tr>"+
"<td><img src=\"images/noodles.png\" class=\"gift_pic\" onclick=\"show_gift_pic(2)\" /></td>"+
"<td>3.考试礼物：</td>"+
"<td><input type=\"checkbox\" name=\"gift\" onclick=\"select_gift_checkbox(this)\" />方便面一盒，彩色荧光笔一支，铅笔3只，橡皮擦一只，燕麦棒一支。 (说币：9000)</td>"+
"</tr>"+
"<tr>"+
"<td><img src=\"images/clock.png\" class=\"gift_pic\" onclick=\"show_gift_pic(3)\" /></td>"+
"<td>4.新学期礼物：</td>"+
"<td><input type=\"checkbox\" name=\"gift\" onclick=\"select_gift_checkbox(this)\" />方便面一盒，巧克力一块，闹钟一个，饼干(小包)。 (说币：10000)</td>"+
"</tr>"+
"<tr>"+
"<td><img src=\"images/chocolate.png\" class=\"gift_pic\" onclick=\"show_gift_pic(4)\" /></td>"+
"<td>5.单独礼物：</td>"+
"<td><input type=\"checkbox\" name=\"gift\" onclick=\"select_gift_checkbox(this)\" />玫瑰一朵 (说币：1000)  <br><input type=\"checkbox\" name=\"gift\" onclick=\"select_gift_checkbox(this)\" />巧克力一块 (说币：2500)</td>"+
"</tr>"+
"</table>"+
"<table width=\"470\" class=\"select_gift_table\">"+
"<tr>"+
"<td width=\"80\">已选的礼物：</td>"+
"<td class=\"selected_gifts_name\"><div id=\"selected_gifts\"></div></td>"+
"</tr>"+
"</table>"+
"</form>"+
"</div></td></tr>"+
"</table>"+
"<div class=\"buttons\">"+
"<p id=\"send_gift_button\" class=\"finish_send_pmsg_button\" onclick=\"send_gift()\">发送</p>"+
"<p class=\"cancel_send_pmsg_button\" onclick=\"close_send_gift()\">取消</p>"+
"</div>";

document.getElementById("send_gift").style.visibility = "visible";
window.scrollTo(0,0);
}

function close_send_gift()
{
document.getElementById("send_gift_pic_field").innerHTML = "";
document.getElementById("send_gift_pic_name").innerHTML = "礼物照片";
document.getElementById("send_gift").style.visibility = "hidden";
document.getElementById("user_points").innerHTML = user_points;
}

function select_gift_checkbox(checkbox)
{
var num = "";
for (var i=0; i < document.select_gift.gift.length; i++)
    {
    if (document.select_gift.gift[i].checked)
        {
		num = num + i +",";
		}
	}

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_select_gift_checkbox=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_select_gift_checkbox=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_select_gift_checkbox.onreadystatechange=function()
  {
  if (xmlhttp_select_gift_checkbox.readyState==4 && xmlhttp_select_gift_checkbox.status==200)
    {	
	var select_gift_result = new Array();
	select_gift_result = xmlhttp_select_gift_checkbox.responseText.split("|");
	if (select_gift_result[0] == "nopointsleft"){
	alert("对不起，您的说币余额不足！");
	checkbox.checked = false;
	} else {
	document.getElementById("user_points").innerHTML = select_gift_result[0];
	document.getElementById("selected_gifts").innerHTML = select_gift_result[1];
	}
	
	}
  }
xmlhttp_select_gift_checkbox.open("GET","server_select_gift.php?num="+num,true);
xmlhttp_select_gift_checkbox.send();	
	 
}

function send_gift()
{
var time = encodeURIComponent(document.getElementById("send_gift_time").value);
var location = encodeURIComponent(document.getElementById("send_gift_location").value);
var words = encodeURIComponent(document.getElementById("send_gift_words").value);

if (time.replace(/\s+/g,' ') == "" || location.replace(/\s+/g,' ') == "" || words.replace(/\s+/g,' ') == ""){
alert("请正确填入所有的信息。");
} else if (document.getElementById("selected_gifts").innerHTML == ""){
alert("请您选择至少一件礼物。");
} else {
document.getElementById("send_gift_button").innerHTML = "发送中..";

var num = "";
for (var i=0; i < document.select_gift.gift.length; i++)
    {
    if (document.select_gift.gift[i].checked)
        {
		num = num + i +",";
		}
	}

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_send_gift=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_send_gift=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_send_gift.onreadystatechange=function()
  {
  if (xmlhttp_send_gift.readyState==4 && xmlhttp_send_gift.status==200)
    {
	document.getElementById("send_gift_button").innerHTML = "发送";
	document.getElementById("send_gift").style.visibility = "hidden";
    document.getElementById("private_msg").style.visibility = "visible";
    document.getElementById("private_msg_form").innerHTML =
    "<h2>送礼物</h2>"+ 
    "<div id=\"private_msg_field\">"+
    "<div id=\"login_successful\">已经成功申请发送礼物，请耐心等待我们的回复。</div>"+
    "</div>";
    window.scrollTo(0,0);
    setTimeout("close_pmsg()",1800);
	}
  }
xmlhttp_send_gift.open("GET","server_send_gift.php?time="+time+"&location="+location+"&words="+words+"&num="+num,true);
xmlhttp_send_gift.send();	
}

}

function show_gift_pic(num)
{
if (num == 0){
var gift_pic_name = "暗恋表白";
} else if (num == 1){
var gift_pic_name = "学生礼物";
} else if (num == 2){
var gift_pic_name = "考试礼物";
} else if (num == 3){
var gift_pic_name = "新学期礼物";
} else if (num == 4){
var gift_pic_name = "单独礼物";
}
document.getElementById("send_gift_pic_name").innerHTML = "礼物照片 - "+gift_pic_name;
var pic_name = "giftpic_"+num+".jpg";
document.getElementById("send_gift_pic_field").innerHTML = "<img src=\"images/"+pic_name+"\" height=\"235\" width=\"235\" />";
}

function cancel_show_gift_pic()
{
document.getElementById("send_gift_pic_name").innerHTML = "礼物照片";
document.getElementById("send_gift_pic_field").innerHTML = "";
}

function campus_search()
{
var schoolname = escape(document.getElementById("campus_search_input").value);

if (schoolname.length==0)
  { 
  document.getElementById("search_results").style.visibility = "hidden";
  document.getElementById("search_results").innerHTML = "";
  return;
  } 
else 
  {
  document.getElementById("search_results").style.visibility = "visible";
  document.getElementById("search_results").innerHTML = "<div class=\"choose_school_more\">搜索学校中...</div>";
  }
  
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_campus_search=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_campus_search=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_campus_search.onreadystatechange=function()
  {
  if (xmlhttp_campus_search.readyState==4 && xmlhttp_campus_search.status==200)
    {
    document.getElementById("search_results").style.visibility = "visible";
    document.getElementById("search_results").innerHTML = xmlhttp_campus_search.responseText;
    }
  }
xmlhttp_campus_search.open("GET","server_campus_search.php?name="+schoolname,true);
xmlhttp_campus_search.send();

}

function goto_school(id)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_goto_school=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_goto_school=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_goto_school.onreadystatechange=function()
  {
  if (xmlhttp_goto_school.readyState==4 && xmlhttp_goto_school.status==200)
    {
    }
  }
xmlhttp_goto_school.open("GET","server_goto_school.php?id="+id,true);
xmlhttp_goto_school.send();
}