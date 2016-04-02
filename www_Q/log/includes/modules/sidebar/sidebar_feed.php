<?php

$type=1;				//1表示边栏模块
$id='feed';			//id为该模块唯一标识

$modules['feed']['title']='网站订阅';
$modules['feed']['desc']='网站订阅，系统自带模块';
$modules['feed']['content']='
		<ul>
         <li><a href="http://fusion.google.com/add?feedurl={$feed_url}" target="_blank"><img border="0" src="{$domain}images/icon_subshot02_google.gif" alt="google reader" vspace="2" style="margin-right:8px;" ></a></li>
    	<li><a href="http://www.zhuaxia.com/add_channel.php?url={$feed_url}" target="_blank"><img border="0" src="{$domain}images/icon_subshot02_zhuaxia.gif" alt="&#25235;&#34430;" vspace="2" ></a></li>
    	<li><a href="http://reader.yodao.com/#url={$feed_url}" target="_blank"><img border="0" src="{$domain}images/icon_subshot02_youdao.gif" alt="&#26377;&#36947;" vspace="2" ></a></li>
    	<li><a href="http://www.pageflakes.com/subscribe.aspx?url={$feed_url}" target="_blank"><img border="0" src="{$domain}images/icon_subshot02_pageflakes.gif" alt="pageflakes" vspace="2" style="margin-right:8px;" ></a></li>
    	<li><a href="http://add.my.yahoo.com/rss?url={$feed_url}" target="_blank"><img border="0" src="{$domain}images/icon_subshot02_yahoo.gif" alt="my yahoo" vspace="2" ></a></li>
		</ul>';
?>