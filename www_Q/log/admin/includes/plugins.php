<?php

/**
 * 系统插件
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2011-04-20
 * www.simple-log.com 
*/
//已安装插件
if ($action=='plugins_list')
{
	$sql='SELECT * FROM '.table('plugins').' WHERE 1 '.
	" ORDER BY add_time ASC ";
	$plugins_list=$db->getall($sql);

	$smarty->assign('plugins_list',$plugins_list);

	$smarty->display('plugins_list.html');
}

//尚未安装插件
elseif ($action=='plugins_setup_list')
{

	/* 获得可安装的插件 */
	$modules = array();
	$plugins_dir        = @opendir(PBBLOG_ROOT . '/home/plugins/');
	while ($file = readdir($plugins_dir))
	{
		if ($file != '.' && $file != '..' && file_exists(PBBLOG_ROOT. '/home/plugins/' . $file))
		{
			include_once(PBBLOG_ROOT. '/home/plugins/' . $file.'/info.php');

			//如果插件已经安装或者不是插件
			if (!is_plugin($plugin_info['id']))
			{
				$modules[$plugin_info['id']]=$plugin_info;
			}
			unset($plugin_info);
		}
	}
	@closedir($plugins_dir);

	$smarty->assign('modules',$modules);
	$smarty->display('plugins_setup_list.html');
}

//安装边栏插件页面
elseif ($action=='setup_plugin')
{
	$plugin_id=$_GET['id'];

	/* 获得可安装的插件 */
	include_once(PBBLOG_ROOT. '/home/plugins/' . $plugin_id.'/info.php');
	//如果插件已经安装或者不是插件
	if (is_plugin($plugin_id))
	{
		sys_message('该插件已经安装',$referer_url);
	}

	$sql='INSERT INTO '.table('plugins').
	" (`plugin_id` ,`plugin_name` ,`plugin_desc` ,`author` ,`version` ,`plugin_point` ,`cp_type`,`add_time`)
		VALUES ( '".$plugin_info['id']."',  '".$plugin_info['name']."',  '".$plugin_info['desc'].
		"',  '".$plugin_info['author']."',  '".$plugin_info['version']."', '".$plugin_info['plugin_point']."','".
		$plugin_info['cp_type']."',  '".$time."')";

		if (!$db->query($sql))
		{
			sys_message('安装插件失败，请重新返回添加',$referer_url);
		}

		//此插件是否还有附带安装，比如安装到边栏
		if ($plugin_info['install'])
		{
			if (include_once(PBBLOG_ROOT. '/home/plugins/' . $plugin_id.'/do.php'))
			{
				$plugin_install=$plugin_id.'_install';
				$modules=$plugin_install();
				if ($modules['type']==1)
				{
					$desc=htmlspecialchars($modules['desc']);
					$content=htmlspecialchars($modules['content']);

					$sql='INSERT INTO '.table('modules').
					" (`id` ,`module_id` ,`title` ,`desc` ,`content` ,`sort` ,`type`,`plugin_id` )
		VALUES (NULL , '".$modules['id']."', '".$modules['title']."', '".$desc."', '".$content."', '10', 1,'".$plugin_id."')";
					if ($db->query($sql))
					{
						make_sidebar();
					}
					else
					{
						sys_message('安装插件边栏部分失败，请重新返回添加',$referer_url);
					}
				}
				elseif ($modules['type']==2)
				{
					$db->query($modules['sql']);
				}
			}
		}

		sys_message('安装插件成功','admin.php?act=plugins_list');
}

//删除安装插件
elseif ($action=='del_plugin')
{
	$plugin_id=$_GET['id'];
	$sql='DELETE FROM '.table('plugins')." WHERE plugin_id='".$plugin_id."'";
	if (!$db->query($sql))
	{
		sys_message('删除失败，请重新删除',$referer_url);
	}
	else
	{
		/* 获得插件信息 */
		include_once(PBBLOG_ROOT. '/home/plugins/' . $plugin_id.'/info.php');

		//此插件是否还有附带卸载，比如安装到边栏
		if ($plugin_info['install'])
		{
			if (include_once(PBBLOG_ROOT. '/home/plugins/' . $plugin_id.'/do.php'))
			{
				$plugin_uninstall=$plugin_id.'_uninstall';
				$modules=$plugin_uninstall();
				if ($modules['type']==1)
				{
					$sql='DELETE FROM '.table('modules')." WHERE module_id='".$plugin_id."'";
					if ($db->query($sql))
					{
						make_sidebar();
					}
					else
					{
						sys_message('删除插件边栏部分失败，请重新返回添加',$referer_url);
					}
				}
				elseif ($modules['type']==2)
				{
					$db->query($modules['sql']);
				}
			}
		}
	}

	sys_message('删除插件成功',$referer_url);
}

elseif ($action=='plugin_cp')
{
	$plugin_id=$_GET['id'];
	include_once(PBBLOG_ROOT. '/home/plugins/' . $plugin_id.'/admin_cp.php');
	$smarty->assign('plugin_cp',$plugin_cp);
	$smarty->assign('plugin_id',$plugin_id);
	$smarty->display('plugin_cp.html');
}

//检查插件是否已经安装
function is_plugin($id)
{
	$sql='SELECT * FROM '.table('plugins')." WHERE plugin_id='".$id."'";
	if($GLOBALS['db']->getOne($sql))
	{
		return true;
	}
	else
	{
		return false;
	}
}

?>