<?php
	require_once "header.php";
	define("FIRST_SCORE",10);
	define("SECOND_SCORE",7);
	define("THIRD_SCORE",5);
	define("TP_SCORE",2);
	if(isset($_GET['pid'])&&isset($_GET['cid']))
	{
		$cour_id=sanitizeString($_GET['cid']);
		$ping_id=sanitizeString($_GET['pid']);
	}
	else die();
	$result=Querymysql("select * from stu_cour where cour_num='$cour_id'");
	$student=array();
	$zp_defen=array();
	$stushuliang=$result->num_rows;
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$stu_num=$row['stu_num'];
		$result1=Querymysql("select * from stu_infor where stu_num='$stu_num'");
		$row=$result1->fetch_array();
		$stu_name=$row['name'];
		$student["$stu_num"]=array('name'=>"$stu_name");
		$result1=Querymysql("select * from ping_sub where ping_id='$ping_id' and stu_num='$stu_num' and status=1");
		if($result1->num_rows){
			$row=$result1->fetch_array();
			$z_id=$row['id'];
			$ping_url=$row['work_url'];
			$ping_name=$row['name'];
			$student["$stu_num"]["zp_id"]=$z_id;
			//echo "zid:".$z_id."<br>";
			$zp_defen["$z_id"]=0;
			$student["$stu_num"]["p_name"]=$ping_name;
			$student["$stu_num"]['url']=$ping_url;
			$student["$stu_num"]["sub_tf"]=1;
			//echo "string";
		}
		else
		{
			$student["$stu_num"]["sub_tf"]=0;
		}
		$result1=Querymysql("select * from ping_fen where ping_id='$ping_id' and stu_num='$stu_num' and status=1");
		if($result1->num_rows){
			$row=$result1->fetch_array();
			$first=$row['first_id'];
			$second=$row['second_id'];
			$third=$row['third_id'];
			$student["$stu_num"]["first"]=$first;
			$student["$stu_num"]["second"]=$second;
			$student["$stu_num"]["third"]=$third;
			$student["$stu_num"]["fen_tf"]=1;
		}
		else
		{
			$student["$stu_num"]["fen_tf"]=0;
		}
		//echo $stu_num.":".$student["$stu_num"]["fen_tf"]."<br>";
		$student["$stu_num"]["zp_fen"]=0;
		$student["$stu_num"]['tp_fen']=0;
	}
	$top_3=array();
	$i=0;
	foreach ($student as $key => $value) {
		//echo $key." ".$value['fen_tf']."<br>";
		if($value['fen_tf'])
		{
			$first=$value['first'];
			$zp_defen["$first"]+=FIRST_SCORE;
			$second=$value['second'];
			$zp_defen["$second"]+=SECOND_SCORE;
			$first=$value['third'];
			$zp_defen["$first"]+=THIRD_SCORE;
		}
	}
	foreach ($student as $key => $value) {
		if($value["sub_tf"])
		{
			$z_id=$value['zp_id'];
			$score=$zp_defen["$z_id"];
			$query="insert into ping_result_one(id,ping_id,z_id,score,stu_num,status) values(null,'$ping_id','$z_id','$score','$key','1')";			
		}
		else
		{
			$query="insert into ping_result_one(id,ping_id,z_id,score,stu_num,status) value(null,'$ping_id','','0','$key','0')";
		}
		echo $query."<br>";
		Querymysql($query);
	}
	$result=Querymysql("select * from ping_result_one where ping_id='$ping_id' order by score desc");
	for($i=0;$i<$result->num_rows&&$i<3;$i++)
	{
		$row=$result->fetch_array();
		$stu_num=$row['stu_num'];
		$score=$row['score'];
		$z_id=$row['z_id'];
		$top_3[$i]=array("stu"=>$stu_num,"score"=>$score,"zip"=>$z_id);
	}
	foreach ($student as $key => $value) {
		if($value['fen_tf'])
		{
			$first=$value['first'];
			
			for($j=0;$j<$i;$j++)
			{
				if($first==$top_3[$j]["zip"])
				{
					$student[$key]['tp_fen']+=TP_SCORE;
					break;
				}
			}
			$second=$value['second'];
			for($j=0;$j<$i;$j++)
			{
				if($second==$top_3[$j]["zip"])
				{
					$student[$key]['tp_fen']+=TP_SCORE;
					break;
				}
			}
			$third=$value['third'];
			for($j=0;$j<$i;$j++)
			{
				if($third==$top_3[$j]["zip"])
				{
					$student[$key]['tp_fen']+=TP_SCORE;
					break;
				}
			}
		}
			//echo $key.":".$value['tp_fen']."<br>";
	}
	foreach ($student as $key => $value) {
		$stu_num=$key;
		//echo $key.":".$value['tp_fen']."<br>";
		$score=$value['tp_fen'];
		$query="insert into ping_result_two(id,ping_id,stu_num,score) values(null,'$ping_id','$stu_num','$score')";
		echo $query."<br>";
		Querymysql($query);
	}
	$result= Querymysql("SELECT o.stu_num num,o.score os,t.score ts FROM ping_result_one o,ping_result_two t where o.ping_id=t.ping_id and o.stu_num=t.stu_num group by o.stu_num order by sum(o.score+t.score) DESC");
	echo "<table border><tr><th>学号</th><th>作品得分</th><th>投票得分</th><th>总分</th></tr>";
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$stu_num=$row['num'];
		$z_score=$row['os'];
		$t_score=$row['ts'];
		$score=$z_score+$t_score;
		echo "<tr><td>$stu_num</td><td>$z_score</td><td>$t_score</td><td>$score</td></tr>";
	}
	echo "</table>";
	echo $student['2016202225']['name'];
?>