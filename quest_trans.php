<?php
	require_once "function.php";

	if(isset($_POST['select']))
	$qsel=$_POST['select'];
	else die();

	$b_id=$_POST['sel_b'];
	$c_id=$_POST['sel_c'];
	$result=Querymysql("select * from question where id='$qsel[0]'");
	$row=$result->fetch_array();
	$cc_id=$row['cha_id'];
	if($cc_id!=$c_id)
	{		
		if(isset($_POST['copy']))
		{
			//echo "复制 题号：";
			$result=Querymysql("select * from qbase_chapter where id='$c_id'");
			$row=$result->fetch_array();
			$num=$row['number'];
			foreach ($qsel as $item) {
				$result=Querymysql("select * from question where id='$item'");
				$row=$result->fetch_array();
				$query="insert into question(id,book_id,cha_id,types,exits,answer,nandu,ans1,ans2,ans3,ans4,ans5,ans6,ans7) values(null,'$b_id','$c_id','".$row['types']."','".$row['exits']."','".$row['answer']."','".$row['nandu']."'";
				for($i=1;$i<=7;$i++)
				{
					$query=$query.",'".$row["ans$i"]."'";
				}
				$query=$query.")";
				//echo $query;
				Querymysql($query);
				$num++;
				Querymysql("update qbase_chapter set number='$num' where id='$c_id'");
			}
			//echo "目标题库：".$b_id."目标题集：".$c_id;
		}
		if(isset($_POST['move']))
		{
			$result=Querymysql("select * from qbase_chapter where id='$cc_id'");
			$row=$result->fetch_array();
			$numb=$row['number']-count($qsel);
			Querymysql("update qbase_chapter set number='$numb' where id='$cc_id'");
			$result=Querymysql("select * from qbase_chapter where id='$c_id'");
			$row=$result->fetch_array();
			$num=$row['number'];
			foreach ($qsel as $item) {
				$query="update question set book_id='$b_id',cha_id='$c_id' where id='$item'";
				//echo $query;
				Querymysql($query);
				$num++;
				Querymysql("update qbase_chapter set number='$num' where id='$c_id'");
			}
		}
	}
	echo "Ok<a href='quest_admin.php?viewb=$b_id'>返回</a>";
?>