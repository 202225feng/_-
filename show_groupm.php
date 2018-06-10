<?php
	require_once "zheader.php";
	$result=Querymysql("select * from cour_info where cour_num in (select cour_num from stu_cour where stu_num='$user' )");
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$c_id=$row['cour_num'];
		$c_name=$row['cour_name'];
		$collage=$row['collage'];
		echo "<a href='show_group.php?view=$c_id'>$c_name</a>隶属单位：$collage<br>";
	}
?>