DROP TABLE IF EXISTS fb_attachments;

CREATE TABLE `fb_attachments` (
  `attachment_id` int(10) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL,
  `add_time` int(10) NOT NULL,
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS fb_blog;

CREATE TABLE `fb_blog` (
  `blog_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) NOT NULL,
  `cat_id` smallint(4) NOT NULL,
  `title` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `content` mediumtext NOT NULL,
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `edit_time` int(10) NOT NULL,
  `comments` mediumint(8) NOT NULL,
  `views` mediumint(8) NOT NULL,
  `password` varchar(20) NOT NULL,
  `view_group` varchar(255) NOT NULL,
  `open_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `url_type` varchar(100) NOT NULL,
  PRIMARY KEY (`blog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS fb_category;

CREATE TABLE `fb_category` (
  `cat_id` smallint(4) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(120) NOT NULL,
  `cat_desc` varchar(255) NOT NULL DEFAULT '',
  `parent_id` smallint(4) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `url_type` varchar(100) NOT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO fb_category (`cat_id`,`cat_name`,`cat_desc`,`parent_id`,`listorder`,`url_type` ) VALUES ( '1','记录','记录生活中的点点滴滴','0','0','1');

DROP TABLE IF EXISTS fb_comment;

CREATE TABLE `fb_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` mediumint(8) NOT NULL,
  `user_id` mediumint(8) NOT NULL,
  `user_name` varchar(60) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `home` varchar(50) NOT NULL,
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` int(10) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS fb_config;

CREATE TABLE `fb_config` (
  `key` varchar(50) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO fb_config (`key`,`value` ) VALUES ( 'blog_desc','Simple-Log是基于PHP+MySQL的开源博客系统。'),('blog_keyword','Simple-Log'),('blog_name','Simple-Log'),('cache_lifetime','24'),('comment_safe','0'),('comment_sort','1'),('domain','http://www.simple-log.com/'),('is_cache','0'),('is_reg','0'),('notice','博客通知信息'),('open_comment','0'),('pager_size','6'),('page_size','10'),('rewrite','0'),('template_name','default'),('tj','');

DROP TABLE IF EXISTS fb_link;

CREATE TABLE `fb_link` (
  `link_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `url` varchar(100) NOT NULL,
  `sort` mediumint(8) NOT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO fb_link (`link_id`,`title`,`desc`,`url`,`sort` ) VALUES ( '1','Simple-Log','Simple-Log官方网站','http://www.simple-log.com','1');

DROP TABLE IF EXISTS fb_modules;

CREATE TABLE `fb_modules` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `module_id` varchar(30) NOT NULL,
  `title` varchar(100) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `sort` mediumint(5) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `plugin_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

INSERT INTO fb_modules (`id`,`module_id`,`title`,`desc`,`content`,`sort`,`type`,`plugin_id` ) VALUES ( '1','sysnav','系统导航','系统导航','{insert name=\'member_info\'}','1','1',''),('2','cat','日志分类','日志分类，系统自带模块','        &lt;ul&gt;\r\n		{foreach from=$cat item=cat_val}\r\n			&lt;li&gt;&lt;a href={$cat_val.url} title={$cat_val.cat_desc}&gt;{$cat_val.cat_name}&lt;/a&gt;&lt;/li&gt;\r\n			{if $cat_val.children}\r\n     		  	{foreach from=$cat_val.children item=children}\r\n     		  	&lt;li class=&quot;children&quot;&gt;&lt;a href={$children.url} title={$children.cat_desc}&gt;{$children.cat_name}&lt;/a&gt;&lt;/li&gt;\r\n      		    {/foreach}\r\n  			{/if}\r\n		{/foreach}\r\n		&lt;/ul&gt;','2','1',''),('3','search','搜索','网站搜索，系统自带模块','          &lt;form  method=&quot;get&quot; action=&quot;{$domain}search.php&quot;&gt;\r\n			&lt;input type=&quot;text&quot; name=&quot;s&quot;  size=&quot;10&quot; /&gt;\r\n			&lt;input name=&quot;submit&quot; type=&quot;submit&quot; tabindex=&quot;5&quot; value=&quot;搜索&quot; /&gt;\r\n  		  &lt;/form&gt;','3','1',''),('4','archives','日志归档','日志文件归档，系统自带模块','		&lt;ul&gt;\r\n		{foreach from=$archives item=archives_val key=key}\r\n			&lt;li&gt;&lt;a href={$archives_val.url}&gt;{$archives_val.data}&lt;/a&gt;&lt;/li&gt;\r\n		{/foreach}\r\n		&lt;/ul&gt;','4','1',''),('5','feed','网站订阅','网站订阅，系统自带模块','		&lt;ul&gt;\r\n         &lt;li&gt;&lt;a href=&quot;http://fusion.google.com/add?feedurl={$feed_url}&quot; target=&quot;_blank&quot;&gt;&lt;img border=&quot;0&quot; src=&quot;{$domain}images/icon_subshot02_google.gif&quot; alt=&quot;google reader&quot; vspace=&quot;2&quot; style=&quot;margin-right:8px;&quot; &gt;&lt;/a&gt;&lt;/li&gt;\r\n    	&lt;li&gt;&lt;a href=&quot;http://www.zhuaxia.com/add_channel.php?url={$feed_url}&quot; target=&quot;_blank&quot;&gt;&lt;img border=&quot;0&quot; src=&quot;{$domain}images/icon_subshot02_zhuaxia.gif&quot; alt=&quot;&amp;#25235;&amp;#34430;&quot; vspace=&quot;2&quot; &gt;&lt;/a&gt;&lt;/li&gt;\r\n    	&lt;li&gt;&lt;a href=&quot;http://reader.yodao.com/#url={$feed_url}&quot; target=&quot;_blank&quot;&gt;&lt;img border=&quot;0&quot; src=&quot;{$domain}images/icon_subshot02_youdao.gif&quot; alt=&quot;&amp;#26377;&amp;#36947;&quot; vspace=&quot;2&quot; &gt;&lt;/a&gt;&lt;/li&gt;\r\n    	&lt;li&gt;&lt;a href=&quot;http://www.pageflakes.com/subscribe.aspx?url={$feed_url}&quot; target=&quot;_blank&quot;&gt;&lt;img border=&quot;0&quot; src=&quot;{$domain}images/icon_subshot02_pageflakes.gif&quot; alt=&quot;pageflakes&quot; vspace=&quot;2&quot; style=&quot;margin-right:8px;&quot; &gt;&lt;/a&gt;&lt;/li&gt;\r\n    	&lt;li&gt;&lt;a href=&quot;http://add.my.yahoo.com/rss?url={$feed_url}&quot; target=&quot;_blank&quot;&gt;&lt;img border=&quot;0&quot; src=&quot;{$domain}images/icon_subshot02_yahoo.gif&quot; alt=&quot;my yahoo&quot; vspace=&quot;2&quot; &gt;&lt;/a&gt;&lt;/li&gt;\r\n		&lt;/ul&gt;','5','1',''),('6','link','友情链接','友情链接，系统自带模块','        &lt;ul&gt;\r\n		{foreach from=$link_list item=link}\r\n			&lt;li&gt;&lt;a href={$link.url} title={$link.desc}&gt;{$link.title}&lt;/a&gt;&lt;/li&gt;\r\n		{/foreach}\r\n		&lt;/ul&gt;','6','1',''),('7','','首页','','index.php','1','2',''),('8','new_article','最新文章','在边栏显示最新文章','\r\n        &lt;ul&gt;\r\n		{foreach from=$new_article item=new_article_val}\r\n			&lt;li&gt;&lt;a href={$new_article_val.url} title={$new_article_val.title}&gt;{$new_article_val.title}&lt;/a&gt;&lt;/li&gt;\r\n		{/foreach}\r\n		&lt;/ul&gt;','10','1','new_article');

DROP TABLE IF EXISTS fb_page;

CREATE TABLE `fb_page` (
  `page_id` int(10) NOT NULL AUTO_INCREMENT,
  `relate_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `add_time` int(10) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `status` int(1) NOT NULL,
  `type` int(1) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS fb_plugins;

CREATE TABLE `fb_plugins` (
  `plugin_id` varchar(50) NOT NULL,
  `plugin_name` varchar(60) NOT NULL,
  `plugin_desc` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `plugin_point` tinyint(1) NOT NULL,
  `cp_type` tinyint(1) NOT NULL,
  `add_time` int(10) NOT NULL,
  PRIMARY KEY (`plugin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO fb_plugins (`plugin_id`,`plugin_name`,`plugin_desc`,`author`,`version`,`plugin_point`,`cp_type`,`add_time` ) VALUES ( 'new_article','最新文章','在边栏显示最新文章','pengwenfei','1.0','1','0','1302985854');

DROP TABLE IF EXISTS fb_tags;

CREATE TABLE `fb_tags` (
  `tag_id` int(10) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(100) NOT NULL,
  `blog_id` mediumint(8) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS fb_user;

CREATE TABLE `fb_user` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(60) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL,
  `group_id` smallint(4) NOT NULL,
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_time` int(10) NOT NULL,
  `reg_ip` varchar(15) NOT NULL,
  `last_ip` varchar(15) NOT NULL DEFAULT '',
  `visit_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `msn` varchar(60) NOT NULL,
  `qq` varchar(20) NOT NULL,
  `home` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS fb_user_group;

CREATE TABLE `fb_user_group` (
  `group_id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(60) NOT NULL,
  `admin_privilege` text NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO fb_user_group (`group_id`,`group_name`,`admin_privilege` ) VALUES ( '1','管理员','all'),('2','注册会员',''),('3','游客','');

