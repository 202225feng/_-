<?php
	require_once "header.php";
	$error='';
	if(isset($_POST['sure']))
	{
		$pass=sanitizeString($_POST['pass']);
		$pass2=sanitizeString($_POST['pass2']);
		$name=sanitizeString($_POST['name']);
		$gender=sanitizeString($_POST['gender']);
		$collage=sanitizeString($_POST['collage']);
		if($pass==''||$name==''||$gender==''||$collage=='')
		{
			$error="修改失败，信息不全";
		}
		else
		{
			if($pass!=$pass2)
			{
				$error="修改失败，两次密码输入不一致";
			}
			else
			{
				$result =Querymysql("select pass from teacher_info where tea_user='$user'");
					$row=$result->fetch_array();
					if($pass==$row['pass'])
					{
						Querymysql("update teacher_info set tea_name='$name',pass='$pass',gender='$gender',collage='$collage' where tea_user='$user' ");
					}
					else
					{
						$pass="@a@"+$pass+"&asd";
						$pass=hash("sha256",$pass);
						Querymysql("update teacher_info set tea_name='$name',pass='$pass',gender='$gender',collage='$collage' where tea_user='$user' ");
					}
			}
		}
		if($error!='')
			echo "<script>alert('$error')</script>";
	}

	$result=Querymysql("select * from teacher_info where tea_user='$user'");
	$row = $result->fetch_array();
	$pass=$row['pass'];
	$name=$row['tea_name'];
	$gender=$row['gender'];
	$collage=$row['collage'];
	echo <<<_end
	<div id="fdw-pricing-table" style="margin-left: 41%;">
            <div class="plan plan1" >
                <div class="header">
                    $user
                </div>
                <div class="price">
                    $name
                </div>
                <br>
                <div class="monthly">
                    性别：$gender
                </div>
                <div class="detail">
                    <ul>
                        <li>
                            <b>
                                单位：
                            </b>
                           $collage
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="modal-container">
            <div class="modal-background">
                <div class="modal" id='changeinfo'>
                 </div>
            </div>
        </div>
        <div class="content">
            <div class="buttons">
                <div class="button" id="one" onclick="changeinfo('$user','account_change.php','changeinfo')">
                    修改信息
                </div>
            </div>
        </div>
        <script src="js/jquery-3.3.1.min.js">
        </script>
        <script src="js/but.js" type="text/javascript">
        </script>
_end;


?>

</body>
</html>


