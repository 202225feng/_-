<?php
	require_once "header.php";

	if(isset($_GET['viewc'])&&isset($_GET['viewp']))
	{
		$cour_id=sanitizeString($_GET['viewc']);
		$ping_id=sanitizeString($_GET['viewp']);
	}
	else if(isset($_POST['viewc'])&&isset($_POST['viewp']))
	{
		$cour_id=sanitizeString($_POST['viewc']);
		$ping_id=sanitizeString($_POST['viewp']);
	}
	else die();

	$result=Querymysql("select * from ping_sub where stu_num='$user' and ping_id='$ping_id' and status=1");
	if($result->num_rows)
	{
		echo "<h3>你已经提交</h3>";
	}
	else
	{
		if(isset($_POST['import']))
		{
			$name=$_FILES['file']['name'];
			$name1=iconv("UTF-8","gb2312", $_FILES["file"]["name"]);
			//echo "$name<br>";
		    $today = date('Y/m/d\ H:i:s');
		    $z_name=$_POST['name'];
		    $query="insert into ping_sub(id,work_url,stu_num,ping_id,status,sub_date,name) values(null,'course/$cour_id/$ping_id-ping/$name','$user','$ping_id',1,'$today','$z_name')";
		   // $query=iconv("UTF-8","gb2312", $query);
		    echo $query;
		    Querymysql($query);
		    move_uploaded_file($_FILES["file"]["tmp_name"],"course/$cour_id/$ping_id-ping/" . $name."$user");
		    die("<h3>提交成功</h3></body></html>");
		}
	echo <<<_end
<form action="ping_stuuse_submit.php" method="post"
enctype="multipart/form-data">
作品名称：<input type='text' name='name'><br>
<label for="file">Filename:</label>
<input type="file" name="file" id="file" /> 
<br />
<input type='hidden' value='$ping_id' name='viewp'>
<input type='hidden' value='$cour_id' name='viewc'>
<input type="submit" name="import" value="提交" />
</form>
_end;
	}
?>