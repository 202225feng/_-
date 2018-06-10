<?php
	require_once "header.php";

	if(!isset($_SESSION['cour_id']))
		header("Location:course_admin.php");
	$id=sanitizeString($_SESSION['cour_id']);
	
		if(isset($_POST['sure']))
		{
			$cour_name=sanitizeString($_POST['name']);
			$collage=sanitizeString($_POST['collage']);
			//$term=sanitizeString($_POST['term']);
			Querymysql("update cour_info set cour_name ='$cour_name',collage='$collage' where cour_num='$id' ");
			$teacher_user=sanitizeString($_POST['teacher']);
			$result = Querymysql("select tea_name from teacher_info where tea_user='$teacher_user' ");
			$row=$result->fetch_array();
			$teacher_name=$row['tea_name'];
			$result1=Querymysql("select * from teacher_cour where cour_num=$id and class=1");
			if($result1->num_rows)
				Querymysql("update teacher_cour set tea_user='$teacher_user',tea_name='$teacher_name' where cour_num='$id' and class=1");
			else
				Querymysql("insert into teacher_cour(id,tea_user,tea_name,cour_num,class,status,cour_name) values(null,'$teacher_user','$teacher_name',$id,1,1,'$cour_name')");
			$_SESSION['cour_id']=null;
			header("Location:course_admin.php");
			//if(isset($_POST['teacherp'])
			
		}
		if(isset($_POST['cancle']))
		{
			$_SESSION['cour_id']=null;
			header("Location:course_admin.php");
		}

		$result=Querymysql("select * from cour_info where cour_num='$id'");
		$row=$result->fetch_array();
		$cour_name=$row['cour_name'];
		$collage=$row['collage'];
		$term=$row['term'];
		$result=Querymysql("select * from teacher_cour where cour_num='$id' and class=1 and status=1");
		$teacher_user = array();
		$teacher_name = array();
		for($i=0;$i<$result->num_rows;$i++)
		{
			$row=$result->fetch_array();
			$teacher_user[$i]=$row['tea_user'];
			$teacher_name[$row['tea_user']]=$row['tea_name'];
		}
		
		
echo <<<_end
<form action="course_change.php" method="post">
课程名称：<input type="text" name="name" value='$cour_name'><br>
group描述：<input type="text" name="collage" value='$collage'><br>
_end;
echo "面试官：";
	foreach($teacher_user as $item)
	{	
		echo " <input type='radio' value='$item' name='teacher' checked>$item($teacher_name[$item]) " ;
	}

$result=Querymysql("select * from teacher_info where class=2");
for($i=0;$i<$result->num_rows;$i++)
{
	$row=$result->fetch_array();
	$teacher_user1=$row['tea_user'];
	$teacher_name1=$row['tea_name'];
	if(!isset($teacher_user[0])||$teacher_user1!=$teacher_user[0])
	{
		echo "<input type='radio' value='$teacher_user1' name='teacher' >$teacher_user1($teacher_name1 )";
	}
}

echo "<br><input type='submit' value='确定' name='sure'> ".
	" <input type='submit' value='取消' name='cancle'> ";
echo "</form>";


	
?>
