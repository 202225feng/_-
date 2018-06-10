<?php  
	require_once "header.php";

	if(isset($_GET['cid']))
		$cour_id=sanitizeString($_GET['cid']);
	else
		die();
	if(isset($_GET['add']))
	{
		$ping_name=sanitizeString($_GET['name']);
		$ping_exits=sanitizeString($_GET['text']);
		$begin_time=sanitizeString($_GET['btime']);
		$end_time=sanitizeString($_GET['etime']);
		$query="insert into ping_eachother(id,begin_time,end_time,name,exits,cour_num) values(null,'$begin_time','$end_time','$ping_name','$ping_exits','$cour_id')";
		//echo $query;
		Querymysql($query);
		$result=Querymysql("select * from ping_eachother where name='$ping_name' and exits='$ping_exits' and begin_time='$begin_time' and end_time='$end_time' ");
		$row=$result->fetch_array();
		$ping_id=$row['id'];
		$dir = iconv("UTF-8", "GBK", "course/$cour_id/$ping_id-ping");
		 mkdir ($dir,0777,true);
		echo "OK<a href='ping_each.php?viewc=$cour_id'>返回</a>";
		die("</body></html>");
	}
	//echo $cour_id;
	echo <<<_end
<form action='ping_add.php' method='get'>
名称：<input type="text" name="name" required><br>
描述：<textarea name='text' cols='50' rows='3'></textarea><br>
上传作业截止/互评开始时间：<input type="datetime-local" name="btime" required><br>
互评截止时间：<input type="datetime-local" name="etime" required><br>
<input type="hidden" name="cid" value="$cour_id">
<button type='submit' name='add' value='添加'>添加</button>
</form>
_end;
?>
