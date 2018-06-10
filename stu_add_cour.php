<?php 
	require_once "header.php";
	if(!isset($_SESSION['cour_id_add']))
		header("Location:course_admin.php");
	$id=sanitizeString($_SESSION['cour_id_add']);
	//echo $id;
	
		$error='';
		if(isset($_POST['sure']))
		{
			$stu_num=sanitizeString($_POST['stu_num']);
			$result=Querymysql("select * from stu_infor where stu_num='$stu_num'");
			if($result->num_rows)
			{
				$result= Querymysql("select * from stu_cour where stu_num='$stu_num' and cour_num='$id'");
				if(!$result->num_rows)
				Querymysql("insert into stu_cour values(null,'$stu_num','$id',1)");
				$error="$stu_num 已经添加";
			}
			else
				$error="$stu_num 不存在该学生";
		}
		
echo <<<_end
$error<br>
<form action="stu_add_cour.php" method="post">
学号：<input type="text" name="stu_num" required><br>
<input type="submit" name="sure" value="添加">
</form>
<a href="stu_info_cour.php">返回</a>
_end;

	
?>
