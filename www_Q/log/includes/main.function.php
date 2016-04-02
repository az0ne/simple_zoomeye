<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2010-02-16
 * www.simple-log.com 
*/

if (!defined('IN_PBBLOG'))
{
	die('Access Denied');
}

//过滤函数
function input_filter($input)
{
	return is_array($input) ? array_map('input_filter', $input) : addslashes($input);
}

//将过滤的数据转换为正常数据
function input_filter_decode($input)
{
	return is_array($input) ? array_map('input_filter_decode', $input) : stripslashes($input);
}


//来源页面
function referer_url()
{
	return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
}


//当前访问页面地址
function url()
{
	$scheme=$_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';

	if (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
	{
		$host = $_SERVER['HTTP_X_FORWARDED_HOST'];
	}
	elseif (isset($_SERVER['HTTP_HOST']))
	{
		$host = $_SERVER['HTTP_HOST'];
	}

	if (isset($_SERVER['REQUEST_URI']))
	{
		$relate_url=$_SERVER['REQUEST_URI'];
	}
	else
	{
		$php_self = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
		if (isset($_SERVER['QUERY_STRING']))
		{
			$relate_url=$php_self.'?'.$_SERVER['QUERY_STRING'];
		}
		else
		{
			$relate_url=$php_self.(isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '');
		}
	}
	return $scheme.$host.$relate_url;
}


//当前域名
function domain()
{
	$scheme=$_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';

	if (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
	{
		$host = $_SERVER['HTTP_X_FORWARDED_HOST'];
	}
	elseif (isset($_SERVER['HTTP_HOST']))
	{
		$host = $_SERVER['HTTP_HOST'];
	}
	return $scheme.$host;
}

//获取IP地址，用户通过高匿名代理服务器或者欺骗性代理服务器时是无法获取到真实ip的，因此ip获取只能作为参考,这个函数是互联网的一个通俗写法
function ip()
{
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown'))
	{
		$ip = getenv('HTTP_CLIENT_IP');
	}
	elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown'))
	{
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	}
	elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown'))
	{
		$ip = getenv('REMOTE_ADDR');
	}
	elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown'))
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	else
	{
		$ip = '0.0.0.0';
	}
	return preg_match ( '/[\d\.]{7,15}/', $ip, $real_ip) ? $real_ip[0] : '';;
}


//加上表前缀，获得真实的表名字
function table($tablename)
{
	return $GLOBALS['dbprefix'].$tablename;
}


//输出消息格式
function show_message($msg,$link_url)
{
	$GLOBALS['smarty']->caching = false;
	$GLOBALS['smarty']->assign('msg',$msg);
	$GLOBALS['smarty']->assign('new_url',$link_url);
	$GLOBALS['smarty']->assign('referer_url',$referer_url);
	$GLOBALS['smarty']->assign('domain',$GLOBALS['config']['domain']);
	$GLOBALS['smarty']->display('notice.html');
	exit;
}

//重建url
function build_url($base,$id=1,$type=1)
{
	if ($GLOBALS['config']['rewrite']==1)
	{
		//对默认重写方式构建url重写
		if ($type==1||empty($type))
		{
			if ($base=='blog')
			{
				$url='blog/'.$id.'.html';
			}
			elseif ($base=='cat')
			{
				$url='category/'.$id.'.html';
			}
			elseif ($base=='archive')
			{
				$url='archive/'.$id.'/';
			}
			elseif ($base=='tag')
			{
				$url='tag/'.urlencode(urlencode($id)).'/';
			}
			elseif ($base=='page')
			{
				$url='page/'.$id.'/';
			}
		}
		else
		{
			if ($base=='blog')
			{
				$url='blog/'.$type;
			}
			elseif ($base=='cat')
			{
				$url='category/'.$type;
			}
		}

		//对分页重构url
		if ($base=='index_page')
		{
			$url='index/'.$id.'/';
		}
		elseif ($base=='archives_list')
		{
			$url='archives/'.$type.'/'.$id.'/';
		}
		elseif ($base=='cat_list')
		{
			$url='category/'.$type.'/'.$id.'/';
		}
	}
	else
	{
		if ($base=='blog')
		{
			$url='blog.php?id='.$id;
		}
		elseif ($base=='cat')
		{
			$url='list.php?act=cat_list&id='.$id;
		}
		elseif ($base=='archive')
		{
			$url='list.php?act=archives_list&date='.$id;
		}
		elseif ($base=='tag')
		{
			$url='tag.php?tag='.$id;
		}
		elseif ($base=='index_page')
		{
			$url='index.php?pg='.$id;
		}
		elseif ($base=='archives_list')
		{
			$url='list.php?act=archives_list&date='.$type.'&pg='.$id;
		}
		elseif ($base=='cat_list')
		{
			$url='list.php?act=cat_list&id='.$type.'&pg='.$id;
		}
	}
	return $GLOBALS['config']['domain'].$url;
}


//页数函数，创建页数所有的参数
function create_page($page_count,$pg,$type=0)
{
	$pager_size=!empty($GLOBALS['config']['pager_size'])?$GLOBALS['config']['pager_size']:'5';


	if ($pg>$page_count)
	{
		show_message('错误页数',$GLOBALS['referer_url']);
	}
	$page_arr=array();

	if ($type==1)
	{
		$i=0;
		$page_arr[$i]['name']='首页';
		$page_arr[$i]['value']='1';
		$i++;
		if ($pg>1)
		{
			$page_arr[$i]['name']='上一页';
			$page_arr[$i]['value']=$pg-1;
			$i++;
		}
		if ($pg<$page_count)
		{
			$page_arr[$i]['name']='下一页';
			$page_arr[$i]['value']=$pg+1;
			$i++;
		}
		$page_arr[$i]['name']='尾页';
		$page_arr[$i]['value']=$page_count;
	}
	else
	{
		$i=0;
		if ($pg-$pager_size<1)
		{
			for ($j=1;$j<=$pg;$j++)
			{
				$page_arr[$i]['name']=$j;
				$page_arr[$i]['value']=$j;
				$i++;
			}
		}
		else
		{
			for ($j=$pg-$pager_size;$j<=$pg;$j++)
			{
				$page_arr[$i]['name']=$j;
				$page_arr[$i]['value']=$j;
				$i++;
			}
		}

		if ($pg+$pager_size<$page_count)
		{
			for ($j=$pg+1;$j<=$pg+$pager_size;$j++)
			{
				$page_arr[$i]['name']=$j;
				$page_arr[$i]['value']=$j;
				$i++;
			}
		}
		else
		{
			for ($j=$pg+1;$j<$page_count+1;$j++)
			{
				$page_arr[$i]['name']=$j;
				$page_arr[$i]['value']=$j;
				$i++;
			}
		}

	}

	return $page_arr;
}

function create_page_url($page_arr,$base,$type)
{
	//对页面url重构
	foreach ($page_arr as $key=>$val)
	{
		$page_arr[$key]['url']=build_url($base,$val['value'],$type);
	}
	return $page_arr;
}

//对页面进行模板初始化，包括页面标题，博客名称，博客描述等
function assign_page_info($title='',$key='',$desc='')
{
	/*对首页初始化*/
	if (empty($title))
	{
		$page_title='';
	}
	elseif ($title!='')
	{
		$page_title=$title.'-';
	}
	
	$desc=empty($desc)?$GLOBALS['config']['blog_desc']:$desc;


	$page_title.=$GLOBALS['config']['blog_name'];
	$GLOBALS['smarty']->assign('page_title',$page_title);
	$GLOBALS['smarty']->assign('desc',$desc);
	$GLOBALS['smarty']->assign('notice',$GLOBALS['config']['notice']);
	$GLOBALS['smarty']->assign('open_comment',$GLOBALS['config']['open_comment']);

	$GLOBALS['smarty']->assign('blog_name',$GLOBALS['config']['blog_name']);

	$GLOBALS['smarty']->assign('domain',$GLOBALS['config']['domain']);
	$GLOBALS['smarty']->assign('tj',$GLOBALS['config']['tj']);

	$GLOBALS['smarty']->assign('templates_dir','themes/'.$GLOBALS['config']['template_name'].'/');
}

//对页面进行边栏初始化，包括页面分类，归档等
function assign_sidebar_info()
{
	$nav_list=$cat_list=$archives=$archive_list=array();
	
	//获得网站导航数据
	$sql='SELECT * FROM '.table('modules').' WHERE type=2 '.
	" ORDER BY sort ASC  ";
	$nav_list=$GLOBALS['db']->getall($sql);
	foreach ($nav_list as $key=>$val)
	{
		if (strpos(substr(strrchr($_SERVER['REQUEST_URI'],'/'),1),$val['content'])===0)
		{
			$nav_list[$key]['current']=1;
		}

		//重写导航url
		if ($GLOBALS['config']['rewrite'])
		{
			if (substr($val['content'],0,4)!='http')
			{
				$nav_list[$key]['content']=$GLOBALS['config']['domain'].$val['content'];
			}
		}
	}

	//获得友情链接
	$sql='SELECT * FROM '.table('link').
	" ORDER BY sort ASC  ";
	$link_list=$GLOBALS['db']->getall($sql);

	//获得分类数据
	$sql='SELECT cat_id,cat_name,cat_desc,listorder,url_type FROM '.table('category').
	" WHERE parent_id=0 ORDER BY listorder ASC , cat_id ASC ";
	$cat_list=$GLOBALS['db']->getall($sql);

	//获取子分类，暂时只支持二级分类
	foreach ($cat_list as $key=>$val)
	{
		$sql='SELECT cat_id,cat_name,cat_desc,listorder,url_type FROM '.table('category').
		" WHERE parent_id=".$val['cat_id']." ORDER BY listorder ASC , cat_id ASC ";
		$cat_list[$key]['url']=build_url('cat',$val['cat_id'],$val['url_type']);
		$cat_list[$key]['children']=$GLOBALS['db']->getall($sql);
		if ($cat_list[$key]['children'])
		{
			foreach ($cat_list[$key]['children'] as $children_key=>$children_val)
			{
				$cat_list[$key]['children'][$children_key]['url']=build_url('cat',$children_val['cat_id'],$children_val['url_type']);
			}
		}
	}

	//获得归档数据
	$sql = 'SELECT add_time FROM '.table('blog').' ORDER BY add_time DESC';
	$archives=$GLOBALS['db']->getall($sql);
	foreach ($archives as $key => $val)
	{
		$archive[]=date("Y/m",$val['add_time']);
		//将日志中的时间转换成为档案时间的形式，也就是年月的形式
	}

	$archive=!empty($archive)?array_count_values($archive):array();

	foreach ($archive as $key=>$val)
	{
		$year=substr($key,0,4);
		$month=substr($key,5,6);
		$archive_list[$key]['data']=$year.'年'.$month.'月['.$val.']';
		$archive_list[$key]['url']=build_url('archive',$key,1);
	}

	hook(1);

	$GLOBALS['smarty']->assign('link_list',$link_list);
	$GLOBALS['smarty']->assign('nav_list',$nav_list);
	$GLOBALS['smarty']->assign('feed_url',$GLOBALS['config']['domain'].'feed.php');
	$GLOBALS['smarty']->assign('cat',$cat_list);
	$GLOBALS['smarty']->assign('archives',$archive_list);


}


//调用会员信息
function insert_member_info()
{
	$need_cache = $GLOBALS['smarty']->caching;
	$GLOBALS['smarty']->caching = false;
	$domain=$GLOBALS['config']['domain'];

	if ($_SESSION['user_id'] > 0)
	{
		$user=user_info();
		//如果是管理员登陆，出现后台管理地址
		if ($user['group_id']==1) 
		{
			$admin_url='<li><a href="'.$domain.'admin/">后台管理</a></li>';
		}
		
		$output='<ul><li><a href="'.$domain.'">首页</a></li><li><a>欢迎您,'.$user['user_name'].'</a></li><li><a>您所在用户组:'.
		$user['group_name'].'</a></li><li><a href="'.$domain.'user.php?act=profile">个人资料</a></li>'.$admin_url.
		'<li><a href="'.$domain.'user.php?act=logout">退出</a></li></ul>';

	}
	else
	{
		$output='<ul><li><a href="'.$domain.'">首页</a></li>'.
		'<li><a href="'.$domain.'user.php?act=reg">注册</a></li>'.
		'<li><a href="'.$domain.'user.php?act=login">登陆</a></li></ul>';
	}

	$GLOBALS['smarty']->caching = $need_cache;

	return $output;
}

//用户信息函数
function user_info()
{
	$sql='SELECT o.user_id,o.user_name,o.email,o.home,o.reg_time,o.last_time,u.group_name,u.group_id FROM '.table('user').
	" o LEFT JOIN ".table('user_group')." u on o.group_id=u.group_id".
	" WHERE o.user_id='".$_SESSION['user_id']."'";
	return $GLOBALS['db']->getrow($sql);
}


//插入评论者的名字
function insert_comments_name()
{
	if ($_SESSION['user_id']>0)
	{
		$user=user_info();
		$content='<p>名字：'.$user['user_name'].'<br /><input type="hidden" name="name" id="name" value='.$user['user_name'].' /></p>'.
		'<input type="hidden" name="url" id="url" value="'.$user['home'].'" />'.
		'<input type="hidden" name="email" id="email" value="'.$user['email'].'" />';
	}
	else
	{
		$content='<p>名字：<br /><input type="text" name="name" id="name" /></p>';
		$content.='<p>个人主页地址：<br />'.'<input type="text" name="url" id="url"  /></p>';
		$content.='<p>E-mail：<br />'.'<input type="text" name="email" id="email" /></p>';
	}
	return $content;
}

//插件钩子函数
function hook($id,$arr=array())
{
	$plugins_list=array();
	$sql='SELECT * FROM '.table('plugins')." WHERE plugin_point= '".$id.
	"' ORDER BY add_time ASC ";
	$plugins_list=$GLOBALS['db']->getall($sql);
	foreach ($plugins_list as $val)
	{
		$plugin_do=$val['plugin_id'];
		if (file_exists(PBBLOG_ROOT. '/home/plugins/' . $val['plugin_id'].'/do.php'))
		{
			include_once(PBBLOG_ROOT. '/home/plugins/' . $val['plugin_id'].'/do.php');
			$plugin_do($arr);
		}
	}
}

//打印函数
function print_k($a){
	echo '<pre>';
	print_r($a);
	echo '</pre>';
	exit;
}



?>