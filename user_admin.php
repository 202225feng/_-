<?php
	require_once "header.php";
	if($value!=1)
		die();

	//echo "<a href='tea_add.php'>添加管理账号</a><br><br>";
	$result =Querymysql("select * from teacher_info");
	echo "<table border='1'><tr><th>账号</th><th>真实姓名</th><th>账户类型</th><th>管理</th></tr> ";
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$user=$row['tea_user'];
		$name=$row['tea_name'];
		$class=$row['class'];
		$clas = array('学生','管理员','面试官');
		echo <<<_end
		<tr><td>$user</td><td>$name</td><td>$clas[$class]</td><td>
		<form action="user_change.php" method="post">
		<input type="hidden" name="user" value="$user">
		<input type="submit" name="change" value="修改">
		</form>
		</td></tr>
_end;
	}
	echo "</table>";

?>
</body></html>
