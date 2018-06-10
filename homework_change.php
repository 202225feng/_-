<?php
	require_once "header.php";
	if($value!=2) die();

	if(!isset($_SESSION['cour_id_hwork_ch']))
		header("Location:homework_admin.php");
	$id=$_SESSION['cour_id_hwork_ch'];

	if(isset($_POST['change']))
	{
		$name= sanitizeString($_POST['name']);
		$date=sanitizeString($_POST['datetime']);
		$class=sanitizeString($_POST['class']);
		Querymysql("update  course_homework set name='$name',end_date='$date',class='$class' where id='$id'");
		echo "OK";
	}

	$result=Querymysql("select * from course_homework where id='$id'");
	$row=$result->fetch_array();
	$hwork_name=$row['name'];
	$hwork_endat=$row['end_date'];
	$class=$row['class'];

echo <<<_end
<form method="post" action="homework_change.php">
作业名称：<input type="text" name="name" required value="$hwork_name"><br>
<input type="text" value="$hwork_endat"><br>
截止日期：<input type="datetime-local" name="datetime" required value="$hwork_endat"><br>
_end;
	if($class==1)
echo <<<_end
作业类型：<input type="radio" name="class" value=1 required checked>大作业
<input type="radio" name="class" value=2 required>实验作业
<input type="radio" name="class" value=3 required>普通作业<br>
_end;
	if($class==2)
echo <<<_end
作业类型：<input type="radio" name="class" value=1 required>大作业
<input type="radio" name="class" value=2 required checked>实验作业
<input type="radio" name="class" value=3 required>普通作业<br>
_end;
if($class==3)
echo <<<_end
作业类型：<input type="radio" name="class" value=1 required>大作业
<input type="radio" name="class" value=2 required>实验作业
<input type="radio" name="class" value=3 required checked>普通作业<br>
_end;
echo <<<_end
<input type="submit" name="change" value="提交">
</form>
<a href="homework_admin.php"> 返回</a>
_end;


?>
