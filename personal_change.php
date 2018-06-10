<?php
	require_once "zheader.php";
	
	if(isset($_POST['change']))
	{
		$name =sanitizeString($_POST['name']);
		$gender =sanitizeString($_POST['gender']);
        $phonenum =sanitizeString($_POST['phonenum']);
        $school =sanitizeString($_POST['school']);
        $major =sanitizeString($_POST['major']);
        $degree =sanitizeString($_POST['degree']);
		echo <<<_end
<form action="personal_change.php" method="post">
姓名：<input type="text" name="name" value="$name"><br>
性别：<input type="text" name="gender" value="$gender"><br>
电话号码：<input type="text" name="phonenum" value="$phonenum"><br>
学校：<input type="text" name="school" value="$school"><br>
专业：<input type="text" name="major" value="$major"><br>
学历：<input type="text" name="degree" value="$degree"><br>
<input type="submit" name="sure" value="修改">
<input type="submit" name="cancel" value="取消">
</form>
_end;
	}
	if(isset($_POST['sure']))
	{
		$name =sanitizeString($_POST['name']);
		$gender =sanitizeString($_POST['gender']);
        $phonenum =sanitizeString($_POST['phonenum']);
        $school =sanitizeString($_POST['school']);
        $major =sanitizeString($_POST['major']);
        $degree =sanitizeString($_POST['degree']);
        Querymysql("update stu_infor set name='$name',gender='$gender',phonenum='$phonenum',school='$school',major='$major',degree='$degree' where stu_num='$user'");
        echo "<script>alert('修改完成')</script>";
		header("Location:personal.php?");
	}
	if(isset($_POST['cancel']))
	{
		header("Location:personal.php?");
	}
?>
