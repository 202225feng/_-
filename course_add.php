<?php 
	require_once "header.php";
	if($value!=1) die("</body></html>");
	echo "<link rel='stylesheet' type='text/css' href='css/biaodan.css'/>";

	if(isset($_POST['sure']))
	{
		$name=sanitizeString($_POST['name']);
		$collage=sanitizeString($_POST['collage']);
		//$term=sanitizeString($_POST['term']);
		$g_code=sanitizeString($_POST['code']);
		Querymysql("insert into cour_info values(null,'$name','$collage','','$g_code') ");
		$result1=Querymysql("select cour_num from cour_info where cour_name='$name' and collage='$collage' and codes='$g_code' ");
		$row1=$result1->fetch_array();
		$id=$row1['cour_num'];
		if(isset($_POST['teacher']))
		{
			$tea_user=sanitizeString($_POST['teacher']);
			$result=Querymysql("select tea_name from teacher_info where tea_user='$tea_user' ");
			$row=$result->fetch_array();
			$tea_name=$row['tea_name'];
			
			Querymysql("insert into teacher_cour values(null,'$tea_user','$tea_name','$id',1,'1','$name')");
		}
		$dir = iconv("UTF-8", "GBK", "course/$id");
			 mkdir ($dir,0777,true);
		//echo "OK";
		echo <<<_END
		<script>
		alert('OK，5秒后自动跳转');
		window.setTimeout("window.location='course_admin.php'",500);
		</script>
_END;
	}
	echo <<<_END
<form action="course_add.php" method="post">
group名称：<input type="text" name="name"><br>
描述：<input type="text" name="collage"><br>
面试官：
_END;
	$result=Querymysql("select * from teacher_info where class='2' ");
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$user=$row['tea_user'];
		$name=$row['tea_name'];
		echo "<input type='radio' name='teacher' value='$user' required='required'>$user($name)"; 
	}
/*	echo "<br>助教老师：";
	$result=Querymysql("select * from teacher_info where class='6' ");
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$user=$row['tea_user'];
		$name=$row['tea_name'];
		echo "<input type='radio' name='zhujiao_teacher' value='$user'>$user($name)<input type='hidden' value='$name' name='zhujiao_tea_name'> "; 
	}*/

	$gro_code=create_password(8);
	echo "<br>group邀请码：<font color='red' size='2'>*可以自行设置</font><input type='text' name='code' value='$gro_code'>";
	echo <<<_END
	
	<div class="content">
            <div class="buttons">
            <input type='submit' name='sure' style='width:70px;height:45px' value='添加'>
                <div class="button">
                    <a href="course_admin.php" style="text-decoration: none;color: black">
                    返回
                </a>
                </div>
            </div>
        </div>
</form>
_END;
	//echo "<a href='course_admin.php'>返回</a>";

?>
