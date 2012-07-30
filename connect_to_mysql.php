<?php
     //connect to database
       $error = "Problem connecting";
       mysql_connect("localhost","root","") or die(mysql_error());
       mysql_select_db("duitasuo") or die(mysql_error());
       
       session_start();

?>