<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2011-04-20
 * www.simple-log.com 
*/

//此文件的意义在于给定用户组安全操作数组和他对应的语言

$action_pri[]=array('lang'=>'首页权限','value'=>array(
											array('lang' => '登陆' , 'act_type' => 'login') ,
											array('lang' => '查看首页' , 'act_type' => 'index,header,menu,footer,default') 
));

$action_pri[]=array('lang'=>'日志权限管理','value'=>array(
											array('lang' => '日志列表' , 'act_type' => 'blog_list') ,
											array('lang' => '删除博客' , 'act_type' => 'del_blog') ,
											array('lang' => '编辑/添加博客' , 'act_type' => 'add_blog,act_add_blog,edit_blog,act_edit_blog,auto_save,get_auto_save,check_auto_date') 
));

$action_pri[]=array('lang'=>'日志分类权限管理','value'=>array(
											array('lang' => '分类列表' , 'act_type' => 'cat_list') ,
											array('lang' => '删除分类' , 'act_type' => 'del_cat') ,
											array('lang' => '编辑/添加分类' , 'act_type' => 'add_cat,act_add_cat,edit_cat,act_edit_cat') 
));

$action_pri[]=array('lang'=>'日志评论权限管理','value'=>array(
											array('lang' => '评论列表' , 'act_type' => 'comment_list') ,
											array('lang' => '删除评论' , 'act_type' => 'del_comment') ,
											array('lang' => '编辑/添加评论' , 'act_type' => 'add_comment,act_add_comment,edit_comment,act_edit_comment') 
));

$action_pri[]=array('lang'=>'日志相关权限管理','value'=>array(
											array('lang' => 'Tags列表' , 'act_type' => 'tags_list') ,
											array('lang' => '删除Tag' , 'act_type' => 'del_tag') ,
											array('lang' => '附件管理' , 'act_type' => 'del_attachment,attachments_list') 
));

$action_pri[]=array('lang'=>'会员权限管理','value'=>array(
											array('lang' => '会员列表' , 'act_type' => 'member_list') ,
											array('lang' => '删除会员' , 'act_type' => 'del_member') ,
											array('lang' => '编辑/添加会员' , 'act_type' => 'add_member,act_add_member,edit_member,act_edit_member') 
));

$action_pri[]=array('lang'=>'会员分组权限管理','value'=>array(
											array('lang' => '分组列表' , 'act_type' => 'group_list') ,
											array('lang' => '删除分组' , 'act_type' => 'del_group') ,
											array('lang' => '编辑/添加分组' , 'act_type' => 'add_group,act_add_group,edit_group,act_edit_group') 
));

$action_pri[]=array('lang'=>'系统设置','value'=>array(
											array('lang' => '博客设置' , 'act_type' => 'setting,act_setting') ,
											array('lang' => '模板设置' , 'act_type' => 'templates_list,select_template') ,
											array('lang' => '清除缓存' , 'act_type' => 'clear_cache') ,
											array('lang' => '数据备份与恢复' , 'act_type' => 'databak,act_backup,re_data,act_re_data,del_sql_file') ,
											array('lang' => '友情链接' , 'act_type' => 'friend_link_list,act_edit_friend_link_sort,edit_friend_link,act_edit_friend_link,add_friend_link,act_add_friend_link,del_friend_link') 
));

$action_pri[]=array('lang'=>'系统模块','value'=>array(
											array('lang' => '边栏插件列表' , 'act_type' => 'sidebar_setup_list,sidebar_list') ,
											array('lang' => '边栏插件安装' , 'act_type' => 'setup_sidebar,act_setup_sidebar') ,
											array('lang' => '边栏插件删除/编辑' , 'act_type' => 'act_edit_sort,del_sidebar,edit_sidebar,act_edit_sidebar'),
											array('lang' => '插件删除/编辑' , 'act_type' => 'plugins_list,plugins_setup_list,setup_plugin,del_plugin,plugin_cp'),
											array('lang' => '网站导航列表' , 'act_type' => 'nav_list') ,
											array('lang' => '添加网站导航' , 'act_type' => 'add_nav,act_add_nav') ,
											array('lang' => '网站导航删除/编辑' , 'act_type' => 'edit_nav,act_edit_nav,act_edit_nav_sort,del_nav'),
											array('lang' => '自定义网站模板' , 'act_type' => 'set_footer,act_set_page,get_page_data,ajax_post_page_data') ,
											array('lang' => '自定义页面' , 'act_type' => 'page_list,del_page,add_page,act_add_page,edit_page,act_edit_page') 
));

?>