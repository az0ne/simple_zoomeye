<?php
$con = mysql_connect("localhost","root","33eeddcc");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_query("set names 'utf8' "); 
     mysql_query("set character_set_client=utf8"); 
     mysql_query("set character_set_results=utf8");   
mysql_select_db("host", $con);
$searchs = 'tomcat';
$result = mysql_query("SELECT * FROM china_host where CONCAT(`title`)  like '%$searchs%'");
if (mysql_num_rows($result) < 1) echo 'No Results';

$num=0;
while($row = mysql_fetch_array($result))
 {
 
  $num++;
        echo $row[1];
	echo "<br>";

  }
echo $num;
?>	