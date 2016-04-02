<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Network Servers Search Engine</title>
<link rel="stylesheet" href="css/search.css">
<link rel="stylesheet" type="text/css" href="files/codes/css/reset.css" />
<link rel="stylesheet" href="files/codes/css/style.css" type="text/css" />
</head>
<body>
<section id="contents">
	<ul id="slider">
    	
    
    </ul>
    
	<nav id="sideNav">
        <a href="#contactBoard" id="emailBtn">Email</a>
    </nav><!-- end of #sideNac -->
    
	<section id="mainBoard">
        <header>
            <h1>RKO-随机网站-看好就黑</h1>
	    <h4><?php
include("conn.php");
error_reporting(0);
$RKO = array();
$i = 0;
for($i = 0;$i <=100;$i++){
  $RKO[$i] = rand();
}
//$myquery = "SELECT * FROM china_host WHERE id ='1'";
for($i = 0;$i <=100;$i++){
  $querylist = $RKO[$i];
  $myquery = "SELECT * FROM china_host WHERE id ='$querylist'";
  $query = mysql_query($myquery);
while($row = mysql_fetch_array($query))
 {
 
  $num++;
  	echo "<br>";
        echo "<p>URL:<a href=$row[1]>$row[1]</a><a href=ip.php?ip=$row[1]><br>INFO</a><br></p><p>TITLE:$row[2]<br></p><p>CITY:$row[3]<br></p>";
	echo "<hr>";
  }
}

?>
</h4>
	
        </header>
        <footer>
            <p class="copy">&copy; 2014-2017, CSIT_NS@HLJU </p>
            <p class="phone">Code By AZONE</p>
        </footer>
    </section><!-- end of #mainBoard -->

	

</section><!-- end of #contents -->

<!-- JavaScript Libraries and Codes -->
    <!-- the jQuery ligrary -->
	<script src="files/codes/js/jquery-1.7.1.min.js"></script>
	<!-- jQuery Cycle plugin -->
    <script style="display: none;" src="files/codes/js/jquery.cycle.all.min.js"></script>
	<!-- jQuery CountDown Plugin -->
    <script style="display: none;" src="files/codes/js/jquery.countdown.min.js"></script>

	<!-- This file starts/initializes all js functionalities throughout
    	this site and houses some more scripts or libraries. -->
    <script style="display: none;" src="files/codes/js/init.js"></script>

	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="files/codes/css/ie.css" media="all" />
		<script src="files/codes/js/ie.js"></script>
	<![endif]-->
	<!--[if IE]>
    	<style>
        	header h1{padding: 34px 0 20px; margin: 0;}
            #contactBoard{padding-top: 10px;}
			.countdown_amount{padding-top: 16px;}
        </style>
	<![endif]-->
<div style="display:none"><script src='http://v7.cnzz.com/stat.php?id=155540&web_id=155540' language='JavaScript' charset='gb2312'></script></div>

</body>
</html>