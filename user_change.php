<?php
	require_once "header.php";
	if($value!=1)
		die();
	$error='';
	if(!isset($_POST['user']))
		header("Location:user_admin.php");
	if(isset($_POST['sure']))
	{
		$user=sanitizeString($_POST['user']);
		$pass=sanitizeString($_POST['pass']);
		$pass1=sanitizeString($_POST['pass1']);
		$name=sanitizeString($_POST['name']);
		$gender=sanitizeString($_POST['gender']);
		$collage=sanitizeString($_POST['collage']);
		$class=sanitizeString($_POST['class']);
			if($pass==''||$pass1=='')
				$error="密码不能为空";
			else
				if($pass!=$pass1)
					$error="两次密码输入不一致";
				else
				{
					$result =Querymysql("select pass from teacher_info where tea_user='$user'");
					$row=$result->fetch_array();
					if($pass==$row['pass'])
					{
						Querymysql("update teacher_info set tea_name='$name',pass='$pass',gender='$gender',collage='$collage',class='$class' where tea_user='$user' ");
						die("修改完毕");
					}
					else
					{
						$pass="@a@"+$pass+"&asd";
						$pass=hash("sha256",$pass);
						Querymysql("update teacher_info set tea_name='$name',pass='$pass',gender='$gender',collage='$collage',class='$class' where tea_user='$user' ");
						die("修改完毕");
					}
				}
	}

		$che_user=sanitizeString($_POST['user']);
		$result=Querymysql("select * from teacher_info where tea_user='$che_user'");
		$row=$result->fetch_array();
		$user=$row['tea_user'];
		$name=$row['tea_name'];
		$class=$row['class'];
		$pass=$row['pass'];
		$gender=$row['gender'];
		$collage=$row['collage'];
echo <<<_end
		
<form action="user_change.php" method="post">
<table border>
<tr><th></th><th><input type="hidden" name="user" value="$user">$user</th></tr>
<tr><th>密码</th><th><input type="password" name="pass" value="$pass"></th></tr>
<tr><th>确认密码</th><th><input type="password" name="pass1" value="$pass"></th></tr>
<tr><th>真实姓名</th><th><input type="text" name="name" value="$name"></th></tr>
_end;

if($gender=='女')
echo <<<_end
<tr><th>性别</th><th><input type="radio" name="gender" value="女" checked>女
<input type="radio" name="gender" value="男">男</th></tr>
_end;
else
	echo <<<_end
<tr><th>性别</th><th><input type="radio" name="gender" value="女">女
<input type="radio" name="gender" value="男" checked>男</th></tr>
_end;

if($class==1)
	echo<<<_end
<tr><th>单位</th><th><input type="text" name="collage" value="$collage"></th></tr>
<tr><th>账号类型</th><th><input type="radio" name="class" value="1" checked>超级管理员
<input type="radio" name="class" value="2">面试官
<tr><th></th><th><input type="submit" name="sure" value="修改"></th>
_end;
if($class==2)
	echo<<<_end
<tr><th>单位</th><th><input type="text" name="collage" value="$collage"></th></tr>
<tr><th>账号类型</th><th><input type="radio" name="class" value="1" >超级管理员
<input type="radio" name="class" value="2" checked>面试官
<tr><th></th><th><input type="submit" name="sure" value="修改"></th>
_end;


	echo "</table></form>$error<br>";
	die("</body></html>");
	
?>

