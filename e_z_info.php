<?php
	require_once "header.php";
	$e_id=sanitizeString($_GET['viewe']);
	//echo $e_id;
	$result=Querymysql("select * from exam where id='$e_id'");
	if($result->num_rows)
	{
		$row=$result->fetch_array();
		echo "<center><h3>".$row['name']."</h3>";
		echo "开始时间：".$row['begin_date']." 结束时间：".$row['end_date']."<br>";
		$result=Querymysql("select * from exam_paper where ex_id='$e_id'");
		echo "试卷：";
		$paper_num=$result->num_rows;
		for($i=0;$i<$result->num_rows;$i++)
		{
			$row=$result->fetch_array();
			echo "<a href=''>".$row['paper_name']."</a> ";
		}
		echo "<br><button>综合统计</button> <button>指定试卷</button> <button>得分最高试卷</button></center>";
		$result=Querymysql("select user,sum(fen) sf,sum(timeuse) st,sum(z_fen) zf from exam_read where e_id=7 group by user order by sum(fen) desc");
		echo "<div id='exam_info'>";
		echo "<table><tr><th>考生</th><th>总分</th><th>总耗时</th><th></th></tr>";
		for($i=0;$i<$result->num_rows;$i++)
		{	
			$row=$result->fetch_array();
			$u_id=$row['user'];
			$result1=Querymysql("select * from stu_infor where stu_num='$u_id'");
			$row1=$result1->fetch_array();
			$u_name=$row1['name'];
			echo "<tr><td><button onclick='show_e_info($u_id,$e_id)'>".$u_name."</button></td><td>".$row['sf']."/".$row['zf']."</td><td>".$row['st']."</td><td>详情</td></tr>";
		}
		echo "</div>";
		
	}
?>