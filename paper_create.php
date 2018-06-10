<?php
	require_once "header.php";

	if(isset($_POST['add']))
	{
		$cour_id=sanitizeString($_POST['cid']);
		$cour_name=sanitizeString($_POST['cname']);
		$adm_tea=sanitizeString($_POST['atea']);
		$p_name=sanitizeString($_POST['name']);
		$time=date('Y/m/d\ H:i:s');
		Querymysql("insert into paper(id,cour_num,admin_tea,paper_name,time) values(null,'$cour_id','$adm_tea','$p_name','$time')");
		echo "OK<a href='paper_admin.php?viewc=$cour_id&cname=$cour_name'>返回</a> ";
		die("</body></html>");
	}
	if(isset($_GET['cid'])&&isset($_GET['cname']))
	{
		$cour_id=sanitizeString($_GET['cid']);
		$cour_name=sanitizeString($_GET['cname']);
	}
	else die();
	echo <<<_end
<form action="paper_create.php" method="post">
试卷名称：<input type="text" name="name"><br>
管理人员：<select name="atea">
_end;
	$result=Querymysql("select * from teacher_info");
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$tea_user=$row['tea_user'];
		$tea_name=$row['tea_name'];
		echo "<option value='$tea_user'>$tea_name</option>";
	}
	echo <<<_end
</select><br>
所属课程：$cour_name<br>
<input type="hidden" value="$cour_name" name="cname">
<input type="hidden" value="$cour_id" name="cid">
<input type="submit" value="添加" name="add">
</form>
_end;
?>


