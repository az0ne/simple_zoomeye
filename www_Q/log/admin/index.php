<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2010-02-16
 * www.simple-log.com 
*/

define(IN_PBBLOG,true);
define(IN_PBADMIN,true);

if (file_exists('../home/data/config.php')) 
{
	require_once('../home/data/config.php');
}
else 
{
	define('PBBLOG_WS_ADMIN', 'admin');
}

define('PBBLOG_ROOT', str_replace(PBBLOG_WS_ADMIN,'',str_replace("\\", '/', dirname(__FILE__))));

require(PBBLOG_ROOT.'/includes/core.php');

$u=dirname($url);

if ($_SESSION['user_id']>0) 
{
	header("location: admin.php?act=index");
}
else 
{
	header("location: admin.php?act=pre_login");
}
?>