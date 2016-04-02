<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2010-02-16
 * www.simple-log.com 
*/

define('IN_PBBLOG', true);

require(dirname(__FILE__) . '/includes/core.php');


$pg=isset($_GET['pg'])?intval($_GET['pg']):1;
$s=!empty($_GET['s'])?trim($_GET['s']):'';

/* 根据用户所在组等级和所在页面以及操作类型md5哈希得到缓存编号 */
$cache_id = md5($_SESSION['group_id'].'-'.$pg.'-'.$s);


/*------------------------------------------------------ */
//-- 判断是否存在缓存，如果存在则调用缓存，反之读取相应内容
/*------------------------------------------------------ */

if (!$smarty->is_cached('list.html', $cache_id))
{


	$s=htmlspecialchars(urldecode($s));
	$where=" WHERE b.title like '%".$s."%' ";
	$where_page=" WHERE title like '%".$s."%' ";
	$page_url='?s='.$s.'&pg=';

	$notice=$title='搜索"'.$s.'"的结果';
	//调用assign_page_info函数，对页面进行模板初始化，包括页面标题，博客名称，博客描述等
	assign_page_info($title);

	//调用边栏赋值函数，对页面边栏进行初始化
	assign_sidebar_info();

	$page_size=!empty($page_size)?$page_size:'15';
	$sql='SELECT count(*) FROM '.table('blog').$where_page;
	$page_count=intval(($db->getone($sql)-1)/$page_size)+1;
	$page_arr=create_page($page_count,$pg,0);

	$start=($pg-1)*$page_size;
	$sql='SELECT b.blog_id,b.title,b.description,b.add_time,b.views,b.comments,b.password,b.view_group,u.user_name,c.cat_name,c.cat_id FROM '.table('blog').
	' AS  b LEFT JOIN '.table('user').' AS u on b.user_id=u.user_id'.
	'  LEFT JOIN '.table('category').' AS c on b.cat_id=c.cat_id '.$where.
	" ORDER BY b.open_type DESC , b.blog_id DESC LIMIT ".$start.' , '.$page_size;
	if ($blog_list=$db->getall($sql))
	{
		foreach ($blog_list as $key=>$val)
		{
			$blog_list[$key]['add_time']=pbtime($val['add_time']);
			$id=$val['blog_id'];
			$blog_list[$key]['description']=htmlspecialchars_decode($val['description']);
			if ($val['password'])
			{
				if ($group_id!=1)
				{
					$blog_list[$key]['description']=<<<DTD
					<form  name="form1" method="post" action="blog.php?id=$id">
  					请输入查看密码：
  					<input type="text" name="pw" id="pw" />
  					<input type="submit" name="button" id="button" value="提交" />
					</form>
DTD;
}
			}
			else
			{
				if ($val['view_group']!='all'&&(!in_array($_SESSION['group_id'],explode(' ',$val['view_group'])))&&$group_id!=1) {
					$blog_list[$key]['description']='您所在的组无权查看该日志';
				}
			}
			
			$blog_list[$key]['tags']=get_tags($id);

			$blog_list[$key]['url']=build_url('blog',$id,$val['url_type']);
			$blog_list[$key]['cat_url']=build_url('cat',$val['cat_id'],$val['cat_url_type']);
		}
	}

	$smarty->assign('notice',$notice);
	$smarty->assign('blog_list',$blog_list);
	$smarty->assign('page_arr',$page_arr);
	$smarty->assign('page_count',$page_count);
	$smarty->assign('pg',$pg);
	$smarty->assign('url',$page_url);

}

$smarty->display('list.html', $cache_id);

?>