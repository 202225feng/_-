<?php 
	require_once "header.php";
	if(!isset($_SESSION['cour_id_add']))
		header("Location:course_admin.php");
	$id=sanitizeString($_SESSION['cour_id_add']);

		echo "<a href='course_admin.php'>返回</a><br>";
		$result=Querymysql("select * from cour_info where cour_num='$id'");
		$row=$result->fetch_array();
		$cour_name=$row['cour_name'];
		echo "<center><h3>$cour_name 参加人员信息</h3>";
		//echo "<a href='stu_add_cour.php'>添加学生</a> <a href='stu_add_cour_quick.php'>快速导入学生</a><br><br></center>";
		$result= Querymysql("select * from stu_cour where cour_num='$id' and status=1 ");
		echo "<table border><tr><th>姓名</th><th>电话 </th><th>专业</th></tr>";
		for($i=0;$i<$result->num_rows;$i++)
		{
			$row=$result->fetch_array();
			$stu_num=$row['stu_num'];
			$result1=Querymysql("select * from stu_infor where stu_num='$stu_num'");
			$row1=$result1->fetch_array();
			$stu_name=$row1['name'];
			$phonenum=$row1['phonenum'];
			$collage=$row1['major'];
			echo "<tr><th>$stu_name</th><th>$phonenum</th><th>$collage</th></tr>";
		}
		echo "</table>";
	
?>