<?php
	require_once "header.php";

	$p_id=sanitizeString($_POST['papid']);
	$cour_num=sanitizeString($_POST['couid']);
	if(isset($_POST['select']))
	{	
		$dele_id=$_POST['select'];
		if(isset($_POST['delete']))
		{
			foreach ($dele_id as $item) {
				$query="delete from paper_ques where id='$item'";
				//echo $query."<br>";
				Querymysql($query);
			} 
		}
		else
		{
			$tp_id=sanitizeString($_POST['sel_p']);
			if(isset($_POST['move']))
			{
				foreach ($dele_id as $item) {
					$query="update paper_ques set paper_id='$tp_id' where id='$item'";
					//echo $query."<br>";
					Querymysql($query);
				}
			}
			if(isset($_POST['copy']))
			{
				foreach ($dele_id as $item) {
					$result=Querymysql("select * from paper_ques where id='$item'");
					$row=$result->fetch_array();
					$query="insert into paper_ques(id,paper_id,q_id,q_type,book_name,cha_name) values(null,'$tp_id','".$row['q_id']."','".$row['q_type']."','".$row['book_name']."','".$row['cha_name']."')";
					//echo $query."<br>";
					Querymysql($query);
				}
			}
		}
	}
	else echo"error<br>";
	echo "<a href='paper_admin.php?viewc=$cour_num&viewp=$p_id'>返回</a>";
