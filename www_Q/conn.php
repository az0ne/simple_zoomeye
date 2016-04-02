<?php
$con = mysql_connect("localhost","root","ROOT");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_query("set names 'utf8' "); 
     mysql_query("set character_set_client=utf8"); 
     mysql_query("set character_set_results=utf8");   
mysql_select_db("host", $con);
?>