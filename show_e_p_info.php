<?php
	require_once "function.php";
	if(isset($_POST['viewe'])&&isset($_POST['viewu']))
	{
		$e_id=sanitizeString($_POST['viewe']);
		$u_id=sanitizeString($_POST['viewu']);
	}

	$result=Querymysql("select * from stu_infor where stu_num='$u_id'");
		if($result->num_rows)
		{
			$row=$result->fetch_array();
			echo "姓名:".$row['name']."<br>";
			echo "性别:".$row['gender']."<br>";
			echo "学校:".$row['school']."<br>";
			echo "专业:".$row['major']."<br>";
			echo "电话:".$row['phonenum']."<br>";
			echo "学历:".$row['degree']."<br>";
		}
		echo "<br>历史答卷";
		$result=Querymysql("select * from exam_read where user='$u_id'");
		for($i=0;$i<$result->num_rows;$i++)
		{
			$row=$result->fetch_array();
			$p_id=$row['p_id'];
			$result1=Querymysql("select * from paper where id='$p_id'");
			$row1=$result1->fetch_array();
			echo "试卷：".$row1['paper_name']."<br>总分:".$row['fen']."/".$row['z_fen']."<br>总耗时:".$row['timeuse']."<br>面试管评价:".$row['pingjia']."<br><br>";
		}
		//echo "<a href='e_p_info.php?viewe=$e_id'>返回</a>";
		die("</body></html>");
?>