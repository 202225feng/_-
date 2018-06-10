<?php 
	require_once "header.php";
	if($value!=1)
		die("</body></html>");
	$error='';
	if(isset($_POST['sure']))
	{
		$user=sanitizeString($_POST['user']);
		$pass=sanitizeString($_POST['pass']);
		$pass1=sanitizeString($_POST['pass1']);
		$name=sanitizeString($_POST['name']);
		$gender=sanitizeString($_POST['gender']);
		$collage=sanitizeString($_POST['collage']);
		$class=sanitizeString($_POST['class']);
		if($user=='')
			$error="账号不能为空";
		else
			if($pass==''||$pass1=='')
				$error="密码不能为空";
			else
				if($pass!=$pass1)
					$error="两次密码输入不一致";
				else
				{
					$result = Querymysql("select tea_user from teacher_info where tea_user='$user'");
					if(!$result->num_rows)
					{
						$pass="@a@"+$pass+"&asd";
						$pass=hash("sha256",$pass);
						Querymysql("insert into teacher_info values('$user','$name','$pass','$gender','$collage',$class)");
						header("Location:user_admin.php");
					}
					else
						$error="用户已存在";
		}
	}
	echo <<<_end
	$error<br>
 <form action='tea_add.php' method="post">
 <table border>
<tr><th>账号</th><th><input type="text" name="user"></th></tr>
<tr><th>密码</th><th><input type="password" name="pass"></th></tr>
<tr><th>确认密码</th><th><input type="password" name="pass1"></th></tr>
<tr><th>真实姓名</th><th><input type="text" name="name"></th></tr>
<tr><th>性别</th><th><input type="radio" name="gender" value="女" checked>女
<input type="radio" name="gender" value="男">男</th></tr>
<tr><th>单位</th><th><input type="text" name="collage"></th></tr>
<tr><th>账号类型</th><th><input type="radio" name="class" value="1" checked>超级管理员
<input type="radio" name="class" value="2">面试官
<tr><th></th><th><input type="submit" name="sure" value="添加"></th>
</table>
 </form>
_end;

 ?>
