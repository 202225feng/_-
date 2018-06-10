<?php  
	require_once "function.php";
	if(isset($_POST['qb_id']))
		$qb_id=$_POST['qb_id'];
	$result=Querymysql("select * from qbase_chapter where book_id='$qb_id'");
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$tc_id=$row['id'];
		$tc_name=$row['name'];
			echo "<option value='$tc_id'>$tc_name</option>";
	}
?>