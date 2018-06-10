<?php
	require_once "header.php";
	if(isset($_GET['viewe']))
		$e_id=sanitizeString($_GET['viewe']);
	else
		header("Location:exam_admin.php");

	if(isset($_GET['viewu']))
	{
		$u_id=sanitizeString($_GET['viewu']);
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
		echo "<a href='e_p_info.php?viewe=$e_id'>返回</a>";
		die("</body></html>");
	}
	$result=Querymysql("select * from exam where id='$e_id'");
	$row=$result->fetch_array();
	echo "<h3>".$row['name']."</h3>";
	$query="select * from stu_cour where cour_num='".$row['cour_num']."' and status=1";
	//echo "$query<br>";
	$result=Querymysql("select * from exam_paper where ex_id='$e_id'");
	echo "<table border><tr><th>姓名</th>";
	$paper=array();
	$paper_num=$result->num_rows;
	$flag=1;
	for($i=0,$j=0;$i<$paper_num;$i++)
	{
		$j++;
		echo "<th>试卷$j</th><th>批改</th>";
		$row=$result->fetch_array();
		$paper[$i]=array('id' => $row['pa_id'],'name' => $row['paper_name']);
	}
	echo "</tr>";
	$result=Querymysql($query);
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$u_num=$row['stu_num'];
		$result1=Querymysql("select * from stu_infor where stu_num='$u_num'");
		$row1=$result1->fetch_array();
		echo "<tr><td><a href='e_p_info.php?viewu=$u_num&viewe=$e_id'>".$row1['name']."</a></td>";
		for($j=0;$j<$paper_num;$j++)
		{
			$p_id=$paper[$j]['id'];
			echo "<td><a href='pp_info.php?viewe=$e_id&viewp=".$paper[$j]['id']."&viewu=$u_num'>".$paper[$j]['name']."</a></td>";
			$result2=Querymysql("select * from exam_read where e_id='$e_id' and user='$u_num' and p_id='$p_id'");
			if($result2->num_rows)
				echo "<td>是</td>";
			else
			{
				echo "<td>否</td>";
				$flag=0;
			}
		
		}
		echo "</tr>";
	}
	echo "</table>";
	//echo "<button onclick='trans($flag,$e_id)'>统计考试信息</button>";
	echo <<<_end
	     <div class="content">
            <div class="buttons">
                
                <div class="button" >
                    <a onclick='trans($flag,$e_id)'>统计考试信息</a>
                </div>
            </div>
        </div>

_end;
?>
</body></html>