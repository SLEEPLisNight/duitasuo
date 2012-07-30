function init()
{
/*
setInterval(function(){refresh_duitasuo('0');},600000);
*/
var t1 = setInterval(function(){online_user_counter();},6000);
var t2 = setInterval(function(){unread_comment();},2000);
var t3 = setInterval(function(){unread_pmsg();},2000);
var t4 = setInterval(function(){chat_online_friends_counter();},2000);
var t5 = setInterval(function(){chat_unreceive_ids();},1000);
InitDragDrop();
/*
setInterval(function(){refresh_top_posts();},300000);
*/
}