<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2011-04-16
 * www.simple-log.com 
*/

define('IN_PBBLOG', true);

require(dirname(__FILE__) . '/includes/core.php');

$pg=isset($_GET['pg'])?intval($_GET['pg']):1;
$attachment_id=!empty($_GET['fid'])?intval($_GET['fid']):'';
$file_name=$db->getrow('SELECT file_name,type FROM '.table('attachments')." WHERE attachment_id='".$attachment_id."'");
if ($file_name&&is_file(PBBLOG_ROOT.'/'.$file_name['file_name']))
{
	ob_end_clean();
	@header("Content-Disposition: {$headerposition}; filename=\"".basename($file_name['file_name'])."\"");
	@header("Content-Type: application/octet-stream");
	@header('Content-Length: '.filesize(PBBLOG_ROOT.'/'.$file_name['file_name']));
	$fp = fopen(PBBLOG_ROOT.'/'.$file_name['file_name'], 'rb');
	fpassthru($fp);
	fclose($fp);
}


?>