<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2010-07-30
 * www.simple-log.com 
*/
if ($action=='index')
{
	$smarty->assign('admin_title','Simple-Log系统管理后台');
	$smarty->display('index.html');
}

elseif ($action=='default')
{
	$smarty->assign('user_name',$_SESSION['user_name']);
	$smarty->assign('user_id',$_SESSION['user_id']);
	$smarty->assign('last_time',date('Y-m-d H:i:s',$_SESSION['last_time']));
	$smarty->assign('last_ip',$_SESSION['last_ip']);


	$smarty->assign('user_group',group_name($_SESSION['group_id']));

	//服务器信息
	$smarty->assign('upload_max_filesize',ini_get('upload_max_filesize'));
	$smarty->assign('SERVER_SOFTWARE',$_SERVER['SERVER_SOFTWARE']);
	$smarty->assign('mysql_version',$db->version());
	$smarty->assign('php_version',phpversion());
	$smarty->assign('date',$date);

	//评论信息
	$today_time=strtotime(date('Y-m-d'));
	$today_comments=$db->getone('SELECT count(*) FROM '.table('comment').' WHERE add_time>'.$today_time);
	$comments=$db->getone('SELECT count(*) FROM '.table('comment').' WHERE 1');
	$smarty->assign('comments',$comments);
	$smarty->assign('today_comments',$today_comments);
	
	//会员信息
	$today_time=strtotime(date('Y-m-d'));
	$today_users=$db->getone('SELECT count(*) FROM '.table('user').' WHERE reg_time>'.$today_time);
	$users_num=$db->getone('SELECT count(*) FROM '.table('user').' WHERE 1');
	$smarty->assign('today_users',$today_users);
	$smarty->assign('users_num',$users_num);
	
	//版权信息
	$smarty->assign('version',file_get_contents(PBBLOG_ROOT.'home/version.txt'));
	$smarty->assign('u',str_replace(PBBLOG_WS_ADMIN, '', dirname($url)));				
	

	$smarty->assign('admin_title','后台首页');
	$smarty->display('default.html');
}

elseif ($action=='get_version')
{
	require(PBBLOG_ROOT. '/includes/json.class.php');
	$json   = new JSON;
	$notice=file_get_contents('http://www.simple-log.com/api.php?act=version&u='.str_replace(PBBLOG_WS_ADMIN, '', dirname($url)));
	$res=explode('|s|',$notice);
	$res['version']=$res[0];
	$res['notice']=$res[1];
	
	die($json->encode($res));
}

elseif ($action=='header')
{
	$smarty->display('frame_header.html');
}

elseif ($action=='menu')
{
	$smarty->display('menu.html');
}


?>