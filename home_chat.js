var chatbox_number = 0;
var chatbox_number_remove = new Array();
var chatbox_content = new Array();
var chatbox_open = new Array();
var chatbox_min_open = new Array();
var chatbox_offline = new Array();
var h = 0;
var t1;
var t2;
var t_write = new Array();
var t_friends;
var lastmsg = "";
var t_chat_animation = new Array();
var t_chat_animation_click_move_right;
var t_chat_animation_click_move_left;
var t_chat_animation_click_move_up;
var t_chat_animation_click_move_down;
var t_chat_animation_others_move_right = new Array();
var t_chat_animation_others_move_left = new Array();
var t_chat_animation_others_move_up = new Array();
var t_chat_animation_others_move_down = new Array();
var t_chat_animation_see_msgs_move_div;

function encode_utf8(s)
{
  return unescape( encodeURIComponent(s));
}

function decode_utf8(s)
{
  return decodeURIComponent(escape(s));
}

function show_chat_panel(){

var chat_bottom_onclick = "chat_bottom_onclick";

if (document.getElementById("bottombar").className == chat_bottom_onclick){
document.getElementById("chat_panel").style.visibility = "hidden";
document.getElementById("chat_animation").style.display = "none";
/*
document.body.style.overflow = 'auto';
*/
document.getElementById("bottombar").className = "chat_bottom";
clearInterval(t_friends);
}
else {
document.getElementById("chat_panel").style.visibility = "visible";
document.getElementById("chat_animation").style.display = "inline";
chat_animation_start();
/*
chat_animation_start_move();
*/
document.getElementById("bottombar").className = "chat_bottom_onclick";
chat_panel_question();
}

}

function chat_panel_question() 
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_panel_question=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_panel_question=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_panel_question.onreadystatechange=function()
  {
  if (xmlhttp_chat_panel_question.readyState==4 && xmlhttp_chat_panel_question.status==200)
    {
	var chat_panel_question_answer = new Array();
	chat_panel_question_answer = xmlhttp_chat_panel_question.responseText.split("|");
    if (chat_panel_question_answer[0] == "0"){
	if (chat_panel_question_answer[1] != "0"){
	document.getElementById("chat_panel_users").innerHTML = 
	"<div class=\"chat_panel_questions_background\">"+
	"<div class=\"chat_panel_questions\">您要匿名登录聊天么？</div>"+
	"<form class=\"chat_panel_questions\">"+
	"<input type=\"radio\" id=\"chat_anonymous_yes\" name=\"chat_anonymous\" value=\"1\" checked=\"checked\" />是"+
	"<input type=\"radio\" id=\"chat_anonymous_no\" name=\"chat_anonymous\" value=\"0\" />否"+
	"</form>"+
	"<div class=\"chat_panel_questions2\">您现在的具体位置：</div>"+
	"<input type=\"text\" id=\"chat_place\" class=\"chat_panel_questions3\" />"+
	"<div class=\"chat_panel_buttons\">"+
    "<p class=\"chat_anonymous_button\" onclick=\"chat_panel_question_submit(1)\">确定</p>"+
    "<p class=\"cancel_chat_anonymous_button\" onclick=\"chat_panel_question_cancel()\">直接进入</p>"+
    "</div></div>";
	} else {
	document.getElementById("chat_panel_users").innerHTML = 
	"<div class=\"chat_panel_questions_background\">"+
	"<div class=\"chat_panel_questions\">您现在还未登录 >_<</div>"+
	"<div class=\"chat_panel_questions\">请您 (<a onclick=\"login_signup()\"><font color=\"red\">登录</font></a>)</div>"+
	"<div class=\"chat_panel_questions2\">您现在的具体位置：</div>"+
	"<input type=\"text\" id=\"chat_place\" class=\"chat_panel_questions3\" />"+
	"<div class=\"chat_panel_buttons\">"+
    "<p class=\"chat_anonymous_button\" onclick=\"chat_panel_question_submit(0)\">确定</p>"+
    "<p class=\"cancel_chat_anonymous_button\" onclick=\"chat_panel_question_cancel()\">直接进入</p>"+
    "</div></div>";
	} 
	} else {
	chat_online_friends();
	t_friends = setInterval(function(){chat_online_friends();},5000);
	}
	}
  }
xmlhttp_chat_panel_question.open("GET","chat/chat_panel_question.php", true);
xmlhttp_chat_panel_question.send(null);

}

function chat_panel_question_submit(niming)
{
if (niming == 1){
	if (document.getElementById("chat_anonymous_yes").checked){
	var anonymous = 1;
	} else {
	var anonymous = 2;
	}
	var place = document.getElementById("chat_place").value;
	place = encodeURIComponent(place);
	} 
else {	
	var anonymous = 2;
	var place = document.getElementById("chat_place").value;
	place = encodeURIComponent(place);
	}
	
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_panel_question_submit=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_panel_question_submit=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_panel_question_submit.onreadystatechange=function()
  {
  if (xmlhttp_chat_panel_question_submit.readyState==4 && xmlhttp_chat_panel_question_submit.status==200)
    {
	chat_online_friends();
	t_friends = setInterval(function(){chat_online_friends();},5000);
	}
  }
xmlhttp_chat_panel_question_submit.open("GET","chat/chat_panel_question_submit.php?anonymous="+anonymous+"&place="+place, true);
xmlhttp_chat_panel_question_submit.send(null);

}

function chat_panel_question_cancel()
{
var anonymous = 2;
var place = "";

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_panel_question_cancel=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_panel_question_cancel=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_panel_question_cancel.onreadystatechange=function()
  {
  if (xmlhttp_chat_panel_question_cancel.readyState==4 && xmlhttp_chat_panel_question_cancel.status==200)
    {
	chat_online_friends();
	t_friends = setInterval(function(){chat_online_friends();},5000);
	}
  }
xmlhttp_chat_panel_question_cancel.open("GET","chat/chat_panel_question_submit.php?anonymous="+anonymous+"&place="+place, true);
xmlhttp_chat_panel_question_cancel.send(null);

}

function chatwith(num,id,chatid,name) { 
		
        if (chatbox_open[num] != true && chatbox_min_open[num] != true){
         
        chat_output_open(num,id,chatid);
         
        if (chatbox_content[num] == undefined)
        {
        chatbox_content[num] = "";
        } 
         
        var div = document.createElement("div");    
        div.id = "chatbox_"+num;
        div.className ="chatbox"; 
        
        if (h>0){
        
        var min = 100000;
        for (var i=0; i<h; i++){
        if (chatbox_number_remove[i] <= min){
        min = chatbox_number_remove[i];
        }
        } 
        
        for (var i=0; i<h; i++){ 
        if (chatbox_number_remove[i] == min){
        div.style.right = min*261+221+"px"; 
		if (chatbox_offline[num] == 1){
		div.innerHTML = "<div class='chatbox_head'><div class='chatbox_name'>"+decode_utf8(name)+"</div>"+
        "<div id='chatbox_writing_"+num+"' class='chatbox_writing'></div>"+
        "<div class='chatbox_min' onmouseover=this.className='chatbox_min_onmouseover' onmouseout=this.className='chatbox_min' onclick='min_chatbox(\""+num+"\",\""+id+"\",\""+chatid+"\",\""+name+"\",\""+min+"\")'>-</div>"+
        "<div class='chatbox_close' onmouseover=this.className='chatbox_close_onmouseover' onmouseout=this.className='chatbox_close' onclick='remove_chatbox(\""+num+"\",\""+min+"\")'>x</div></div>"+
        "<div id='chatbox_content_"+num+"' class='chatbox_content'>"+chatbox_content[num]+"</div>"+
        "<div class='chatbox_input'>"+
        "<input type='text' id='chatbox_input_area_"+num+"' class='chatbox_input_area_offline' disabled='true' value='此用户已离开' />"+
		"</div>";
		} else {
        div.innerHTML = "<div class='chatbox_head'><div class='chatbox_name'>"+decode_utf8(name)+"</div>"+
        "<div id='chatbox_writing_"+num+"' class='chatbox_writing'></div>"+
        "<div class='chatbox_min' onmouseover=this.className='chatbox_min_onmouseover' onmouseout=this.className='chatbox_min' onclick='min_chatbox(\""+num+"\",\""+id+"\",\""+chatid+"\",\""+name+"\",\""+min+"\")'>-</div>"+
        "<div class='chatbox_close' onmouseover=this.className='chatbox_close_onmouseover' onmouseout=this.className='chatbox_close' onclick='remove_chatbox(\""+num+"\",\""+min+"\")'>x</div></div>"+
        "<div id='chatbox_content_"+num+"' class='chatbox_content'>"+chatbox_content[num]+"</div>"+
        "<div id='chatbox_smileys_"+num+"' class='chatbox_smileys_none'>"+
		"</div>"+
		"<div class='chatbox_input'>"+
        "<input type='text' id='chatbox_input_area_"+num+"' class='chatbox_input_area' onkeyup='chat_input(this.value,"+num+","+id+",\""+chatid+"\",event)' />"+
        "<a title='表情' class='chatbox_show_smileys' href='javascript:void(0);' onclick='show_smileys("+num+")'><img src='smileys/16.gif' style='border:0;' /></a>"+
		"</div>";
		}
        chatbox_number_remove[i] = 100000;
        }
        }
        
        var j=0;
        for (j=0; j<h; j++){ 
        if (chatbox_number_remove[i] != 100000){     
        break;
        }
        }
        
        if (j == h){
        h = 0;
        }
        
        }
        else {     
        div.style.right = chatbox_number*261+221+"px";     
		if (chatbox_offline[num] == 1){
		div.innerHTML = "<div class='chatbox_head'><div class='chatbox_name'>"+decode_utf8(name)+"</div>"+
        "<div id='chatbox_writing_"+num+"' class='chatbox_writing'></div>"+
        "<div class='chatbox_min' onmouseover=this.className='chatbox_min_onmouseover' onmouseout=this.className='chatbox_min' onclick='min_chatbox(\""+num+"\",\""+id+"\",\""+chatid+"\",\""+name+"\",\""+chatbox_number+"\")'>-</div>"+
        "<div class='chatbox_close' onmouseover=this.className='chatbox_close_onmouseover' onmouseout=this.className='chatbox_close' onclick='remove_chatbox(\""+num+"\",\""+chatbox_number+"\")'>x</div></div>"+
        "<div id='chatbox_content_"+num+"' class='chatbox_content'>"+chatbox_content[num]+"</div>"+
        "<div class='chatbox_input'>"+
        "<input type='text' id='chatbox_input_area_"+num+"' class='chatbox_input_area_offline' disabled='true' value='此用户已离开' />"+
		"</div>"; 
		} else {
        div.innerHTML = "<div class='chatbox_head'><div class='chatbox_name'>"+decode_utf8(name)+"</div>"+
        "<div id='chatbox_writing_"+num+"' class='chatbox_writing'></div>"+
        "<div class='chatbox_min' onmouseover=this.className='chatbox_min_onmouseover' onmouseout=this.className='chatbox_min' onclick='min_chatbox(\""+num+"\",\""+id+"\",\""+chatid+"\",\""+name+"\",\""+chatbox_number+"\")'>-</div>"+
        "<div class='chatbox_close' onmouseover=this.className='chatbox_close_onmouseover' onmouseout=this.className='chatbox_close' onclick='remove_chatbox(\""+num+"\",\""+chatbox_number+"\")'>x</div></div>"+
        "<div id='chatbox_content_"+num+"' class='chatbox_content'>"+chatbox_content[num]+"</div>"+
        "<div id='chatbox_smileys_"+num+"' class='chatbox_smileys_none'>"+
		"</div>"+
		"<div class='chatbox_input'>"+
        "<input type='text' id='chatbox_input_area_"+num+"' class='chatbox_input_area' onkeyup='chat_input(this.value,"+num+","+id+",\""+chatid+"\",event)' />"+
        "<a title='表情' class='chatbox_show_smileys' href='javascript:void(0);' onclick='show_smileys("+num+")'><img src='smileys/16.gif' style='border:0;' /></a>"+
		"</div>"; 
		}
		chatbox_number++;
        }
		
        document.body.appendChild(div);
        document.getElementById("chatbox_content_"+num).scrollTop = document.getElementById("chatbox_content_"+num).scrollHeight;
        
        chatbox_open[num] = true;
        
        t_write[num] = setInterval(function(){chat_writing(num,id,chatid);},300);
        }
    }
    
function chat_input(msg,num,id,chatid,e) 
{
var chatbox_input_id = "chatbox_input_area_"+num;
var chatbox_content_id = "chatbox_content_"+num;
chat_writing_start(num,id,chatid);

var evtobj=window.event? event : e; //distinguish between IE's explicit event object (window.event) and Firefox's implicit.
var key=evtobj.charCode? evtobj.charCode : evtobj.keyCode;

if(key == '13'){

if (msg.replace(/\s/g,"") != ""){

msg = encodeURIComponent(msg);

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_input=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_input=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_input.onreadystatechange=function()
  {
  if (xmlhttp_chat_input.readyState==4 && xmlhttp_chat_input.status==200)
    {
    chatbox_content[num] = chatbox_content[num] + xmlhttp_chat_input.responseText;
    document.getElementById(chatbox_content_id).innerHTML = chatbox_content[num];
    document.getElementById(chatbox_content_id).scrollTop = document.getElementById(chatbox_content_id).scrollHeight;
	}
  }
xmlhttp_chat_input.open("GET","chat/chat_input.php?msg="+msg+"&otherid="+id+"&otherchatid="+chatid, true);
xmlhttp_chat_input.send(null);
}
document.getElementById(chatbox_input_id).value = "";
}

}

function chat_writing_start(num,id,chatid)
{
var writing = "1";

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_writing_start=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_writing_start=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_writing_start.onreadystatechange=function()
  {
  if (xmlhttp_chat_writing_start.readyState==4 && xmlhttp_chat_writing_start.status==200)
    { 
    setTimeout(function(){chat_writing_stop(num,id,chatid);},1000);  
    }
  }
xmlhttp_chat_writing_start.open("GET","chat/chat_writing_start_stop.php?otherid="+id+"&otherchatid="+chatid+"&writing="+writing, true);
xmlhttp_chat_writing_start.send(null);
}

function chat_writing_stop(num,id,chatid)
{
var writing = "0";

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_writing_stop=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_writing_stop=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_writing_stop.onreadystatechange=function()
  {
  if (xmlhttp_chat_writing_stop.readyState==4 && xmlhttp_chat_writing_stop.status==200)
    { 
    }
  }
xmlhttp_chat_writing_stop.open("GET","chat/chat_writing_start_stop.php?otherid="+id+"&otherchatid="+chatid+"&writing="+writing, true);
xmlhttp_chat_writing_stop.send(null);
}

function chat_writing(num,id,chatid)
{
var chatbox_writing_id = "chatbox_writing_"+num;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_writing=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_writing=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_writing.onreadystatechange=function()
  {
  if (xmlhttp_chat_writing.readyState==4 && xmlhttp_chat_writing.status==200)
    {
    if (xmlhttp_chat_writing.responseText == "1")
   	{
	document.getElementById(chatbox_writing_id).innerHTML = "<img src='images/pencil.png'>";
    	}
    else
    	{   	
    	document.getElementById(chatbox_writing_id).innerHTML = "";
    	}   
    }
  }
xmlhttp_chat_writing.open("GET","chat/chat_writing.php?otherid="+id+"&otherchatid="+chatid, true);
xmlhttp_chat_writing.send(null);

}

function chat_output_open(num,id,chatid)
{

var chatbox_content_id = "chatbox_content_"+num;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_output_open=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_output_open=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_output_open.onreadystatechange=function()
  {
  if (xmlhttp_chat_output_open.readyState==4 && xmlhttp_chat_output_open.status==200)
    {
    if (xmlhttp_chat_output_open.responseText != "nochatoutput")
		{
    	chatbox_content[num] = chatbox_content[num] + xmlhttp_chat_output_open.responseText;
    	document.getElementById(chatbox_content_id).innerHTML = chatbox_content[num];
    	document.getElementById(chatbox_content_id).scrollTop = document.getElementById(chatbox_content_id).scrollHeight;    
    	chat_output_confirm_open(num,id,chatid); 
    	}
    else
    	{   	
    	t1 = setInterval(function(){chat_output(num,id,chatid);},1000);
    	}   
    }
  }
xmlhttp_chat_output_open.open("GET","chat/chat_output_open.php?otherid="+id+"&otherchatid="+chatid, true);
xmlhttp_chat_output_open.send(null);

}

function chat_output(num,id,chatid)
{
var chatbox_content_id = "chatbox_content_"+num;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_output=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_output=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_output.onreadystatechange=function()
  {
  if (xmlhttp_chat_output.readyState==4 && xmlhttp_chat_output.status==200)
    {
    if (xmlhttp_chat_output.responseText != "nochatoutput" && xmlhttp_chat_output.responseText != lastmsg)
		{
   	    lastmsg = xmlhttp_chat_output.responseText;
    	chatbox_content[num] = chatbox_content[num] + xmlhttp_chat_output.responseText;
    	document.getElementById(chatbox_content_id).innerHTML = chatbox_content[num];
    	document.getElementById(chatbox_content_id).scrollTop = document.getElementById(chatbox_content_id).scrollHeight;    
    	chat_output_confirm(num,id,chatid); 
    	}
    else if (xmlhttp_chat_output.responseText == lastmsg)
    	{
    	chat_output_confirm(num,id,chatid); 
    	}   
    }
  }
xmlhttp_chat_output.open("GET","chat/chat_output.php?otherid="+id+"&otherchatid="+chatid, true);
xmlhttp_chat_output.send(null);

}

function chat_output_confirm_open(num,id,chatid)
{

var chatbox_content_id = "chatbox_content_"+num;

	if (window.XMLHttpRequest)
  	{// code for IE7+, Firefox, Chrome, Opera, Safari
  	var xmlhttp_chat_output_confirm_open=new XMLHttpRequest();
  	}
	else
  	{// code for IE6, IE5
  	var xmlhttp_chat_output_confirm_open=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp_chat_output_confirm_open.onreadystatechange=function()
  	  {
  	    if (xmlhttp_chat_output_confirm_open.readyState==4 && xmlhttp_chat_output_confirm_open.status==200)
    		{		
    		t2 = setInterval(function(){chat_output(num,id,chatid);},1000);
    		}
    	  }
	xmlhttp_chat_output_confirm_open.open("GET","chat/chat_output_confirm_open.php?otherid="+id+"&otherchatid="+chatid, true);
	xmlhttp_chat_output_confirm_open.send(null);
}

function chat_output_confirm(num,id,chatid)
{

var chatbox_content_id = "chatbox_content_"+num;

	if (window.XMLHttpRequest)
  	{// code for IE7+, Firefox, Chrome, Opera, Safari
  	var xmlhttp_chat_output_confirm=new XMLHttpRequest();
  	}
	else
  	{// code for IE6, IE5
  	var xmlhttp_chat_output_confirm=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp_chat_output_confirm.onreadystatechange=function()
  	  {
  	    if (xmlhttp_chat_output_confirm.readyState==4 && xmlhttp_chat_output_confirm.status==200)
    		{
    		
    		}
    	  }
	xmlhttp_chat_output_confirm.open("GET","chat/chat_output_confirm.php?otherid="+id+"&otherchatid="+chatid, true);
	xmlhttp_chat_output_confirm.send(null);
}

function remove_chatbox(num,removechatboxnum){

chatbox_open[num] = false;
clearInterval(t1);
clearInterval(t2);
clearInterval(t_write[num]);
chatbox_offline[num] = 0;

var chatboxid = "chatbox_"+num;
var chatremove = document.getElementById(chatboxid); 
document.body.removeChild(chatremove);
chatbox_number_remove[h] = removechatboxnum;
h++;
} 

function remove_chatminbox(num,removechatboxnum){

chatbox_min_open[num] = false;
chatbox_offline[num] = 0;

var chatboxminid = "chatbox_min_"+num;
var chatminremove = document.getElementById(chatboxminid); 
document.body.removeChild(chatminremove); 
chatbox_number_remove[h] = removechatboxnum;
h++;
} 

function chat_online_friends_counter()
{

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_online_friends_counter=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_online_friends_counter=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_online_friends_counter.onreadystatechange=function()
  {
  if (xmlhttp_chat_online_friends_counter.readyState==4 && xmlhttp_chat_online_friends_counter.status==200)  
	{
	var chat_online_friends_num = new Array();
	chat_online_friends_num = xmlhttp_chat_online_friends_counter.responseText.split("|");
    document.getElementById("chat_friends").innerHTML = "("+chat_online_friends_num[0]+")";
	
	if (chat_online_friends_num[1] != ""){
	chatname_offline_num(chat_online_friends_num[1]);
	}
    
	}
  }
xmlhttp_chat_online_friends_counter.open("GET","chat/chat_online_count.php", true);
xmlhttp_chat_online_friends_counter.send(null);

}

function chatname_offline_num(num)
{
	if (chatbox_open[num] == true) 
	{
	var chatbox_input_area_id = "chatbox_input_area_"+num;
	document.getElementById(chatbox_input_area_id).className = "chatbox_input_area_offline";
	document.getElementById(chatbox_input_area_id).disabled = true;
	document.getElementById(chatbox_input_area_id).value = "此用户已离开";	
	} 
	else if (chatbox_min_open[num] == true)
	{
	}
	chatbox_offline[num] = 1;
}

function chat_online_friends()
{

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_online_friends=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_online_friends=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_online_friends.onreadystatechange=function()
  {
  if (xmlhttp_chat_online_friends.readyState==4 && xmlhttp_chat_online_friends.status==200)
    {
	
	if (xmlhttp_chat_online_friends.responseText == "noschoolmate")
	{
	document.getElementById("chat_panel_users").innerHTML = 
	"<div class='chat_online_user_nouser'>没有在线用户 >_<</div>";
	} else {
    document.getElementById("chat_panel_users").innerHTML = xmlhttp_chat_online_friends.responseText;
    }
	
	}
  }
xmlhttp_chat_online_friends.open("GET","chat/chat_online_friends.php", true);
xmlhttp_chat_online_friends.send(null);

}

function chat_unreceive_ids()
{

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_unreceive_ids=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_unreceive_ids=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_unreceive_ids.onreadystatechange=function()
  {
  if (xmlhttp_chat_unreceive_ids.readyState==4 && xmlhttp_chat_unreceive_ids.status==200)
    { 
	if (xmlhttp_chat_unreceive_ids.responseText != "received")
	{
	var chat_unreceives = new Array();
	chat_unreceives = xmlhttp_chat_unreceive_ids.responseText.split("|");
	//document.getElementById("wrapper").innerHTML = chat_unreceives[0]+"@@"+chat_unreceives[1]+"@@"+chat_unreceives[2];
    chat_unreceive_names(chat_unreceives[0],chat_unreceives[1],chat_unreceives[2]);
	}
    }
  }
xmlhttp_chat_unreceive_ids.open("GET","chat/chat_unreceive_who.php", true);
xmlhttp_chat_unreceive_ids.send(null);

}

function chat_unreceive_names(num,id,chatid)
{

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_unreceive_names=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_unreceive_names=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_unreceive_names.onreadystatechange=function()
  {
  if (xmlhttp_chat_unreceive_names.readyState==4 && xmlhttp_chat_unreceive_names.status==200 && xmlhttp_chat_unreceive_names.responseText != "received")
    {
	if (chatbox_min_open[num] == true){
    chat_unreceive_messages(num,id,chatid);
	}
    chat_unreceive(num,id,chatid,xmlhttp_chat_unreceive_names.responseText);
    }
  }
xmlhttp_chat_unreceive_names.open("GET","chat/chat_unreceive_name.php?otherid="+id+"&otherchatid="+chatid, true);
xmlhttp_chat_unreceive_names.send(null);

}

function chat_unreceive_messages(num,id,chatid)
{
var chatbox_unreceive_count_id = "chatbox_unreceive_count_"+num;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_unreceive_messages=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_unreceive_messages=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_unreceive_messages.onreadystatechange=function()
  {
  if (xmlhttp_chat_unreceive_messages.readyState==4 && xmlhttp_chat_unreceive_messages.status==200)
    {
	
	var num1 = 0;
	if (document.getElementById(chatbox_unreceive_count_id).innerHTML != ""){
    var num_inn = document.getElementById(chatbox_unreceive_count_id).innerHTML;
	num1 = parseFloat(num_inn);
	}
	
	var num2 = 0;
    if (xmlhttp_chat_unreceive_messages.responseText != "received"){
	var num_res = xmlhttp_chat_unreceive_messages.responseText;
    num2 = parseFloat(num_res);
    }
	
    var unreceive_count = num1+num2;
    if (unreceive_count == 0){
    document.getElementById(chatbox_unreceive_count_id).className = "";
	document.getElementById(chatbox_unreceive_count_id).innerHTML = "";
    } else{
    document.getElementById(chatbox_unreceive_count_id).className="chatbox_unreceive_count";
    document.getElementById(chatbox_unreceive_count_id).innerHTML = unreceive_count+"";
    }
    
	}
  }
xmlhttp_chat_unreceive_messages.open("GET","chat/chat_unreceive_num.php?otherid="+id+"&otherchatid="+chatid, true);
xmlhttp_chat_unreceive_messages.send(null);

}

function chat_unreceive(num,id,chatid,name) { 
        
        if (chatbox_open[num] != true && chatbox_min_open[num] != true){
                 
        var div = document.createElement("div");    
        div.id = "chatbox_min_"+num;
        div.className ="chatboxmin"; 
	
        if (h>0){
        
        var min = 100000;
        for (var i=0; i<h; i++){
        if (chatbox_number_remove[i] <= min){
        min = chatbox_number_remove[i];
        }
        } 
        
        for (var i=0; i<h; i++){ 
        if (chatbox_number_remove[i] == min){
        
        var pos = chatbox_number_remove[i];
        div.onclick = function() {
		max_chatminbox(num,id,chatid,name,pos);
		}
	
        div.style.right = pos*261+221+"px"; 
        div.innerHTML = "<div class='chatbox_name'>"+decode_utf8(name)+"</div>"+
        "<div class='chatbox_close' onclick='remove_chatminbox("+num+","+pos+")'>x</div>"+
        "<div id='chatbox_unreceive_count_"+num+"'></div>";
        chatbox_number_remove[i] = 100000;
        }
        }
        
        var j=0;
        for (j=0; j<h; j++){ 
        if (chatbox_number_remove[i] != 100000){     
        break;
        }
        }
        
        if (j == h){
        h = 0;
        }
        
        }
        else {
          
        var pos = chatbox_number;        
        div.onclick = function() {
		max_chatminbox(num,id,chatid,name,pos);
		}
	   
        div.style.right = chatbox_number*261+221+"px";                     
        div.innerHTML = "<div class='chatbox_name'>"+decode_utf8(name)+"</div>"+
        "<div class='chatbox_close' onclick='remove_chatminbox("+num+","+chatbox_number+")'>x</div>"+
        "<div id='chatbox_unreceive_count_"+num+"'></div>";
   	    chatbox_number++;
        }
        
        document.body.appendChild(div);
                
        chatbox_min_open[num] = true;
        
        }
    }
    
function max_chatminbox(num,id,chatid,name,pos)
{
	chat_output_open(num,id,chatid);

	chatbox_min_open[num] = false;  
	var chatboxminid = "chatbox_min_"+num;
	var chatminremove = document.getElementById(chatboxminid); 
	document.body.removeChild(chatminremove); 

	if (chatbox_content[num] == undefined)
        {
        chatbox_content[num] = "";
        }
         
        var div = document.createElement("div");    
        div.id = "chatbox_"+num;
        div.className ="chatbox"; 
        
        div.style.right = pos*261+221+"px";   
		if (chatbox_offline[num] == 1){
		div.innerHTML = "<div class='chatbox_head'><div class='chatbox_name'>"+decode_utf8(name)+"</div>"+
        "<div id='chatbox_writing_"+num+"' class='chatbox_writing'></div>"+
        "<div class='chatbox_min' onmouseover=this.className='chatbox_min_onmouseover' onmouseout=this.className='chatbox_min' onclick='min_chatbox("+num+","+id+",\""+chatid+"\",\""+name+"\","+pos+")'>-</div>"+
        "<div class='chatbox_close' onmouseover=this.className='chatbox_close_onmouseover' onmouseout=this.className='chatbox_close' onclick='remove_chatbox("+num+","+pos+")'>x</div></div>"+
        "<div id='chatbox_content_"+num+"' class='chatbox_content'>"+chatbox_content[num]+"</div>"+
        "<div class='chatbox_input'>"+
        "<input type='text' id='chatbox_input_area_"+num+"' class='chatbox_input_area_offline' disabled='true' value='此用户已离开'/>"+
        "</div>"; 
		} else {
        div.innerHTML = "<div class='chatbox_head'><div class='chatbox_name'>"+decode_utf8(name)+"</div>"+
        "<div id='chatbox_writing_"+num+"' class='chatbox_writing'></div>"+
        "<div class='chatbox_min' onmouseover=this.className='chatbox_min_onmouseover' onmouseout=this.className='chatbox_min' onclick='min_chatbox("+num+","+id+",\""+chatid+"\",\""+name+"\","+pos+")'>-</div>"+
        "<div class='chatbox_close' onmouseover=this.className='chatbox_close_onmouseover' onmouseout=this.className='chatbox_close' onclick='remove_chatbox("+num+","+pos+")'>x</div></div>"+
        "<div id='chatbox_content_"+num+"' class='chatbox_content'>"+chatbox_content[num]+"</div>"+
        "<div id='chatbox_smileys_"+num+"' class='chatbox_smileys_none'>"+
		"</div>"+
		"<div class='chatbox_input'>"+
        "<input type='text' id='chatbox_input_area_"+num+"' class='chatbox_input_area' onkeyup='chat_input(this.value,"+num+","+id+",\""+chatid+"\",event)' />"+
        "<a title='表情' class='chatbox_show_smileys' href='javascript:void(0);' onclick='show_smileys("+num+")'><img src='smileys/16.gif' style='border:0;' /></a>"+
		"</div>"; 
        }
		
        document.body.appendChild(div);
        document.getElementById("chatbox_content_"+num).scrollTop = document.getElementById("chatbox_content_"+num).scrollHeight;
        
        chatbox_open[num] = true;
        
        t_write[num] = setInterval(function(){chat_writing(num,id,chatid);},300);
}

function min_chatbox(num,id,chatid,name,pos)
{
	clearInterval(t1);
	clearInterval(t2);
	clearInterval(t_write[num]);
	chatbox_open[num] = false;
	var chatboxid = "chatbox_"+num;
	var chatremove = document.getElementById(chatboxid); 
	document.body.removeChild(chatremove);	

	var div = document.createElement("div");    
        div.id = "chatbox_min_"+num;
        div.className ="chatboxmin"; 
		div.onmouseover = function() {
		this.className = "chatboxmin_onmouseover";
		}
		div.onmouseout = function() {
		this.className = "chatboxmin ";
		}
        div.onclick = function() {
		max_chatminbox(num,id,chatid,name,pos);
		}
        
        div.style.right = pos*261+221+"px";                     
        div.innerHTML = "<div class='chatbox_name'>"+decode_utf8(name)+"</div>"+
		"<div id='chatbox_writing_"+num+"' class='chatbox_writing'></div>"+
        "<div class='chatbox_close' onclick='remove_chatminbox("+num+","+pos+")'>x</div>"+
        "<div id='chatbox_unreceive_count_"+num+"'></div>";
        
        document.body.appendChild(div);       
        
        chatbox_min_open[num] = true; 
}

function show_smileys(num)
{
var chatbox_smileys_num = "chatbox_smileys_"+num;
if (document.getElementById(chatbox_smileys_num).className == "chatbox_smileys_none"){
document.getElementById(chatbox_smileys_num).className = "chatbox_smileys";
document.getElementById(chatbox_smileys_num).innerHTML = 
"<table>"+
"<tr>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='谄笑' onclick=add_smiley('(谄笑)',"+num+")><img src='smileys/1.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='吃饭' onclick=add_smiley('(吃饭)',"+num+")><img src='smileys/2.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='调皮' onclick=add_smiley('(调皮)',"+num+")><img src='smileys/3.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='尴尬' onclick=add_smiley('(尴尬)',"+num+")><img src='smileys/4.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='汗' onclick=add_smiley('(汗)',"+num+")><img src='smileys/5.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='惊恐' onclick=add_smiley('(惊恐)',"+num+")><img src='smileys/6.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='囧' onclick=add_smiley('(囧)',"+num+")><img src='smileys/7.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='可爱' onclick=add_smiley('(可爱)',"+num+")><img src='smileys/8.gif' style='border:0;'/></td>"+
"</tr>"+
"<tr>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='酷' onclick=add_smiley('(酷)',"+num+")><img src='smileys/9.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='流口水' onclick=add_smiley('(流口水)',"+num+")><img src='smileys/10.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='色迷迷' onclick=add_smiley('(色迷迷)',"+num+")><img src='smileys/11.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='生病' onclick=add_smiley('(生病)',"+num+")><img src='smileys/12.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='叹气' onclick=add_smiley('(叹气)',"+num+")><img src='smileys/13.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='淘气' onclick=add_smiley('(淘气)',"+num+")><img src='smileys/14.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='舔' onclick=add_smiley('(舔)',"+num+")><img src='smileys/15.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='偷笑' onclick=add_smiley('(偷笑)',"+num+")><img src='smileys/16.gif' style='border:0;'/></td>"+
"</tr>"+
"<tr>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='呕吐' onclick=add_smiley('(呕吐)',"+num+")><img src='smileys/17.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='吻' onclick=add_smiley('(吻)',"+num+")><img src='smileys/18.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='晕' onclick=add_smiley('(晕)',"+num+")><img src='smileys/19.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='住嘴' onclick=add_smiley('(住嘴)',"+num+")><img src='smileys/20.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='大笑' onclick=add_smiley('(大笑)',"+num+")><img src='smileys/21.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='害羞' onclick=add_smiley('(害羞)',"+num+")><img src='smileys/22.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='防流感' onclick=add_smiley('(防流感)',"+num+")><img src='smileys/23.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='哭' onclick=add_smiley('(哭)',"+num+")><img src='smileys/24.gif' style='border:0;'/></td>"+
"</tr>"+
"<tr>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='困' onclick=add_smiley('(困)',"+num+")><img src='smileys/25.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='难过' onclick=add_smiley('(难过)',"+num+")><img src='smileys/26.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='生气' onclick=add_smiley('(生气)',"+num+")><img src='smileys/27.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='书呆子' onclick=add_smiley('(书呆子)',"+num+")><img src='smileys/28.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='微笑' onclick=add_smiley('(微笑)',"+num+")><img src='smileys/29.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='不' onclick=add_smiley('(不)',"+num+")><img src='smileys/30.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='惊讶' onclick=add_smiley('(惊讶)',"+num+")><img src='smileys/31.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='抠鼻' onclick=add_smiley('(抠鼻)',"+num+")><img src='smileys/32.gif' style='border:0;'/></td>"+
"</tr>"+
"<tr>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='烧香' onclick=add_smiley('(烧香)',"+num+")><img src='smileys/33.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='给力' onclick=add_smiley('(给力)',"+num+")><img src='smileys/34.gif' style='border:0;'/></td>"+
"<td class='smileys' onmouseover=this.className='smileys_onmouseover' onmouseout=this.className='smileys' title='鸭梨' onclick=add_smiley('(鸭梨)',"+num+")><img src='smileys/35.gif' style='border:0;'/></td>"+
"</tr>"+
"</table>";
} else {
document.getElementById(chatbox_smileys_num).className = "chatbox_smileys_none";
document.getElementById(chatbox_smileys_num).innerHTML = "";
}
}

function add_smiley(smileys,num) 
{
var chatbox_input_area_num = "chatbox_input_area_"+num;
document.getElementById(chatbox_input_area_num).value = document.getElementById(chatbox_input_area_num).value + smileys;
document.getElementById(chatbox_input_area_num).focus();

var chatbox_smileys_num = "chatbox_smileys_"+num;
document.getElementById(chatbox_smileys_num).className = "chatbox_smileys_none";
document.getElementById(chatbox_smileys_num).innerHTML = "";
}

function chat_animation_start()
{
var chat_animation_user = document.getElementById("chat_animation_user");

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_animation_start=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_animation_start=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_animation_start.onreadystatechange=function()
  {
  if (xmlhttp_chat_animation_start.readyState==4 && xmlhttp_chat_animation_start.status==200)
    {
	var chat_animation_start = new Array();
	chat_animation_start = xmlhttp_chat_animation_start.responseText.split("|");
	chat_animation_user.style.left = chat_animation_start[0] + 'px';
	chat_animation_user.style.top = chat_animation_start[1] + 'px';
	document.getElementById("chat_animation_user_name").innerHTML = "<font color=red>我</font>" + "（"+chat_animation_start[2]+"）";
	}
  }
xmlhttp_chat_animation_start.open("GET","chat/chat_animation_start.php", true);
xmlhttp_chat_animation_start.send(null);

chat_animation_others();
/*	
setInterval(function(){chat_animation_others();},10000);
*/
}

function chat_animation_start_move() 
{
document.body.style.overflow = 'hidden';
document.body.onkeypress = function() {
		chat_animation_move(event);
		}
document.body.onkeydown = function() {
		chat_animation_move(event);
		}
}


var others_pn = 0;
function chat_animation_others()
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_animation_others=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_animation_others=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_animation_others.onreadystatechange=function()
  {
  if (xmlhttp_chat_animation_others.readyState==4 && xmlhttp_chat_animation_others.status==200)
    {
	var chat_animation_others = new Array();
	chat_animation_others = xmlhttp_chat_animation_others.responseText.split("|");
	if (chat_animation_others[0] != "noschoolmate"){
	document.getElementById("chat_animation_other_users").innerHTML = chat_animation_others[1];
	for (var i=0; i< chat_animation_others[0]; i++){
	var i_move = i + others_pn*2;
	chat_animation_others_move(i_move);
	clearTimeout(t_chat_animation[i]);
	t_chat_animation[i] = setInterval(function(){chat_animation_others_move(i_move);},500);
	}
	if (chat_animation_others[0] == 2){
	others_pn++;
	} else {
	others_pn = 0;
	}
	} else {
	document.getElementById("chat_animation_other_users").innerHTML = "";
	others_pn = 0;
	}
	}
  }
xmlhttp_chat_animation_others.open("GET","chat/chat_animation_others.php?others_pn="+others_pn, true);
xmlhttp_chat_animation_others.send(null);
}

function chat_animation_others_move(i)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_animation_others_move=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_animation_others_move=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_animation_others_move.onreadystatechange=function()
  {
  if (xmlhttp_chat_animation_others_move.readyState==4 && xmlhttp_chat_animation_others_move.status==200)
    {
	var chat_animation_others_move = new Array();
	chat_animation_others_move = xmlhttp_chat_animation_others_move.responseText.split("|");
	var num = parseFloat(chat_animation_others_move[0]);
	var xpos = parseFloat(chat_animation_others_move[1]);
	var ypos = parseFloat(chat_animation_others_move[2]);
	
	clearTimeout(t_chat_animation_others_move_right[num]);
	clearTimeout(t_chat_animation_others_move_left[num]);
	clearTimeout(t_chat_animation_others_move_up[num]);
	clearTimeout(t_chat_animation_others_move_down[num]);
	
	var chat_animation_user_num = "chat_animation_user_"+num;
	var chat_animation_otheruser = document.getElementById(chat_animation_user_num);
	var others_user_x = chat_animation_otheruser.offsetLeft;
	var others_user_y = chat_animation_otheruser.offsetTop;
	
	var others_x = xpos;
	var others_x2 = xpos + 17;
	var others_y = ypos;
	var others_y2 = ypos - 17;
	if (others_y2 < 0){
	others_y2 = 0;
	}
	if(!+[1,]) {
	var others_y = ypos - 13;
	var others_y2 = ypos - 30;
	if (others_y < 0){
	others_y = 0;
	}
	if (others_y2 < 0){
	others_y2 = 0;
	}
	}	
	
	if (others_user_x < others_x){
	chat_animation_others_move_right(num,others_x);
	} else if (others_user_x > others_x2){
	chat_animation_others_move_left(num,others_x2);
	}
	if (others_user_y < others_y2){
	chat_animation_others_move_down(num,others_y2);
	} else if (others_user_y > others_y){
	chat_animation_others_move_up(num,others_y);
	} 
	
	}
  }
xmlhttp_chat_animation_others_move.open("GET","chat/chat_animation_others_move.php?i="+i, true);
xmlhttp_chat_animation_others_move.send(null);
}

var chatimage = new Array();
chatimage[1] = "url(chat/chat1.png)";
chatimage[2] = "url(chat/chat2.png)";
chatimage[3] = "url(chat/chat3.png)";
chatimage[4] = "url(chat/chat4.png)";
chatimage[5] = "url(chat/chat5.png)";
chatimage[6] = "url(chat/chat6.png)";
chatimage[7] = "url(chat/chat7.png)";
chatimage[8] = "url(chat/chat8.png)";
chatimage[9] = "url(chat/chat9.png)";
chatimage[10] = "url(chat/chat10.png)";
chatimage[11] = "url(chat/chat11.png)";
chatimage[12] = "url(chat/chat12.png)";

var keyboard_move_up = 1;
var keyboard_move_right = 1;
var keyboard_move_down = 1;
var keyboard_move_left = 1;
function chat_animation_move(e) 
{
var chat_animation_user = document.getElementById("chat_animation_user");
var chat_animation_user_pic = document.getElementById("chat_animation_user_pic");

var evtobj=window.event? event : e; //distinguish between IE's explicit event object (window.event) 
var key=evtobj.charCode? evtobj.charCode : evtobj.keyCode;

if(key == '38'){

if (keyboard_move_up == 1){
chat_animation_user_pic.style.backgroundImage = chatimage[4];
keyboard_move_up = 2;
} else if (keyboard_move_up == 2){
chat_animation_user_pic.style.backgroundImage = chatimage[5];
keyboard_move_up = 3;
} else if (keyboard_move_up == 3){
chat_animation_user_pic.style.backgroundImage = chatimage[4];
keyboard_move_up = 4;
} else if (keyboard_move_up == 4){
chat_animation_user_pic.style.backgroundImage = chatimage[6];
keyboard_move_up = 5;
} else if (keyboard_move_up == 5){
chat_animation_user_pic.style.backgroundImage = chatimage[4];
keyboard_move_up = 2;
}
keyboard_move_right = 1;
keyboard_move_down = 1;
keyboard_move_left = 1;

if (chat_animation_user.offsetTop < 5){
chat_animation_user.style.top = "0px";
} else {
chat_animation_user.style.top = chat_animation_user.offsetTop-5+"px";
}
}

if(key == '39'){

if (keyboard_move_right == 1){
chat_animation_user_pic.style.backgroundImage = chatimage[10];
keyboard_move_right = 2;
} else if (keyboard_move_right == 2){
chat_animation_user_pic.style.backgroundImage = chatimage[11];
keyboard_move_right = 3;
} else if (keyboard_move_right == 3){
chat_animation_user_pic.style.backgroundImage = chatimage[10];
keyboard_move_right = 4;
} else if (keyboard_move_right == 4){
chat_animation_user_pic.style.backgroundImage = chatimage[12];
keyboard_move_right = 5;
} else if (keyboard_move_right == 5){
chat_animation_user_pic.style.backgroundImage = chatimage[10];
keyboard_move_right = 2;
}
keyboard_move_up = 1;
keyboard_move_down = 1;
keyboard_move_left = 1;

if (chat_animation_user.offsetLeft > 835){
chat_animation_user.style.Left = "840px";
} else {
chat_animation_user.style.left = chat_animation_user.offsetLeft+5+"px";
}
}

if(key == '40'){

if (keyboard_move_down == 1){
chat_animation_user_pic.style.backgroundImage = chatimage[1];
keyboard_move_down = 2;
} else if (keyboard_move_down == 2){
chat_animation_user_pic.style.backgroundImage = chatimage[2];
keyboard_move_down = 3;
} else if (keyboard_move_down == 3){
chat_animation_user_pic.style.backgroundImage = chatimage[1];
keyboard_move_down = 4;
} else if (keyboard_move_down == 4){
chat_animation_user_pic.style.backgroundImage = chatimage[3];
keyboard_move_down = 5;
} else if (keyboard_move_down == 5){
chat_animation_user_pic.style.backgroundImage = chatimage[1];
keyboard_move_down = 2;
}
keyboard_move_up = 1;
keyboard_move_right = 1;
keyboard_move_left = 1;

if (chat_animation_user.offsetTop > 176){
chat_animation_user.style.top = "181px";
} else {
chat_animation_user.style.top = chat_animation_user.offsetTop+5+"px";
}
}

if(key == '37'){

if (keyboard_move_left == 1){
chat_animation_user_pic.style.backgroundImage = chatimage[7];
keyboard_move_left = 2;
} else if (keyboard_move_left == 2){
chat_animation_user_pic.style.backgroundImage = chatimage[8];
keyboard_move_left = 3;
} else if (keyboard_move_left == 3){
chat_animation_user_pic.style.backgroundImage = chatimage[7];
keyboard_move_left = 4;
} else if (keyboard_move_left == 4){
chat_animation_user_pic.style.backgroundImage = chatimage[9];
keyboard_move_left = 5;
} else if (keyboard_move_left == 5){
chat_animation_user_pic.style.backgroundImage = chatimage[7];
keyboard_move_left = 2;
}
keyboard_move_up = 1;
keyboard_move_right = 1;
keyboard_move_down = 1;

if (chat_animation_user.offsetLeft < 5){
chat_animation_user.style.Left = "0px";
} else {
chat_animation_user.style.left = chat_animation_user.offsetLeft-5+"px";
}
}

var xpos = chat_animation_user.offsetLeft;
var ypos = chat_animation_user.offsetTop;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_animation_move=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_animation_move=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_animation_move.onreadystatechange=function()
  {
  if (xmlhttp_chat_animation_move.readyState==4 && xmlhttp_chat_animation_move.status==200)
    {
	}
  }
xmlhttp_chat_animation_move.open("GET","chat/chat_animation_move.php?xpos="+xpos+"&ypos="+ypos, true);
xmlhttp_chat_animation_move.send(null);
}

function chat_animation_click_move(event)
{
clearTimeout(t_chat_animation_click_move_right);
clearTimeout(t_chat_animation_click_move_left);
clearTimeout(t_chat_animation_click_move_up);
clearTimeout(t_chat_animation_click_move_down);

var left = document.getElementById("chat_animation").offsetLeft + 21;
var top =  document.getElementById("chat_animation").offsetTop + 21 + 16;
if(!+[1,]) {
var left = document.getElementById("chat_animation").offsetLeft + document.getElementById("wrapper").offsetLeft - document.body.scrollLeft + 23;
var top =  document.getElementById("chat_animation").offsetTop - document.body.scrollTop + 23 + 16;
}
document.getElementById("redflag").style.top = event.clientY - top + 'px';
document.getElementById("redflag").style.left = event.clientX - left - 2 + 'px';
/*
if(!+[1,]) {
document.getElementById("redflag").style.top = event.clientY - 395 + 'px';
}
*/
var chat_animation_user = document.getElementById("chat_animation_user");

var x = event.clientX - left - 16;
var x2 = event.clientX - left;
var y = event.clientY - top + 16;
var y2 = event.clientY - top;
/*
if(!+[1,]) {
var y = event.clientY - 395;
var y2 = event.clientY - 412;
}
*/
var user_x = chat_animation_user.offsetLeft;
var user_y = chat_animation_user.offsetTop;

if (user_x < x){
chat_animation_click_move_right(x);
}
if (user_x > x2){
chat_animation_click_move_left(x2);
}
if (user_y < y2){
chat_animation_click_move_down(y2);
} 
if (user_y > y){
chat_animation_click_move_up(y);
} 

}

var left_click_move_right = 1;
function chat_animation_click_move_right(x)
{
var chat_animation_user = document.getElementById("chat_animation_user");
var chat_animation_user_pic = document.getElementById("chat_animation_user_pic");

var user_x = chat_animation_user.offsetLeft;
if (user_x < x){

if (left_click_move_right == 1){
chat_animation_user_pic.style.backgroundImage = chatimage[10];
left_click_move_right = 2;
} else if (left_click_move_right == 2){
chat_animation_user_pic.style.backgroundImage = chatimage[11];
left_click_move_right = 3;
} else if (left_click_move_right == 3){
chat_animation_user_pic.style.backgroundImage = chatimage[10];
left_click_move_right = 4;
} else if (left_click_move_right == 4){
chat_animation_user_pic.style.backgroundImage = chatimage[12];
left_click_move_right = 5;
} else if (left_click_move_right == 5){
chat_animation_user_pic.style.backgroundImage = chatimage[10];
left_click_move_right = 2;
}

chat_animation_user.style.left = chat_animation_user.offsetLeft+5+"px";

var xpos = chat_animation_user.offsetLeft;
var ypos = chat_animation_user.offsetTop;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_animation_click_move_right=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_animation_click_move_right=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_animation_click_move_right.onreadystatechange=function()
  {
  if (xmlhttp_chat_animation_click_move_right.readyState==4 && xmlhttp_chat_animation_click_move_right.status==200)
    {
	}
  }
xmlhttp_chat_animation_click_move_right.open("GET","chat/chat_animation_move.php?xpos="+xpos+"&ypos="+ypos, true);
xmlhttp_chat_animation_click_move_right.send(null);

t_chat_animation_click_move_right = setTimeout(function(){chat_animation_click_move_right(x);},100);
}
}

var left_click_move_left = 1;
function chat_animation_click_move_left(x)
{
var chat_animation_user = document.getElementById("chat_animation_user");
var chat_animation_user_pic = document.getElementById("chat_animation_user_pic");

var user_x = chat_animation_user.offsetLeft;
if (user_x > x){

if (left_click_move_left == 1){
chat_animation_user_pic.style.backgroundImage = chatimage[7];
left_click_move_left = 2;
} else if (left_click_move_left == 2){
chat_animation_user_pic.style.backgroundImage = chatimage[8];
left_click_move_left = 3;
} else if (left_click_move_left == 3){
chat_animation_user_pic.style.backgroundImage = chatimage[7];
left_click_move_left = 4;
} else if (left_click_move_left == 4){
chat_animation_user_pic.style.backgroundImage = chatimage[9];
left_click_move_left = 5;
} else if (left_click_move_left == 5){
chat_animation_user_pic.style.backgroundImage = chatimage[7];
left_click_move_left = 2;
}

chat_animation_user.style.left = chat_animation_user.offsetLeft-5+"px";

var xpos = chat_animation_user.offsetLeft;
var ypos = chat_animation_user.offsetTop;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_animation_click_move_left=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_animation_click_move_left=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_animation_click_move_left.onreadystatechange=function()
  {
  if (xmlhttp_chat_animation_click_move_left.readyState==4 && xmlhttp_chat_animation_click_move_left.status==200)
    {
	}
  }
xmlhttp_chat_animation_click_move_left.open("GET","chat/chat_animation_move.php?xpos="+xpos+"&ypos="+ypos, true);
xmlhttp_chat_animation_click_move_left.send(null);

t_chat_animation_click_move_left = setTimeout(function(){chat_animation_click_move_left(x);},100);
}
}

var left_click_move_down = 1;
function chat_animation_click_move_down(y)
{
var chat_animation_user = document.getElementById("chat_animation_user");
var chat_animation_user_pic = document.getElementById("chat_animation_user_pic");

var user_y = chat_animation_user.offsetTop;
if (user_y < y){

if (left_click_move_down == 1){
chat_animation_user_pic.style.backgroundImage = chatimage[1];
left_click_move_down = 2;
} else if (left_click_move_down == 2){
chat_animation_user_pic.style.backgroundImage = chatimage[2];
left_click_move_down = 3;
} else if (left_click_move_down == 3){
chat_animation_user_pic.style.backgroundImage = chatimage[1];
left_click_move_down = 4;
} else if (left_click_move_down == 4){
chat_animation_user_pic.style.backgroundImage = chatimage[3];
left_click_move_down = 5;
} else if (left_click_move_down == 5){
chat_animation_user_pic.style.backgroundImage = chatimage[1];
left_click_move_down = 2;
}

chat_animation_user.style.top = chat_animation_user.offsetTop+5+"px";

var xpos = chat_animation_user.offsetLeft;
var ypos = chat_animation_user.offsetTop;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_animation_click_move_down=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_animation_click_move_down=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_animation_click_move_down.onreadystatechange=function()
  {
  if (xmlhttp_chat_animation_click_move_down.readyState==4 && xmlhttp_chat_animation_click_move_down.status==200)
    {
	}
  }
xmlhttp_chat_animation_click_move_down.open("GET","chat/chat_animation_move.php?xpos="+xpos+"&ypos="+ypos, true);
xmlhttp_chat_animation_click_move_down.send(null);

t_chat_animation_click_move_down = setTimeout(function(){chat_animation_click_move_down(y);},100);
}
}

var left_click_move_up = 1;
function chat_animation_click_move_up(y)
{
var chat_animation_user = document.getElementById("chat_animation_user");
var chat_animation_user_pic = document.getElementById("chat_animation_user_pic");

var user_y = chat_animation_user.offsetTop;
if (user_y > y){

if (left_click_move_up == 1){
chat_animation_user_pic.style.backgroundImage = chatimage[4];
left_click_move_up = 2;
} else if (left_click_move_up == 2){
chat_animation_user_pic.style.backgroundImage = chatimage[5];
left_click_move_up = 3;
} else if (left_click_move_up == 3){
chat_animation_user_pic.style.backgroundImage = chatimage[4];
left_click_move_up = 4;
} else if (left_click_move_up == 4){
chat_animation_user_pic.style.backgroundImage = chatimage[6];
left_click_move_up = 5;
} else if (left_click_move_up == 5){
chat_animation_user_pic.style.backgroundImage = chatimage[4];
left_click_move_up = 2;
}

chat_animation_user.style.top = chat_animation_user.offsetTop-5+"px";

var xpos = chat_animation_user.offsetLeft;
var ypos = chat_animation_user.offsetTop;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp_chat_animation_click_move_up=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  var xmlhttp_chat_animation_click_move_up=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp_chat_animation_click_move_up.onreadystatechange=function()
  {
  if (xmlhttp_chat_animation_click_move_up.readyState==4 && xmlhttp_chat_animation_click_move_up.status==200)
    {
	}
  }
xmlhttp_chat_animation_click_move_up.open("GET","chat/chat_animation_move.php?xpos="+xpos+"&ypos="+ypos, true);
xmlhttp_chat_animation_click_move_up.send(null);

t_chat_animation_click_move_up = setTimeout(function(){chat_animation_click_move_up(y);},100);
}
}

var left_others_move_right = 1;
function chat_animation_others_move_right(num,x)
{
var chat_animation_user_others_move_right = document.getElementById("chat_animation_user_"+num);
var chat_animation_user_others_move_right_pic = document.getElementById("chat_animation_user_pic_"+num);

var user_x = chat_animation_user_others_move_right.offsetLeft;
if (user_x < x){

if (left_others_move_right == 1){
chat_animation_user_others_move_right_pic.style.backgroundImage = chatimage[10];
left_others_move_right = 2;
} else if (left_others_move_right == 2){
chat_animation_user_others_move_right_pic.style.backgroundImage = chatimage[11];
left_others_move_right = 3;
} else if (left_others_move_right == 3){
chat_animation_user_others_move_right_pic.style.backgroundImage = chatimage[10];
left_others_move_right = 4;
} else if (left_others_move_right == 4){
chat_animation_user_others_move_right_pic.style.backgroundImage = chatimage[12];
left_others_move_right = 5;
} else if (left_others_move_right == 5){
chat_animation_user_others_move_right_pic.style.backgroundImage = chatimage[10];
left_others_move_right = 2;
}

chat_animation_user_others_move_right.style.left = chat_animation_user_others_move_right.offsetLeft+5+"px";

var num_others_move_right = num;
var x_others_move_right = x;
t_chat_animation_others_move_right[num] = setTimeout(function(){chat_animation_others_move_right(num_others_move_right,x_others_move_right);},100);
}
}

var left_others_move_left = 1;
function chat_animation_others_move_left(num,x)
{
var chat_animation_user_others_move_left = document.getElementById("chat_animation_user_"+num);
var chat_animation_user_others_move_left_pic = document.getElementById("chat_animation_user_pic_"+num);

var user_x = chat_animation_user_others_move_left.offsetLeft;
if (user_x > x){

if (left_others_move_left == 1){
chat_animation_user_others_move_left_pic.style.backgroundImage = chatimage[7];
left_others_move_left = 2;
} else if (left_others_move_left == 2){
chat_animation_user_others_move_left_pic.style.backgroundImage = chatimage[8];
left_others_move_left = 3;
} else if (left_others_move_left == 3){
chat_animation_user_others_move_left_pic.style.backgroundImage = chatimage[7];
left_others_move_left = 4;
} else if (left_others_move_left == 4){
chat_animation_user_others_move_left_pic.style.backgroundImage = chatimage[9];
left_others_move_left = 5;
} else if (left_others_move_left == 5){
chat_animation_user_others_move_left_pic.style.backgroundImage = chatimage[7];
left_others_move_left = 2;
}

chat_animation_user_others_move_left.style.left = chat_animation_user_others_move_left.offsetLeft-5+"px";

var num_others_move_left = num;
var x_others_move_left = x;
t_chat_animation_others_move_left[num] = setTimeout(function(){chat_animation_others_move_left(num_others_move_left,x_others_move_left);},100);
}
}

var left_others_move_down = 1;
function chat_animation_others_move_down(num,y)
{
var chat_animation_user_others_move_down = document.getElementById("chat_animation_user_"+num);
var chat_animation_user_others_move_down_pic = document.getElementById("chat_animation_user_pic_"+num);

var user_y = chat_animation_user_others_move_down.offsetTop;
if (user_y < y){

if (left_others_move_down == 1){
chat_animation_user_others_move_down_pic.style.backgroundImage = chatimage[1];
left_others_move_down = 2;
} else if (left_others_move_down == 2){
chat_animation_user_others_move_down_pic.style.backgroundImage = chatimage[2];
left_others_move_down = 3;
} else if (left_others_move_down == 3){
chat_animation_user_others_move_down_pic.style.backgroundImage = chatimage[1];
left_others_move_down = 4;
} else if (left_others_move_down == 4){
chat_animation_user_others_move_down_pic.style.backgroundImage = chatimage[3];
left_others_move_down = 5;
} else if (left_others_move_down == 5){
chat_animation_user_others_move_down_pic.style.backgroundImage = chatimage[1];
left_others_move_down = 2;
}

chat_animation_user_others_move_down.style.top = chat_animation_user_others_move_down.offsetTop+5+"px";

var num_others_move_down = num;
var y_others_move_down = y;
t_chat_animation_others_move_down[num] = setTimeout(function(){chat_animation_others_move_down(num_others_move_down,y_others_move_down);},100);
}
}

var left_others_move_up = 1;
function chat_animation_others_move_up(num,y)
{
var chat_animation_user_others_move_up = document.getElementById("chat_animation_user_"+num);
var chat_animation_user_others_move_up_pic = document.getElementById("chat_animation_user_pic_"+num);

var user_y = chat_animation_user_others_move_up.offsetTop;
if (user_y > y){

if (left_others_move_up == 1){
chat_animation_user_others_move_up_pic.style.backgroundImage = chatimage[4];
left_others_move_up = 2;
} else if (left_others_move_up == 2){
chat_animation_user_others_move_up_pic.style.backgroundImage = chatimage[5];
left_others_move_up = 3;
} else if (left_others_move_up == 3){
chat_animation_user_others_move_up_pic.style.backgroundImage = chatimage[4];
left_others_move_up = 4;
} else if (left_others_move_up == 4){
chat_animation_user_others_move_up_pic.style.backgroundImage = chatimage[6];
left_others_move_up = 5;
} else if (left_others_move_up == 5){
chat_animation_user_others_move_up_pic.style.backgroundImage = chatimage[4];
left_others_move_up = 2;
}

chat_animation_user_others_move_up.style.top = chat_animation_user_others_move_up.offsetTop-5+"px";

var num_others_move_up = num;
var y_others_move_up = y;
t_chat_animation_others_move_up[num] = setTimeout(function(){chat_animation_others_move_up(num_others_move_up,y_others_move_up);},100);
}
}

function change_chat_animation_other_user_name_class(id)
{
document.getElementById(id).className='chat_animation_other_user_name_onmouseover2';
}

function changeback_chat_animation_other_user_name_class(id)
{
document.getElementById(id).className='chat_animation_other_user_name';
}

function chat_animation_see_other_features(num)
{
var chat_animation_user_msg_id = document.getElementById("chat_animation_user_msg_"+num);
if (chat_animation_user_msg_id.className == "chat_animation_other_user_msg_displaynone"){
chat_animation_user_msg_id.className = "chat_animation_other_user_msg";
} else {
chat_animation_user_msg_id.className = "chat_animation_other_user_msg_displaynone";
}
}

function chat_animation_see_msgs(id,name)
{
document.getElementById("duitasuo_display").innerHTML = 
"<div id=\"post_status\" onselectstart=\"return false\">"+
"<div id=\"post_status_control\" class=\"post_status_control\">"+
"<div class=\"chat_animation_posts\">"+decode_utf8(name)+" 的 留言记录</div>"+
"</div></div>"+
"<div id=\"posts\" class=\"posts\"></div>";

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
    document.getElementById("posts").innerHTML = xmlhttp_see_pmsg.responseText;
	/*
	t_chat_animation_see_msgs_move_div = setInterval(function(){chat_animation_see_msgs_move_div();},10);
	*/
	}
  }
xmlhttp_see_pmsg.open("GET","chat/chat_animation_see_msgs.php?otherid="+id,true);
xmlhttp_see_pmsg.send();
}

function chat_animation_see_msgs_move_div()
{
/*
document.getElementById("chat_animation").style.left = document.getElementById("chat_animation").offsetLeft + "px";
document.getElementById("chat_animation").style.marginLeft = "0px";
document.getElementById("chat_animation").style.position = "relative";
document.getElementById("duitasuo_display").style.left = document.getElementById("duitasuo_display").offsetLeft - 10 + "px";

if (document.getElementById("duitasuo_display").offsetLeft < -235){
clearInterval(t_chat_animation_see_msgs_move_div);
}
*/
}


var _startX = 0;			// mouse starting positions
var _startY = 0;
var _offsetX = 0;			// current element offset
var _offsetY = 0;
var _dragElement;			// needs to be passed from OnMouseDown to OnMouseMove
var _oldZIndex = 0;			// we temporarily increase the z-index during drag

function InitDragDrop()
{
	document.onmousedown = OnMouseDown;
	document.onmouseup = OnMouseUp;
}

function OnMouseDown(e)
{
	// IE is retarded and doesn't pass the event object
	if (e == null) 
		e = window.event; 
	
	// IE uses srcElement, others use target
	var target = e.target != null ? e.target : e.srcElement;

	// for IE, left click == 1
	// for Firefox, left click == 0
	if ((e.button == 1 && window.event != null || 
		e.button == 0) && 
		(target.className == 'chat_animation_shade' || target.className == 'chat_animation_box'))
	{	
		document.getElementById("chat_animation").style.top = document.getElementById("chat_animation").offsetTop + "px";
		document.getElementById("chat_animation").style.left = document.getElementById("chat_animation").offsetLeft + "px";
		document.getElementById("chat_animation").style.marginLeft = "0px";
		document.getElementById("chat_animation").className = "chat_animation_dragged";

		// grab the mouse position
		_startX = e.clientX;
		_startY = e.clientY;
		
		// grab the clicked element's position
		_offsetX = ExtractNumber(document.getElementById("chat_animation").style.left);
		_offsetY = ExtractNumber(document.getElementById("chat_animation").style.top);
		
		// bring the clicked element to the front while it is being dragged
		_oldZIndex = document.getElementById("chat_animation").style.zIndex;
		document.getElementById("chat_animation").style.zIndex = 999999;
		// we need to access the element in OnMouseMove
		_dragElement = document.getElementById("chat_animation");

		// tell our code to start moving the element with the mouse
		document.onmousemove = OnMouseMove;
		
		// cancel out any text selections
		document.body.focus();
		
		// prevent text selection in IE
		document.onselectstart = function () { return false; };
		// prevent IE from trying to drag an image
		target.ondragstart = function() { return false; };
		
		// prevent text selection (except IE)
		return false;
	}
}

function ExtractNumber(value)
{
	var n = parseInt(value);
	
	return n == null || isNaN(n) ? 0 : n;
}

function OnMouseMove(e)
{
	if (e == null) 
		var e = window.event; 

	// this is the actual "drag code"
	_dragElement.style.left = (_offsetX + e.clientX - _startX) + 'px';
	_dragElement.style.top = (_offsetY + e.clientY - _startY) + 'px';
}

function OnMouseUp(e)
{
	if (_dragElement != null)
	{
		_dragElement.style.zIndex = _oldZIndex;

		// we're done with these events until the next OnMouseDown
		document.onmousemove = null;
		document.onselectstart = null;
		_dragElement.ondragstart = null;

		// this is how we know we're not dragging
		_dragElement = null;
		
	}
}
	