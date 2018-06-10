<?php
	require_once "header.php";
	if($value!=1)
		die();

	if(isset($_GET['add']))
	{
		echo <<<_end
		<form action="collage_admin.php" method="post">
		名称：<input type="text" name="name"><br>
		描述：<input type="text" name="exits"><br>
		<input type="submit" name="sure" value="添加">
		<input type="submit" name="cancel" value="取消">
		</form>
_end;
		die();
	}
	if(isset($_POST['sure']))
	{
		$name=sanitizeString($_POST['name']);
		$exits=sanitizeString($_POST['exits']);
		Querymysql("insert into collage_inforation values(null,'$name','$exits',0)");
	}

	if(isset($_GET['view']))
	{
		$id=sanitizeString($_GET['view']);
		echo "<a href='stu_add.php?id=$id'> 添加学生</a>  <a href='stu_add_quick.php?id=$id'>快速添加</a><br>";
		$result=Querymysql("select * from stu_infor ");
		for($i=0;$i<$result->num_rows;$i++)
		{
			$row=$result->fetch_array();
			$number=$row['stu_num'];
			$name=$row['name'];
			$gender=$row['gender'];
			$coll_info=$row['coll_info']; 
			$maj_infor=$row['maj_infor'];
			echo <<<_end
			<a>$number</a> 姓名：$name 性别：$gender 学院：$coll_info 专业：$maj_infor <br> 
_end;
		
		}
		die("</body></html>");
	}
	
	echo "<a href=collage_admin.php?add=1>添加单位</a><br><br>";
	$result = Querymysql("select * from collage_inforation");

	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		echo "<a href='collage_admin.php?view=".$row['id']."'>".$row['name']."</a><br>"."描述：".$row['exits']."<br>人数：".$row['number']."<br>";
		$id = $row['id'];
		echo <<<_end
		<form action="collage_change.php" method="post">
		<input type="submit" value="修改" name="xiugai" >
		<input type="submit" value="删除" name="shanchu"> 
		<input type="hidden" value="$id" name="erase">
		</form><br>
_end;

	}

?>
</body>
</html>
