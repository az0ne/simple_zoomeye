<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2011-02-01
 * www.simple-log.com 
*/

if ($action=='setting')
{

	include_once(PBBLOG_ROOT.'home/data/config.php');

	foreach ($config as $key=>$val)
	{
		$smarty->assign($key,$val);
	}

	if (empty($config['domain']))
	{
		$domain=str_replace(PBBLOG_WS_ADMIN, '', dirname($url));
		$smarty->assign('domain',$domain);
	}

	$smarty->assign('type','act_setting');
	$smarty->display('setting.html');
}

elseif ($action=='act_setting')
{

	if (empty($_POST))
	{
		sys_message('请填写数据',$referer_url);
	}
	else
	{
		//循环得到传递过来的数据并为写入配置做准备
		foreach ($_POST as $key => $val)
		{
			$update_arr.=' `'.$key."`	= '".$val."' ,";
			$sql='UPDATE '.table('config')."  SET `key`='".$key."' , `value`='".$val."' WHERE `key`='".$key."'";
			$db->query($sql);
		}
		
		$smarty->cache_dir      = PBBLOG_ROOT . 'home/cache';
		$smarty->compile_dir=PBBLOG_ROOT.'/home/compiled';
		$smarty->clear_all_cache();
		$smarty->clear_compiled_tpl();

		sys_message('博客设置成功','admin.php?act=setting');

	}

}
?>