<?php
  if(!session_id())
	session_start();

	require_once 'function.php';
	if(isset($_SESSION['user'])&&isset($_SESSION['value']))
	{
		$user =$_SESSION['user'];
		$logged = TRUE;
	}
	else die();
	echo <<<_end
	<!DOCTYPE html><html><head>
	<title>RUC智慧招聘——答题端</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
	<link href="public/css/bootstrap.min.css" rel="stylesheet"/>
      <script src="public/js/jquery.min.js">
      </script>
      <script src="public/js/bootstrap.min.js">
      </script>
      <script src="javascript.js">
      </script>
	</head>
_end;
	echo <<<_end
	<body style="background-image: url('public/images/blue-white.jpg')">
    <div class="logobar" style="background-color:#aadc21">
      <img alt="RUC招聘" class="img-responsive" src="public/images/ICON.jpg"/>
    </div>
    <nav class="navbar navbar-default navbar-fixed-bottom navbar-inverse" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button class="navbar-toggle" data-target="#example-navbar-collapse" data-toggle="collapse" type="button">
            <span class="sr-only">
              切换导航
            </span>
            <span class="icon-bar">
            </span>
            <span class="icon-bar">
            </span>
            <span class="icon-bar">
            </span>
          </button>
          <a class="navbar-brand" href="">
            RUC招聘
          </a>
        </div>
        <div class="collapse navbar-collapse" id="example-navbar-collapse">
          <ul class="nav navbar-nav nav-tabs" id="myTab">
            <li>
              <a data-toggle="tab" href="#psinfo">
                <span class="glyphicon glyphicon-user">
                </span>
                个人信息
              </a>
            </li>
            <li class="active">
              <a data-toggle="tab" href="#testli">
                <span class="glyphicon glyphicon-edit">
                </span>
                考试
              </a>
            </li>
            <li>
              <a data-toggle="tab" href="#compli">
                <span class="glyphicon glyphicon-tag">
                </span>
                企业
              </a>
            </li>
            <li>
              <a data-toggle="tab" href="logout.php">
                <span class="glyphicon glyphicon-tag">
                </span>
                退出
              </a>
            </li>
            <li>
              <a data-toggle="tab" href="show_group.php">
                <span class="glyphicon glyphicon-info-sign">
                </span>
                GROUP
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
_end;
    
?>