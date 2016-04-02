<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2011-02-01
 * www.simple-log.com 
*/

//此文件很大的程度上是参考于ecshop，ecshop的设计模式和设计方法，只是我考虑将数据保存在文件中以提高速度

if ($action=='templates_list')
{
	$current_template_info=get_template_info($config['template_name']);

	/* 获得可用的模版 */
	$available_templates = array();
	$template_dir        = @opendir(PBBLOG_ROOT . '/themes/');
	while ($file = readdir($template_dir))
	{
		if ($file != '.' && $file != '..' && is_dir(PBBLOG_ROOT. 'themes/' . $file))
		{
			$available_templates[] = get_template_info($file);
		}
	}
	@closedir($template_dir);

	$smarty->assign('curr_template',$current_template_info);
	$smarty->assign('available_templates',$available_templates);

	$smarty->assign('admin_title','模板列表');
	$smarty->display('template_list.html');
}

elseif ($action=='select_template')
{
	//如果传递的为空，设置为默认模板
	$template_name=!empty($_GET['template_name'])?trim($_GET['template_name']):'default';
	$sql='UPDATE '.table('config')."  SET `value`='".$template_name."' WHERE `key`='template_name'";
	$db->query($sql);
	sys_message('模板设置成功','admin.php?act=templates_list');

}


//获取模板信息

function get_template_info($template_name)
{
	$info = array();

	$info['code']       = $template_name;
	$info['screenshot'] = '';
	$info['screenshot'] = '../themes/' . $template_name . "/theme.png";



	if (file_exists('../themes/' . $template_name . '/info.txt') && !empty($template_name))
	{
		$arr = file('../themes/'. $template_name. '/info.txt');

		$template_name      = explode(': ', $arr[0]);
		$template_desc      = explode(': ', $arr[1]);
		$template_uri       = explode(': ', $arr[2]);
		$template_version   = explode(': ', $arr[3]);
		$template_author    = explode(': ', $arr[4]);
		$author_uri         = explode(': ', $arr[5]);
		$logo_filename      = explode(': ', $arr[6]);

		$info['name']       = isset($template_name[1]) ? trim($template_name[1]) : '';
		$info['uri']        = isset($template_uri[1]) ? trim($template_uri[1]) : '';
		$info['desc']       = isset($template_desc[1]) ? trim($template_desc[1]) : '';
		$info['version']    = isset($template_version[1]) ? trim($template_version[1]) : '';
		$info['author']     = isset($template_author[1]) ? trim($template_author[1]) : '';
		$info['author_uri'] = isset($author_uri[1]) ? trim($author_uri[1]) : '';
	}
	else
	{
		$info['name']       = '';
		$info['uri']        = '';
		$info['desc']       = '';
		$info['version']    = '';
		$info['author']     = '';
		$info['author_uri'] = '';
	}

	return $info;
}
?>