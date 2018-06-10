<?php
	require_once "header.php";

	if(isset($_GET['viewp'])&&isset($_GET['viewc']))
	{
		$cour_id=sanitizeString($_GET['viewc']);
		$ping_id=sanitizeString($_GET['viewp']);

		$result=Querymysql("select * from stu_cour where cour_num='$cour_id' and status=1");
		echo "<table border><tr><th>学号</th><th>姓名</th><th>作业</th><th>提交时间</th><th>评分</th><th>评分时间</th></tr>";
		for($i=0;$i<$result->num_rows;$i++)
		{
			$row=$result->fetch_array();
			$stu_num=$row['stu_num'];
			$result1=Querymysql("select * from stu_infor where stu_num='$stu_num'");
			$row=$result1->fetch_array();
			$stu_name=$row['name'];
			echo "<tr><td>$stu_num</td><td>$stu_name</td>";
			$result1=Querymysql("select * from ping_sub where stu_num='$stu_num' and ping_id='$ping_id' and status=1");

			if($result1->num_rows)
			{
				$row=$result1->fetch_array();
				$name=$row['name'];
				$z_id=$row['id'];
				$z_url=$row['work_url'];
				$s_date=$row['sub_date'];
				echo "<td><a href='download1.php?view=$z_id'>$name($z_id)</a></td><td>$s_date</td>";
			}
			else
				echo "<td>未提交</td><td>未提交</td>";
			$result1=Querymysql("select * from ping_fen where stu_num='$stu_num' and ping_id='$ping_id' and status=1 ");
			if($result1->num_rows){
				$row=$result1->fetch_array();
				$first=$row['first_id'];
				$second=$row['second_id'];
				$third=$row['third_id'];
				$p_date=$row['pin_date'];
				echo "<td>第一名：$first 第二名：$second 第三名：$third </td><td>$p_date</td></tr>";
			}
			else
				echo "<td>未评分</td><td>未评分</td></tr>";

		}
		echo "</table><a href='ping_count.php?pid=$ping_id&cid=$cour_id'>查看结果</a>";
		die("</body></html>");
	}

	if(isset($_GET['viewc']))
	{
		$cour_id=sanitizeString($_GET['viewc']);
		$today = date('Y/m/d\ H:i:s');
		echo "<a href='ping_add.php?cid=$cour_id'>添加互评</a><br><br>";
		$result=Querymysql("select * from ping_eachother where cour_num='$cour_id'");
		echo "<table border><tr><th>作业</th><th>状态</th><th>截止时间</th><th>描述</th></tr>";
		for($i=0;$i<$result->num_rows;$i++)
		{
			$row=$result->fetch_array();
			$ping_id=$row['id'];
			$ping_name=$row['name'];
			$ping_exits=$row['exits'];
			$b_time=$row['begin_time'];
			if((strtotime($b_time)-strtotime($today))>0)
			{
				echo "<tr><td><a href='ping_each.php?viewc=$cour_id&viewp=$ping_id'>$ping_name</a></td><td>提交作业中</td><td>$b_time</td><td>$ping_exits</td></tr>";
			}
			else 
			{
				$e_time=$row['end_time'];
				if((strtotime($e_time)-strtotime($today))>0)
				{
					echo "<tr><td><a href='ping_each.php?viewc=$cour_id&viewp=$ping_id'>$ping_name</a></td><td>互评中</td><td>$e_time</td><td>$ping_exits</td></tr>";
				}
				else
				{
					echo "<tr><td><a href='ping_each.php?viewc=$cour_id&viewp=$ping_id'>$ping_name</a></td><td>结束</td><td>$e_time></td><td>$ping_exits</td></tr>";
				}
			}

		}
		die("</table></body></html>");
	}

	$result=Querymysql("select * from cour_info");
	echo "<table border><tr><th>课程名称</th></tr>";
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$cour_num=$row['cour_num'];
		$cour_name=$row['cour_name'];
		echo "<tr><td><a href='ping_each.php?viewc=$cour_num'>$cour_name</a></td></tr>";
	}
	echo "</table>";
?>
</body></html>