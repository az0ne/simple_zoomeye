<?php

$type=1;				//1表示边栏模块
$id='search';			//id为该模块唯一标识

$modules['search']['title']='搜索';
$modules['search']['desc']='网站搜索，系统自带模块';
$modules['search']['content']='
          <form  method="get" action="{$domain}search.php">
			<input type="text" name="s"  size="10" />
			<input name="submit" type="submit" tabindex="5" value="搜索" />
  		  </form>';
?>