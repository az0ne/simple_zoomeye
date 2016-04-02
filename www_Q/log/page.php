<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2011-02-05
 * www.simple-log.com 
*/

define('IN_PBBLOG', true);

require(dirname(__FILE__) . '/includes/core.php');


$id=!empty($_GET['id'])?intval($_GET['id']):'1';
$keywords=!empty($_GET['keywords'])?htmlspecialchars($_GET['keywords']):'';

/* 根据用户所在组等级和所在页面以及日志密码md5哈希得到缓存编号 */
$pw=isset($_POST['pw'])?htmlspecialchars(trim($_POST['pw'])):'';
$cache_id = md5($_SESSION['group_id'].'-'.$id.'-'.$pw.'-'.$keywords);

/*------------------------------------------------------ */
//-- 判断是否存在缓存，如果存在则调用缓存，反之读取相应内容
/*------------------------------------------------------ */

if (!$smarty->is_cached('diy_page.html', $cache_id))
{
	if ($keywords)
	{
		$where=" WHERE b.url_type='".$keywords."' ";
	}
	else
	{
		$where=" WHERE b.page_id='".$id."' AND type=0 ";
	}

	$sql='SELECT b.page_id,b.title,b.desc,b.add_time,b.content FROM '.table('page').
	' AS  b LEFT JOIN '.table('user').' AS u on b.user_id=u.user_id'.$where;
	if ($page=$db->getrow($sql))
	{
		$page['add_time']=pbtime($page['add_time']);
		$page['content']=htmlspecialchars_decode($page['content']);
		$id=$page['page_id'];
	}

	$smarty->assign('page',$page);

	//调用assign_page_info函数，对页面进行模板初始化，包括页面标题，博客名称，博客描述等
	assign_page_info($page['title'],'',$page['desc']);

	//调用边栏赋值函数，对页面边栏进行初始化
	assign_sidebar_info();
	
}

$smarty->display('diy_page.html', $cache_id);

?>