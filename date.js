function show_select_checkin_panel(){

var date_selector = "date_selector";
var date_selector_onclick = "date_selector_onclick";

if (document.getElementById("checkin_selector").className == date_selector){
document.getElementById("select_checkin_panel").style.visibility = "visible";
document.getElementById("checkin_selector").className = "date_selector_onclick";
}
else {
document.getElementById("select_checkin_panel").style.visibility = "hidden";
document.getElementById("checkin_selector").className = "date_selector";
}

}

function show_select_checkout_panel(){

var date_selector = "date_selector";
var date_selector_onclick = "date_selector_onclick";

if (document.getElementById("checkout_selector").className == date_selector){
document.getElementById("select_checkout_panel").style.visibility = "visible";
document.getElementById("checkout_selector").className = "date_selector_onclick";
}
else {
document.getElementById("select_checkout_panel").style.visibility = "hidden";
document.getElementById("checkout_selector").className = "date_selector";
}

}

function last_month_checkin(m,y)
{
if (m==1){
var month = 12;
var year = y -1;
}
else {
var month = m - 1;
var year = y;
}

var date={
   "month_select": month,
   "year_select": year
   }
var jsonstr =  JSON.stringify(date);  
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("select_checkin_panel").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","date_checkin.php?json="+jsonstr, true);
xmlhttp.send(null);
}

function next_month_checkin(m,y)
{
if (m==12){
var month = 1;
var year = y +1;
}
else {
var month = m + 1;
var year = y;
}

var date={
   "month_select": month,
   "year_select": year
   }
var jsonstr =  JSON.stringify(date);  
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("select_checkin_panel").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","date_checkin.php?json="+jsonstr, true);
xmlhttp.send(null);
}

function last_month_checkout(m,y)
{
if (m==1){
var month = 12;
var year = y -1;
}
else {
var month = m - 1;
var year = y;
}

var date={
   "month_select": month,
   "year_select": year
   }
var jsonstr =  JSON.stringify(date);  
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("select_checkout_panel").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","date_checkout.php?json="+jsonstr, true);
xmlhttp.send(null);
}

function next_month_checkout(m,y)
{
if (m==12){
var month = 1;
var year = y +1;
}
else {
var month = m + 1;
var year = y;
}

var date={
   "month_select": month,
   "year_select": year
   }
var jsonstr =  JSON.stringify(date);  
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("select_checkout_panel").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","date_checkout.php?json="+jsonstr, true);
xmlhttp.send(null);
}

function change_checkin_selector_value(day,month,year){
document.getElementById("select_checkin_panel").style.visibility = "hidden";
document.getElementById("checkin_selector").value = day+"/"+month+"/"+year;
}

function change_checkout_selector_value(day,month,year){
document.getElementById("select_checkout_panel").style.visibility = "hidden";
document.getElementById("checkout_selector").value = day+"/"+month+"/"+year;
}