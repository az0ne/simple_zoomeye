function check_all(box,type)
{
	var check_box = document.getElementsByTagName(box);
	var length = check_box.length;
	
	//通过type判断类型，并循环选取或取消按钮中的元素
	for (var i = 0; i < length ; i++ )
	{
		type==1?check_box[i].checked = true:check_box[i].checked = false;
	}
}