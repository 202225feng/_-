<?php
	require_once "header.php";

	if(isset($_POST['sure']))
	{
		$id=sanitizeString($_POST['idd']);
		$name=sanitizeString($_POST['name']);
		$exits=sanitizeString($_POST['exits']);
		Querymysql("update collage_inforation set name='$name',exits='$exits' where id='$id'");
		echo "<script>alert('修改完成')</script>";
		header("Location:collage_admin.php");
	}
	if(isset($_POST['cancel']))
		header("Location:collage_admin.php");
	if(isset($_POST['xiugai']))
	{
		$id=sanitizeString($_POST['erase']);
		$result= Querymysql("select * from collage_inforation where id='$id'");
		$row=$result->fetch_array();
		$name=$row['name'];
		$exits=$row['exits'];
		echo <<<_END
		<form action="collage_change.php" method="post">
		<input type="text" name="name" value="$name">
		<input type="text" name="exits" value="$exits">
		<input type="hidden" name="idd" value="$id">
		<input type="submit" name="sure" value="确定">
		<input type="submit" name="cancel" value="取消">
		</form>
_END;
	}
	if(isset($_POST['shanchu']))
	{
		$id=sanitizeString($_POST['erase']);
		$result= Querymysql("select * from collage_inforation where id='$id'");
		$row=$result->fetch_array();
		$name=$row['name'];
		if($row['number']!=0)
		{
			echo "<script>alert('请先清除该院系内全部学生')</script>";
			header("Location:collage_admin.php");
		}
		else
		{
			Querymysql("delete from collage_inforation where id='$id'");
			echo "<script>alert('已经删除$name')</script>";
			header("Location:collage_admin.php");
		}
	}
?>
</body>
</html>