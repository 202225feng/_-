<?php
	require_once "header.php";
	if(isset($_GET['viewe'])&&isset($_GET['viewu'])&&isset($_GET['viewp']))
	{
		$e_id=sanitizeString($_GET['viewe']);
		$p_id=sanitizeString($_GET['viewp']);
		$u_id=sanitizeString($_GET['viewu']);
	}
	else {
		header("Location:e_p_info.php");
		die();
	}
	$question=array();
	$result=Querymysql("select * from paper_ques where paper_id='$p_id' order by q_type");
	$q_num=$result->num_rows;
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$q_id=$row['q_id'];
		$result1=Querymysql("select * from question where id='$q_id'");
		$row1=$result1->fetch_array();
		$question[$i]=array();
		$question[$i]['id']=$q_id;
		$question[$i]['type']=$row1['types'];
		$question[$i]['ans']=$row1['answer'];
		$question[$i]['exit']=$row1['exits'];
	}
	$timeuse=0;
	$cor_num=0;
	$z_fen=0;
	$fen=0;
	$ft1=0;
	$ft2=0;
	$result=Querymysql("select * from e_p_fen where e_id='$e_id' and p_id='$p_id'");
	$tfen=array(0,0,0,0,0,0);
	if($result->num_rows)
	{
		$row=$result->fetch_array();
		for($i=1;$i<=5;$i++)
		{
			$tfen[$i]=$row["t".$i];
		}
	}
	echo <<<_end
	<form action="pp_fen_sub.php" method="post">
	<input type='hidden' value='$e_id' name='eid'>
	<input type='hidden' value='$p_id' name='pid'>
	<input type='hidden' value='$u_id' name='uid'>
_end;
	for($i=0,$j=1;$i<$q_num;$i++,$j++)
	{
		$query="select * from exam_ans where e_id='$e_id' and p_id='$p_id' and user='$u_id' and q_id='".$question[$i]['id']."'";
		$result=Querymysql($query);
		$q_type=$question[$i]['type'];
		echo "第".$j."题(".$tfen[$q_type]."分):".$question[$i]['exit']."<br>";
		echo "标准答案：".$question[$i]['ans']."<br>";
		if($result->num_rows)
		{
			$row=$result->fetch_array();
			echo "考生答案：".$row['ans']."<br>";
			echo "用时:".$row['timeuse']."<br>";
			echo "得分:";
			if($q_type==1||$q_type==2||$q_type==3)
			{
				if(strtolower($row['ans'])==strtolower($question[$i]['ans']))
				{
					$fen+=$tfen[$q_type];
					$cor_num++;
					$ft1+=$tfen[$q_type];
					echo "$tfen[$q_type]<input type='hidden' name='fen[]' value='$tfen[$q_type]'><br><br>";
				}
				else
					echo "0<input type='hidden' name='fen[]' value='0'><br><br>";
			}
			else
			{
				echo "<input type='text' name='fen[]' required> <br><br>";
			}
			$timeuse+=$row['timeuse'];
		}
		else{
			echo "考生答案：<font color='red'>未作答</font><br>";
			echo "得分:";
			echo "0<input type='hidden' name='fen[]' value='0'> <br><br>";
		}
		$z_fen+=$tfen[$q_type];
	}
	echo "<input type='hidden' value='$z_fen' name='zfen' ><input type='hidden' value='$ft1' name='fen1'>";
	echo "<input type='hidden' value='$timeuse' name='timeuse'>";
	echo "<textarea name='pingjia'>请在此处给出您的评价</textarea><br>";
	echo "<input type='submit' value='批阅完毕' name='sure'></form>";

?>