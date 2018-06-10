<?php
	require_once "function.php";
	session_start();
	if(isset($_SESSION['user'])&&isset($_SESSION['value']))
	{
		$user =$_SESSION['user'];
		$value=$_SESSION['value'];
		$logged = TRUE;
	}
	else
	{
		echo "3";
		die();
	}
	$c_id=sanitizeString($_POST['cid']);
	$code=sanitizeString($_POST['code']);
	$result=Querymysql("select * from cour_info where cour_num='$c_id'");
	if($result->num_rows)
	{
		$row=$result->fetch_array();
		$c_code=$row['codes'];
		if($code==$c_code)
		{
			Querymysql("insert into stu_cour(id,stu_num,cour_num,status) values(null,'$user','$c_id',1)");
			echo "1";
			die();
		}
		else{
			echo "2";
			die();
		}
	}
	else
	{
		echo "3";
	}
?>