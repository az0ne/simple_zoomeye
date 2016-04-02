<?php

function ping($arr=array())
{

	//Ping XML内容
	$ping_body  = '<?xml version="1.0" encoding="UTF-8"?><methodCall><methodName>weblogUpdates.extendedPing</methodName><params>'."\r\n";
	$ping_body .= '<param><value>'.$GLOBALS['config']['blog_name'].'</value></param>'."\r\n";
	$ping_body .= '<param><value>'.$GLOBALS['config']['domain'].'</value></param>'."\r\n";
	$ping_body .= '<param><value>'.$arr['blog_url'].'</value></param>."\r\n"';
	$ping_body .= '<param><value>'.$GLOBALS['config']['domain'].'/feed.php'.'</value></param>'."\r\n";
	$ping_body .= '</params></methodCall>';
	$ping_header  = 'Content-Type: text/xml; charset=UTF-8'."\r\n";
	$ping_header .= 'Content-Length: '.strlen($ping_body)."\r\n";
	$ping_header .= 'User-Agent: Simple-Log'."\r\n";
	$ping_xml = $ping_header.$ping_body;

	//获取ping列表
	$ping_list=file(PBBLOG_ROOT.'home/plugins/ping/ping.txt');
	$ping_res=array();
	foreach ($ping_list as $val)
	{
		$ping_res[]=array($ping_url,curl_ping($val,$ping_header,$ping_body));
	}

	$ping_log="\r\n".'Ping at: '.$GLOBALS['date']."\r\n";
	foreach ($ping_res as $val)
	{
		$ping_log.=$val[0].' 结果:'.$val[1]."\r\n";
	}

	$fp=@fopen(PBBLOG_ROOT.'home/plugins/ping/ping.log',"ab");
	flock($fp,LOCK_EX);
	fwrite($fp,$ping_log);
	fclose($fp);
}

function curl_ping($ping_url, $ping_header,$ping_body) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $ping_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $ping_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $ping_body);
    $res = curl_exec ($ch);
    curl_close ($ch);
    return $res;
}

?>