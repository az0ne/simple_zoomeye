<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2010-07-29
 * www.simple-log.com 
*/
if ($action=='set_footer')
{
	$get_file=!empty($_GET['file'])?$_GET['file']:'footer.html';

	$footer=file_get_contents(PBBLOG_ROOT.'/themes/'.$config['template_name'].'/'.$get_file);
	$footer=htmlspecialchars($footer);

	$smarty->assign('data',$footer);

	/* 获得模板文件列表 */
	$templates = array();
	$template_dir        = @opendir(PBBLOG_ROOT.'/themes/'.$config['template_name'].'/');
	while ($file = readdir($template_dir))
	{
		if ($file != '.' && $file != '..' && file_exists(PBBLOG_ROOT.'/themes/'.$config['template_name'].'/'. $file))
		{
			$point = strrpos($file, '.');
			$ext=strtolower(substr($file, $point+1, strlen($file) - $point));
			if ($ext=='html'||$ext=='css')
			{
				$templates[]=$file;
			}
		}
	}
	@closedir($template_dir);

	$smarty->assign('file',$get_file);
	$smarty->assign('act_type','act_set_page');
	$smarty->assign('type','set_footer');
	$smarty->assign('post_type',1);
	$smarty->assign('t_list',$templates);

	$smarty->display('set_page.html');
}

elseif ($action=='get_page_data')
{
	require(PBBLOG_ROOT . '/includes/json.class.php');
	$json   = new JSON;
	$file=$_POST['template_file'];
	$res=array('type'=>'get_page_data','content'=>'','error'=>'no');

	$data=file_get_contents(PBBLOG_ROOT.'/themes/'.$config['template_name'].'/'.$file);

	$res['content']=$data;
	die($json->encode($res));
}

elseif ($action=='ajax_post_page_data')
{
	require(PBBLOG_ROOT . '/includes/json.class.php');
	$json   = new JSON;
	$file=$_POST['template_file'];
	$res=array('type'=>'get_page_data','content'=>'','error'=>'no');

	$data=stripslashes($_POST['content']);

	$fp=@fopen(PBBLOG_ROOT.'/themes/'.$config['template_name'].'/'.$file,"w") or $res['error']='无法写入文件，请检查文件是否有权限';
	flock($fp,LOCK_EX);
	fwrite($fp,$data);
	fclose($fp);
	
	die($json->encode($res));
}

elseif ($action=='act_set_page')
{
	$data=htmlspecialchars_decode(stripslashes($_POST['data']));
	$file=$_POST['template_file'];

	$fp=@fopen(PBBLOG_ROOT.'/themes/'.$config['template_name'].'/'.$file,"w") or die('can not open file');
	flock($fp,LOCK_EX);
	fwrite($fp,$data);
	fclose($fp);
	
	sys_message('页面修改成功','admin.php?act=set_footer&file='.$file);

}
?>