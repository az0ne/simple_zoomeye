<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2011-02-05
 * www.simple-log.com 
*/

if (!defined('IN_PBADMIN'))
{
	die('Access Denied');
}

function check_privilege($action)
{
	if (!empty($_SESSION['group_id'])&&$_SESSION['group_id']!=0)
	{
		$admin_privilege=$GLOBALS['db']->getone('SELECT admin_privilege FROM '.table('user_group').
		" WHERE group_id='".$_SESSION['group_id']."'");
		$admin_privilege=explode(',',$admin_privilege);

		if ((!in_array($action,$admin_privilege))&&$admin_privilege[0]!='all')
		{
			//$link_url=!empty($GLOBALS['referer_url'])?$GLOBALS['referer_url']:'./';
			show_message('您没有权限访问该页面','admin.php?act=default');
		}

	}
	elseif ($_SESSION['group_id']==0)
	{
		show_message('请先登录','admin.php?act=pre_login');
	}
}

function group_name($group_id)
{
	return $GLOBALS['db']->getone('SELECT group_name FROM '.table('user_group').
	" WHERE group_id='".$_SESSION['group_id']."'");
}

function admin_here($type)
{
	$admin_here=$admin_title='';
	
	if ($type=='add_nav')
	{
		$admin_here= ' | 添加网站导航元素 | <a href="admin.php?act=nav_list">网站导航列表</a>';
		$admin_title='添加网站导航元素';
	}
	elseif ($type=='nav_list')
	{
		$admin_here= ' | 网站导航列表 | <a href="admin.php?act=add_nav">添加网站导航元素</a> ';
		$admin_title='网站导航列表';
	}
	elseif ($type=='edit_nav')
	{
		$admin_here= ' | 编辑网站导航 | <a href="admin.php?act=nav_list">网站导航列表</a> ';
		$admin_title='编辑网站导航';
	}

	elseif ($type=='page_list')
	{
		$admin_here= ' | 自定义页面  |  <a href="admin.php?act=add_page">创建页面</a> ';
		$admin_title='自定义页面';
	}

	elseif ($type=='add_page')
	{
		$admin_here= ' | 创建页面  |  <a href="admin.php?act=page_list">自定义页面列表</a> ';
		$admin_title='创建页面';
	}


	elseif ($type=='edit_page')
	{
		$admin_here= '编辑自定义页面';
		$admin_title='编辑自定义页面';
	}

	elseif ($type=='tags_list')
	{
		$admin_here= 'Tags';
		$admin_title='Tags';
	}

	elseif ($type=='attachments_list')
	{
		$admin_here= '附件管理';
		$admin_title='附件管理';
	}

	elseif ($type=='add_blog')
	{
		$admin_here= '添加日志 ';
		$admin_title='添加日志';
	}

	elseif ($type=='blog_list')
	{
		$admin_here= ' 日志列表';
		$admin_title='日志列表';
	}

	elseif ($type=='edit_blog')
	{
		$admin_here= ' 编辑日志';
		$admin_title='编辑日志';
	}

	elseif ($type=='add_cat')
	{
		$admin_here= '添加分类';
		$admin_title='添加分类';
	}


	elseif ($type=='edit_cat')
	{
		$admin_here= '编辑分类';
		$admin_title='编辑分类';
	}


	elseif ($type=='cat_list')
	{
		$admin_here= '分类列表  |  <a href="admin.php?act=add_cat">添加分类</a>';
		$admin_title='分类列表';
	}

	elseif ($type=='comment_list')
	{
		$admin_here= '评论列表';
		$admin_title='评论列表';
	}


	elseif ($type=='edit_comment')
	{
		$admin_here= '编辑评论';
		$admin_title='编辑评论';
	}


	elseif ($type=='member_list')
	{
		$admin_here= '会员列表';
		$admin_title='会员列表';
	}

	elseif ($type=='edit_member')
	{
		$admin_here= '编辑会员';
		$admin_title='编辑会员';
	}

	elseif ($type=='add_member')
	{
		$admin_here= '添加会员';
		$admin_title='添加会员';
	}

	elseif ($type=='group_list')
	{
		$admin_here= '会员组列表';
		$admin_title='会员组列表';
	}

	elseif ($type=='edit_group')
	{
		$admin_here= '编辑会员组';
		$admin_title='编辑会员组';
	}

	elseif ($type=='add_group')
	{
		$admin_here= '添加会员组';
		$admin_title='添加会员组';
	}

	elseif ($type=='setting')
	{
		$admin_here= '博客设置';
		$admin_title='博客设置';
	}

	elseif ($type=='templates_list')
	{
		$admin_here= '模板选择';
		$admin_title='模板选择';
	}

	elseif ($type=='sidebar_list')
	{
		$admin_here= '| 边栏挂件列表 | <a href="admin.php?act=sidebar_setup_list">可安边栏挂件列表</a>  | <a href="admin.php?act=add_sidebar">自定义边栏挂件</a>';
		$admin_title='边栏挂件列表';
	}

	elseif ($type=='setup_sidebar')
	{
		$admin_here= '安装边栏挂件';
		$admin_title='安装边栏挂件';
	}

	elseif ($type=='sidebar_setup_list')
	{
		$admin_here= '| 可安边栏挂件列表 | <a href="admin.php?act=sidebar_list">边栏挂件列表</a>  | <a href="admin.php?act=add_sidebar">自定义边栏挂件</a>';
		$admin_title='可安边栏挂件列表';
	}

	elseif ($type=='edit_sidebar')
	{
		$admin_here= '编辑边栏挂件';
		$admin_title='编辑边栏挂件';
	}

	elseif ($type=='add_sidebar')
	{
		$admin_here= '| 自定义边栏挂件 | <a href="admin.php?act=sidebar_list">边栏挂件列表</a>  | <a href="admin.php?act=sidebar_setup_list">可安边栏挂件列表</a>';
		$admin_title='自定义边栏挂件';
	}

	elseif ($type=='edit_group')
	{
		$admin_here= '编辑会员组';
		$admin_title='编辑会员组';
	}

	elseif ($type=='add_group')
	{
		$admin_here= '添加会员组';
		$admin_title='添加会员组';
	}

	elseif ($type=='databak')
	{
		$admin_here= '数据备份';
		$admin_title='数据备份';
	}

	elseif ($type=='re_data')
	{
		$admin_here= '数据恢复';
		$admin_title='数据恢复';
	}

	elseif ($type=='set_footer')
	{
		$admin_here= '自定义网站页面';
		$admin_title='自定义网站页面';
	}

	if ($type=='add_friend_link')
	{
		$admin_here= ' | 添加友情链接 | <a href="admin.php?act=friend_link_list">友情链接列表</a>';
		$admin_title='添加友情链接';
	}
	elseif ($type=='friend_link_list')
	{
		$admin_here= ' | 友情链接列表 | <a href="admin.php?act=add_friend_link">添加友情链接</a> ';
		$admin_title='友情链接列表';
	}
	elseif ($type=='edit_friend_link')
	{
		$admin_here= ' | 编辑友情链接 | <a href="admin.php?act=friend_link_list">友情链接列表</a> ';
		$admin_title='编辑友情链接';
	}

	elseif ($type=='default')
	{
		$admin_here= '首页';
		$admin_title='首页';
	}

	elseif ($type=='plugins_list')
	{
		$admin_here= ' | 插件列表 | <a href="admin.php?act=plugins_setup_list">可安装插件列表</a>';
		$admin_title='插件列表';
	}


	elseif ($type=='plugins_setup_list')
	{
		$admin_here= ' | 可安装插件列表 | <a href="admin.php?act=plugins_list">插件列表</a>';
		$admin_title='可安装插件列表';
	}

	$admin_here='<a href="admin.php?act=default">管理中心</a>  -  '.$admin_here;
	$title=$admin_title.'-Simple-Log管理中心';
	$GLOBALS['smarty']->assign('admin_here',$admin_here);
	$GLOBALS['smarty']->assign('admin_title',$title);
}

function make_sidebar()
{
	$sql='SELECT * FROM '.table('modules').' WHERE type=1 '.
	" ORDER BY sort ASC ";
	$sidebar_list=$GLOBALS['db']->getall($sql);

	$sidebar_html="<div id=\"sidebar\"> \n";
	foreach ($sidebar_list as $sidebar)
	{
		$sidebar_html.="<h2>$sidebar[title]</h2> \n";
		$sidebar_html.=htmlspecialchars_decode($sidebar['content']);
	}
	$sidebar_html.='</div>';

	$fp=fopen(PBBLOG_ROOT.'/themes/'.$GLOBALS['config']['template_name'].'/sidebar.html',"w") or die('can not open file');
	flock($fp,LOCK_EX);
	fwrite($fp,$sidebar_html);
	fclose($fp);
}

//输出消息格式
function sys_message($msg,$link_url)
{
	$GLOBALS['smarty']->caching = false;
	$GLOBALS['smarty']->template_dir=PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/templates';
	$GLOBALS['smarty']->assign('msg',$msg);
	$GLOBALS['smarty']->assign('new_url',$link_url);
	$GLOBALS['smarty']->assign('referer_url',$GLOBALS['referer_url']);
	$GLOBALS['smarty']->assign('domain',$GLOBALS['config']['domain']);
	$GLOBALS['smarty']->display('notice.html');
	exit;
}

?>