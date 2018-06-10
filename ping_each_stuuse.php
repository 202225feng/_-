<?php
	require_once "header.php";

	if(isset($_GET['viewc']))
	{
		$today = date('Y/m/d\ H:i:s');
		$cour_id=sanitizeString($_GET['viewc']);
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
				echo "<tr><td><a href='ping_stuuse_submit.php?viewc=$cour_id&viewp=$ping_id'>$ping_name</a></td><td>提交作业中</td><td>$b_time</td><td>$ping_exits</td></tr>";
			}
			else 
			{
				$e_time=$row['end_time'];
				if((strtotime($e_time)-strtotime($today))>0)
				{
					echo "<tr><td><a href='ping_stuuse_vote.php?viewc=$cour_id&viewp=$ping_id'>$ping_name</a></td><td>互评中</td><td>$e_time</td><td>$ping_exits</td></tr>";
				}
				else
				{
					echo "<tr><td>$ping_name</td><td>结束</td><td>$e_time></td><td>$ping_exits</td></tr>";
				}
			}
		}
		die("</table></body></html>");
	}

	$result=Querymysql("select * from stu_cour where stu_num='$user' and status=1");
	echo "<table border><tr><th>课程</th></tr>";
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$cour_num=$row['cour_num'];
		$result1=Querymysql("select * from cour_info where cour_num='$cour_num'");
		$row1=$result1->fetch_array();
		$cour_name=$row1['cour_name'];
		echo "<tr><td><a href='ping_each_stuuse.php?viewc=$cour_num'>$cour_name</a></td></tr>";
	}
?>