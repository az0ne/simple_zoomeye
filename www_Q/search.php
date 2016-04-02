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
            <h1>Results:</h1>
	    <h4><?php
  error_reporting(0);
session_start();
if(!isset($_SESSION['userid'])){
	header("Location:login.html");
	exit();
}
$username = $_SESSION['username'];
echo "<h3>你好 $username</h3>";
echo '<a href="login.php?action=logout">注销</a><br />';

  include("conn.php");
 $pagesize=10;
 $url="http://localhost/www/www_Q/search.php";
 $searchs = $_GET['search'];  
 $searchs= trim($searchs);
 $tatal_q = mysql_query("SELECT * FROM china_host where CONCAT(`url`,`title`,`local`)  like '%$searchs%'");
 $tatal = mysql_num_rows($tatal_q);
 if($_GET[page]){
 $pageval = $_GET['page'];
 $pageval= trim($pageval);
 $page=($pageval-1)*$pagesize;
 $page.=',';
}
if($tatal > $pagesize){
 if($pageval<=1)$pageval=1;
 echo "共 $tatal 条".
 " <a href=$url?page=".($pageval-1)."&search=".($searchs).">上一页</a> <a href=$url?page=".($pageval+1)."&search=".($searchs).">下一页</a>";
}
if (!$searchs)
{
echo '搜索框不能为空.';
exit;
}

$tatal_page = ceil($tatal/10);
$sql_q = "SELECT * FROM china_host where CONCAT(`url`,`title`,`local`)  like '%$searchs%' LIMIT $page $pagesize";
$result = mysql_query($sql_q);
if (mysql_num_rows($result) < 1) echo 'No Results';



$num=0;
while($row = mysql_fetch_array($result))
 {
 
  $num++;
  	echo "<br>";
        echo "<p>URL:<a href=$row[1]>$row[1]</a><a href=ip.php?ip=$row[1]><br>INFO</a><br></p><p>TITLE:$row[2]<br></p><p>CITY:$row[3]<br></p>";
	echo "<hr>";
  }

if($tatal > $pagesize){
 if($pageval<=1)$pageval=1;
 echo "<h3>共 $tatal 条 $tatal_page 页</h3>".
 "<h2> <a href=$url?page=".($pageval-1)."&search=".($searchs).">上一页</a> <a href=$url?page=".($pageval+1)."&search=".($searchs).">下一页</a></h2>";
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