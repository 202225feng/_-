<?php
	require_once "zheader.php";
	echo "<script>ts('xx')</script>";
	$result=Querymysql("select * from stu_infor where stu_num='$user'");
	if($result->num_rows)
	{
		$row=$result->fetch_array();
		$name=$row['name'];
		$gender=$row['gender'];
		$phonenum=$row['phonenum'];
		$school=$row['school'];
		$major=$row['major'];
		$degree=$row['degree'];
		echo <<<_end
		<h3>个人信息</h3>
		姓名：$name<br>
        性别：$gender<br>
        电话号码：$phonenum<br>
        学校：$school<br>
        专业：$major<br>
        学历：$degree<br>
        <form action="personal_change.php" method="post">
        <input type="submit" name="change" value="修改" >
        <input type="hidden" name="name" value="$name">
        <input type="hidden" name="gender" value="$gender">
        <input type="hidden" name="phonenum" value="$phonenum">
        <input type="hidden" name="school" value="$school">
        <input type="hidden" name="major" value="$major">
        <input type="hidden" name="degree" value="$degree">
        </form>
_end;
	}
	else
	{
		
	}
?>
