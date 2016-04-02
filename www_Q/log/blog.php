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

if (!$smarty->is_cached('blog.html', $cache_id))
{
	if ($keywords)
	{
		$where=" WHERE b.url_type='".$keywords."' ";
	}
	else
	{
		$where=" WHERE b.blog_id='".$id."' ";
	}


	$sql='SELECT b.blog_id,b.title,b.description,b.add_time,b.views,b.comments,b.content,b.password,b.view_group,b.open_type,b.url_type,u.user_name,c.cat_name,c.cat_id,c.url_type as cat_url_type FROM '.table('blog').
	' AS  b LEFT JOIN '.table('user').' AS u on b.user_id=u.user_id'.
	'  LEFT JOIN '.table('category').' AS c on b.cat_id=c.cat_id '.$where;
	if ($blog=$db->getrow($sql))
	{
		$blog['add_time']=pbtime($blog['add_time']);
		$blog['content']=htmlspecialchars_decode($blog['content']);
		$id=$blog['blog_id'];
		if ($blog['password'])
		{
			if (trim($_POST['pw'])!=$blog['password'])
			{
				if ($group_id!=1)
				{
					$blog['content']=<<<DTD
						<form  name="form1" method="post" action="blog.php?id=$id">
  						请输入查看密码：
  						<input type="text" name="pw" id="pw" />
  						<input type="submit" name="button" id="button" value="提交" />
						</form>
DTD;
}
			}
		}
		else
		{
			if ($blog['view_group']!='all'&&(!in_array($_SESSION['group_id'],explode(',',$blog['view_group'])))&&$group_id!=1) 
			{
				$blog['content']='您所在的组无权查看该日志';
			}
		}
		
		$blog['tags']=get_tags($id);
		
		$blog['url']=build_url('blog',$id,$blog['url_type']);
		$blog['cat_url']=build_url('cat',$blog['cat_id'],$blog['cat_url_type']);
	}
	
	
	$smarty->assign('blog',$blog);


	//调用assign_page_info函数，对页面进行模板初始化，包括页面标题，博客名称，博客描述等
	assign_page_info($blog['title']);

	//调用边栏赋值函数，对页面边栏进行初始化
	assign_sidebar_info();
	
	//调用博客显示插件
	hook(6,array('blog_id'=>$id));
}

/* 更新点击次数 */
$db->query('UPDATE ' . table('blog') . " SET views = views + 1 WHERE blog_id = '$id'");
$smarty->display('blog.html', $cache_id);

?>