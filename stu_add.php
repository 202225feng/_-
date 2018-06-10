<?php
	require_once "header.php";
	if($value!=1)die();

	if(isset($_GET['id']))
	$id=sanitizeString($_GET['id']);
	else die();

	$error="";
	if(isset($_GET['sure']))
	{
		$number=$pass=$pass1=$name=$gender=$collag=$maj='';
		$number=sanitizeString($_GET['number']);
		$name=sanitizeString($_GET['name']);
		$gender=sanitizeString($_GET['gender']);
		$collag=sanitizeString($_GET['collag']);
		$maj=sanitizeString($_GET['maj']);
		if(strlen($number)!=10)
			$error="学号长度不合法";
		else
		{
			
				$result=Querymysql("select * from stu_infor where stu_num='$number'");
				if(!$result->num_rows)
				{
					$pass="@a@"+"1234"+"&asd";
					$pass=hash("sha256",$pass);
					$result=Querymysql("select * from collage_inforation where id='$id'");
					$row=$result->fetch_array();
					$num=$row['number'];
					$num++;
					Querymysql("update collage_inforation set number='$num' where id=$id");
					Querymysql("insert into stu_infor(stu_num,name,pass,gender,school,major,phonenum) values('$number','$name','$pass','$gender','$collag','$maj',$id)");
					
					$error="$number 已经添加";
				}
				else
					$error="该学号学生已存在";
			
		}
	}

	echo <<<_END
	$error<br>
	<form method="get" action="stu_add.php?id='$id'">
	学号：<input type="text" name="number" required="required"><br>
	姓名：<input type="text" name="name"><br>
	性别：<input type="radio" name="gender" checked value="女">女<input type="radio" name="gender" value="男">男<br>
	学院：<input type="text" name="collag"><br>
	专业：<input type="text" name="maj"><br>
	<input type="hidden" name="id" value="$id">
	<input type="submit" name="sure" value="添加">
	</form>
	<a href='collage_admin.php'>返回</a><br>
_END;

?>
</body>
</html>
