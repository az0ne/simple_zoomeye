<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2010-02-16
 * www.simple-log.com 
*/
function process_text($str)
{
	$str=htmlspecialchars($str);
	$str=str_replace(' ','&nbsp;',$str);
	$str=str_replace(array("\r\n", "\n"), array('<br />', '<br />'),$str);
	return $str;
}

function unprocess_text($str)
{
	$str=htmlspecialchars_decode($str);
	$str=str_replace('&nbsp;',' ',$str);
	$str=str_replace('<br />', "\r\n",$str);
	return $str;
}

function pbtime($dateline){
	return date('Y-m-d H:i:s',$dateline);
}

function isset_member($member)
{
	$sql='SELECT * FROM '.table('user')." WHERE user_name='".$member."'";
	if ($GLOBALS['db']->getrow($sql))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function isset_group($group)
{
	$sql='SELECT * FROM '.table('user_group')." WHERE group_name='".$group."'";
	if ($GLOBALS['db']->getrow($sql))
	{
		return true;
	}
	else
	{
		return false;
	}
}


function pbsubstr($Str, $Length) {
	global $s;
	$i = 0;
	$l = 0;
	$ll = strlen($Str);
	$s = $Str;
	$f = true;

	while ($i <= $ll) {
		if (ord($Str{$i}) < 0x80) {
			$l++; $i++;
		} else if (ord($Str{$i}) < 0xe0) {
			$l++; $i += 2;
		} else if (ord($Str{$i}) < 0xf0) {
			$l += 2; $i += 3;
		} else if (ord($Str{$i}) < 0xf8) {
			$l += 1; $i += 4;
		} else if (ord($Str{$i}) < 0xfc) {
			$l += 1; $i += 5;
		} else if (ord($Str{$i}) < 0xfe) {
			$l += 1; $i += 6;
		}

		if (($l >= $Length - 1) && $f) {
			$s = substr($Str, 0, $i);
			$f = false;
		}

		if (($l > $Length) && ($i < $ll)) {
			$s = $s . '...'; break; //如果进行了截取，字符串末尾加省略符号“...”
		}
	}
	return $s;
}


function get_tags($id)
{
	$tags='';
	$sql='SELECT tag_name FROM '.table('tags')." WHERE blog_id='".$id."'";
	$tags_list=$GLOBALS['db']->getall($sql);
	$num=count($tags_list)-1;
	foreach ($tags_list as $key=>$val)
	{
		$tags.="<a href=\"".build_url('tag',$val['tag_name'])."\" title=\"$val[tag_name]\" >$val[tag_name]</a>".($num==$key?'':',');
	}
	return $tags;
}

?>