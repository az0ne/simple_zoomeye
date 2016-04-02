<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<?php


	if(isset($_GET['ip'])){
		$ip = $_GET['ip'];
	}
	$rep = array("http://",":80/");
	$ip_q = str_replace($rep, "", $ip);
	echo $ip_q;
	$place = @file_get_contents("http://www.gpsspg.com/ip/?q=$ip_q");
	$preg = '/<span class="fcg">(.*?)<\/span>/i';
	preg_match_all($preg,$place, $result_tmp );
	echo $result_tmp[0][0];
	
	$preg2 = '/<a[^<]*<\/a>/i';
	preg_match_all($preg2,$place, $result_tmp2 );
	$locals = $result_tmp2[0][6];
	$local = str_replace("/maps.htm?s", "http://www.gpsspg.com/maps.htm?s", $locals);
	echo $local;	
?>