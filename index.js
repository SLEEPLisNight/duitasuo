function init() 
{
var t = setInterval(function(){refresh_five_new_msgs();},1000);
}

/*   insert school name  */

function insertschool(schoolname,n)
{
var schoolname = escape(schoolname);
var resultid = "results_"+n;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_insertschool=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_insertschool=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_insertschool.onreadystatechange=function()
  {
  if (xmlhttp_insertschool.readyState==4 && xmlhttp_insertschool.status==200)
    {
    document.getElementById(resultid).innerHTML = xmlhttp_insertschool.responseText;
    }
  }
xmlhttp_insertschool.open("GET","server_insert_school.php?schoolname="+schoolname,true);
xmlhttp_insertschool.send();
}

/*   insert school name  */

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

function refresh_five_new_msgs()
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_newmsgs=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_newmsgs=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_newmsgs.onreadystatechange=function()
  {
  if (xmlhttp_newmsgs.readyState==4 && xmlhttp_newmsgs.status==200 && xmlhttp_newmsgs.responseText != "nonewposts")
    {
    document.getElementById("five_msgs").innerHTML= xmlhttp_newmsgs.responseText+document.getElementById("five_msgs").innerHTML;
    var parent = document.getElementById("five_msgs");
    var firstchild = parent.firstChild;
    $(firstchild).fadeIn("2000");
    var i = 0; 
    var realKids = 0;
    var kids = parent.childNodes.length;
    while(i < kids){
		if(parent.childNodes[i].nodeType != 3){
			realKids++;
		}
		i++;
    }
    
    while (realKids > 5){
    var lastchild = parent.lastChild;
    parent.removeChild(lastchild);
    realKids--;
    }
    
    }
  }
xmlhttp_newmsgs.open("GET","server_refresh_top_posts_index.php",true);
xmlhttp_newmsgs.send();
}

function login()
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
    window.location="index.php";
    }
    else {
	document.getElementById("login_message").className="login_error";
    document.getElementById("login_message").innerHTML=xmlhttp_login.responseText;
    }
    }
  }
xmlhttp_login.open("GET","index_login.php?login_email="+email+"&login_password="+password+"&autologin="+autologin+"&renrenuserid="+renrenuserid,true);
xmlhttp_login.send();
}

function signup()
{
 document.getElementById("signup").style.visibility = "visible";
}

function finish_signup()
{
document.getElementById("finish_signup_button").innerHTML = "请稍后";
var renrenuserid = 0;
var username = document.getElementById("signup_username").value;
/*
username = escape(username);
*/
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
 document.getElementById("signup").style.visibility = "hidden";
 document.getElementById("signup_message").style.visibility = "hidden";
}

function renren_bangding()
{
document.getElementById("bangding_login_signup").style.visibility = "visible";
}

function close_bangding()
{
document.getElementById("bangding_login_signup").style.visibility = "hidden";
document.getElementById("bangding_signup_message").style.visibility = "hidden";
document.getElementById("bangding_login_message").style.visibility = "hidden";
}

function bangding_login(renrenuserid)
{
if (document.bangding_autologinform.bangding_autologin.checked == true){
var autologin = 1;
} else {
var autologin = 0;
}
var email = document.getElementById("bangding_login_email").value;
var password= document.getElementById("bangding_login_password").value;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_bangding_login=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_bangding_login=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_bangding_login.onreadystatechange=function()
  {
  if (xmlhttp_bangding_login.readyState==4 && xmlhttp_bangding_login.status==200)
    {
    if (xmlhttp_bangding_login.responseText=="login"){
    window.location="index.php";
    }
    else {
	document.getElementById("bangding_login_message").className="login_error";
    document.getElementById("bangding_login_message").innerHTML=xmlhttp_bangding_login.responseText;
    }
    }
  }
xmlhttp_bangding_login.open("GET","index_login.php?login_email="+email+"&login_password="+password+"&autologin="+autologin+"&renrenuserid="+renrenuserid,true);
xmlhttp_bangding_login.send();
}

function bangding_signup(renrenuserid)
{
document.getElementById("bangding_signup_button").innerHTML = "请稍后";

var username = document.getElementById("bangding_signup_username").value;
/*
username = escape(username);
*/
var email = document.getElementById("bangding_signup_email").value;
var password= document.getElementById("bangding_signup_password").value;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp_bangding_signup=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp_bangding_signup=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_bangding_signup.onreadystatechange=function()
  {
  if (xmlhttp_bangding_signup.readyState==4 && xmlhttp_bangding_signup.status==200)
    {
    if (xmlhttp_bangding_signup.responseText=="sent"){
	document.getElementById("bangding_signup_button").innerHTML = "完成";
    document.getElementById("bangding_signup_message").className="signup_successful";
    document.getElementById("bangding_signup_message").style.visibility="visible";
    document.getElementById("bangding_signup_message").innerHTML="注册成功！请查看邮箱去激活账户。";
    }
    else {
	document.getElementById("bangding_signup_button").innerHTML = "完成";
    document.getElementById("bangding_signup_message").className="signup_error";
    document.getElementById("bangding_signup_message").style.visibility="visible";
    document.getElementById("bangding_signup_message").innerHTML=xmlhttp_bangding_signup.responseText;
    }
    }
  }
xmlhttp_bangding_signup.open("GET","index_signup.php?signup_email="+email+"&signup_password="+password+"&signup_username="+username+"&renrenuserid="+renrenuserid,true);
xmlhttp_bangding_signup.send();
}
