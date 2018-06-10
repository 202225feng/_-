<?php
	session_start();
	require_once 'function.php';
	if(isset($_SESSION['user'])&&isset($_SESSION['value']))
	{
		$user =$_SESSION['user'];
		$value=$_SESSION['value'];
		$logged = TRUE;
	}
	else die();
	$result=Querymysql("select * from teacher_info where tea_user='$user'");
	$row = $result->fetch_array();
	$pass=$row['pass'];
	$name=$row['tea_name'];
	$gender=$row['gender'];
	$collage=$row['collage'];
	echo <<<_end
<form action="accout_admin.php" method="post">
                        密码
                        <input name="pass" type="password" value="$pass">
                            重复密码
                            <input name="pass2" type="password" value="$pass">
                                <br>
                                    姓名：
                                    <input name="name" type="text" value="$name">
                                        <br>
                                            性别：
                                            <input name="gender" type="text" value="$gender">
                                                <br>
                                                    学院：
                                                    <input name="collage" type="text" value="$collage">
                                                        <br>
                                                            <input name="sure" type="submit" value="确定">
                                                                <input name="not" type="submit" value="取消">
                                                                </input>
                                                            </input>
                                                        </br>
                                                    </input>
                                                </br>
                                            </input>
                                        </br>
                                    </input>
                                </br>
                            </input>
                        </input>
               		</form>
_end;

?>