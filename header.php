<?php
    if(!session_id())
	session_start();

	require_once 'function.php';
	if(isset($_SESSION['user'])&&isset($_SESSION['value']))
	{
		$user =$_SESSION['user'];
		$value=$_SESSION['value'];
		$logged = TRUE;
	}
	else die();
	echo "<!DOCTYPE html><html><head>";

	if($value==1)
	{
		echo <<<_end
	<title>教学系统——管理端</title>
	<script src="javascript.js" type="text/javascript">
        </script>
	<link href="css/styles.css" rel="stylesheet" type="text/css"/>
    <link href="css/but.css" rel="stylesheet" type="text/css"/>
    <link href="css/styles2.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="css/ttable.css">
	</head><body>
	<div class="container2" id="yes" style='clear:both'>
            <ul class="menu">
                <li>
                    <a href="accout_admin.php">
                        个人主页
                    </a>
                </li>
                <li>
                    <a href="user_admin.php">
                        账号管理
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="tea_add.php">
                                添加管理帐号
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li>
                    <a href="course_admin.php">
                        group管理
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="course_add.php">
                                添加group
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="quest_admin.php">
                        试题管理
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="quest_add.php?type=1">
                                添加题库
                            </a>
                        </li>
                        <li>
                            <a href="quest_add_quick.php">
                                导入试题
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="paper_admin.php">
                        试卷管理
                    </a>
                </li>
                <li>
                    <a href="exam_admin.php">
                        考试管理
                    </a>
                </li>
                <li>
                    <a href="infor_admin.php">
                        消息管理
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        退出
                    </a>
                </li>
            </ul>
        </div>

_end;
	}
	if($value==2)
	{
		echo <<<_end
	<title>教学系统——管理端</title>
    <script src="javascript.js" type="text/javascript">
        </script>
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    <link href="css/but.css" rel="stylesheet" type="text/css"/>
    <link href="css/styles2.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="css/ttable.css">
    </head><body>
    <div class="container2" id="yes" style='clear:both'>
            <ul class="menu">
                <li>
                    <a href="accout_admin.php">
                        个人主页
                    </a>
                </li>
               
                
                <li>
                    <a href="course_admin.php">
                        group管理
                    </a>
                    
                </li>
                
                
                <li>
                    <a href="exam_admin.php">
                        考试管理
                    </a>
                </li>
                <li>
                    <a href="infor_admin.php">
                        消息管理
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        退出
                    </a>
                </li>
            </ul>
        </div>
_end;
	}
	if($value==0)
	{
		echo "<a href='ping_each_stuuse.php'>互评系统</a>
		<a href='logout.php'>退出</a><br><br>";
	}
	
?>
