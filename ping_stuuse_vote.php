<?php
	require_once "header.php";
	if(isset($_GET['viewc'])&&isset($_GET['viewp']))
	{
		$cour_id=sanitizeString($_GET['viewc']);
		$ping_id=sanitizeString($_GET['viewp']);
	}
	else die();

	$result=Querymysql("select * from ping_fen where stu_num='$user' and ping_id='$ping_id'");
	if($result->num_rows)
	{
		echo "<h3>你已经投过票了<h3>";
		echo "你选的是：<br>";
		$row=$result->fetch_array();
		$first=$row['first_id'];
		$second=$row['second_id'];
		$third=$row['third_id'];
		if($first!='')
		$result=Querymysql("select name from ping_sub where id='$first'");
		$row=$result->fetch_array();
		echo $row['name']."<br>";
		if($second!='')
		$result=Querymysql("select name from ping_sub where id='$second'");
		$row=$result->fetch_array();
		echo $row['name']."<br>";
		if($third!='')
		$result=Querymysql("select name from ping_sub where id='$third'");
		$row=$result->fetch_array();
		echo $row['name']."<br>";

	}
	else{
		if(isset($_GET['sure']))
		{
			$sel_id=$_GET['select'];
			$first=sanitizeString($sel_id[0]);
			$second=sanitizeString($sel_id[1]);
			$third=sanitizeString($sel_id[2]);
			$today = date('Y/m/d\ H:i:s');
			$query="insert into ping_fen(id,stu_num,ping_id,first_id,second_id,third_id,status,pin_date) values(null,'$user','$ping_id','$first','$second','$third',1,'$today')";
			echo $query;
			Querymysql($query);
		}
		$result=Querymysql("select * from ping_sub where ping_id='$ping_id' and status=1");
		echo "<form action='ping_stuuse_vote.php' method='get'><table border><tr><th>请选出你认为最好的三个</th></tr>";
		for($i=0;$i<$result->num_rows;$i++)
		{
			$row=$result->fetch_array();
			$z_id=$row['id'];
			$w_url=$row['work_url'];
			$z_name=$row['name'];
			echo "<tr><td><input type='checkbox' value='$z_id' name='select[]'></td><td><a href=''>$z_name</a></td>";
		}
		echo "</table><input type='hidden' value='$ping_id' name='viewp'><input type='hidden' value='$cour_id' name='viewc'><input type='submit' value='确定' name='sure'>提交后不能修改</form>";
	}
?>