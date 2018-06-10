<?php
	require_once "function.php";
    if(!session_id())
	session_start();
	echo "<!DOCTYPE html>\n<html class='no-js' lang='en'><head>".
	"<meta charset='utf-8'>".
	"<title>RUC智慧招聘——管理端</title>".
	"<link href='css/component.css' rel='stylesheet' type='text/css'/>".
	"<link href='css/styles.css' rel='stylesheet' type='text/css'/>".
	"<script src='javascript.js'></script>".
	"<script src='jquery-3.3.1.min.js'></script>".
	"</head><body>" ;
	if(isset($_SESSION['user'])&isset($_SESSION['value']))
	{
		if($_SESSION['value']==0)
			header("Location:logout.php");
		else
			header("Location:admin.php");
	}
	$error = $user =$pass =$value ='';
	if(isset($_POST['username'])&&isset($_POST['password']))
	{
		$user=sanitizeString($_POST['username']);
		$pass=sanitizeString($_POST['password']);
		if($user==''||$pass=='')
			$error="请填写";
		else
		{
			$pass="@a@"+$pass+"&asd";
			$pass=hash("sha256",$pass);
 			$isnum=is_numeric($user);
			if(strlen($user)==10&&$isnum)
				$query = "select * from stu_infor where stu_num='$user' and pass='$pass'";
			else
				$query = "select * from teacher_info where tea_user='$user' and pass='$pass'";
			$result = Querymysql($query);
			if($result->num_rows)
			{
				$row=$result->fetch_array();
				$_SESSION['user']=$user;
				if(strlen($user)==10&&$isnum)
				{
					$_SESSION['value']=0;
					header("Location:studing.php");
				}
				else{
					$_SESSION['value']=$row['class'];
					header("Location:admin.php");
				}
			}
			else
			{
				$error="用户名或密码错误";
			}
		}
	}
	//header("Location: http://www.baidu.com");
	echo<<<_end
	<div class="container demo-1">
            <div class="content">
                <div class="large-header" id="large-header">
                    <canvas id="demo-canvas">
                    </canvas>
                    <div class="container1" id="yes">
                        <ul class="menu">
                            <b class="logo">RUC智慧招聘</b>
                            <li>
                                <a href="accout_admin.php">
                                    产品特点
                                </a>
                            </li>
                            <li>
                                <a href="collage_admin.php">
                                    关于我们
                                </a>
                            </li>
                            <li>
                                <a href="user_admin.php">
                                    加入我们
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="logo_box">
                        <h3>
                            欢迎登录
                        </h3>
                        <font color='red'>$error</font><br>
                        <form action="index.php" method="post">
                            <div class="input_outer">
                                <span class="u_user">
                                </span>
                                <input class="text" name="username" placeholder="请输入账户" style="color: #FFFFFF !important" type="text">
                                
                            </div>
                            <div class="input_outer">
                                <span class="us_uer">
                                </span>
                                <input class="text" name="password" placeholder="请输入密码" style="color: #FFFFFF !important; position:absolute; z-index:100;" type="password">
                                </input>
                            </div>
                            <div class="mb2">
                                <button type='submit' class='act-but submit' value='登录'>
                                登录
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/TweenLite.min.js" type="text/javascript">
        </script>
        <script src="js/EasePack.min.js" type="text/javascript">
        </script>
        <script src="js/rAF.js" type="text/javascript">
        </script>
        <script src="js/demo-1.js" type="text/javascript">
        </script>
_end;

?>

</body>
</html>