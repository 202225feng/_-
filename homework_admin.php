<?php
	require_once "header.php";
	if($value!=2)
		die();

	if(isset($_SESSION['cour_id_hwork']))
		$_SESSION['cour_id_hwork']=null;
	if(isset($_SESSION['cour_id_hwork_chang']))
		$_SESSION['cour_id_hwork_chang']=null;
	if(isset($_SESSION['cour_hwork_id_view']))
		$_SESSION['cour_hwork_id_view']=null;

	if(isset($_GET['cour_id']))//添加新作业
	{
		$idd=sanitizeString($_GET['cour_id']);
		$result=Querymysql("select * from teacher_cour where tea_user='$user' and cour_num='$idd' ");
		if($result->num_rows)
		{
			$_SESSION['cour_id_hwork']=$idd;
			header("Location:homework_add.php");
		}
	}
	if(isset($_GET['chang_id']))//修改作业信息
	{
		$idd=sanitizeString($_GET['chang_id']);
		$result=Querymysql("select cour_num from course_homework where id='$idd'");
		if($result->num_rows)
		{
			$row=$result->fetch_array();
			$cou_num=$row['cour_num'];
			$result=Querymysql("select * from teacher_cour where tea_user='$user' and cour_num='$cou_num'");
			if($result->num_rows)
			{
				$_SESSION['cour_id_hwork_ch']=$idd;
				header("Location:homework_change.php");
			}
		}
	}
	if(isset($_GET['view']))//查看作业信息
	{
		$idd=sanitizeString($_GET['view']);
		$result=Querymysql("select cour_num from course_homework where id='$idd'");
		if($result->num_rows)
		{
			$row=$result->fetch_array();
			$cou_num=$row['cour_num'];
			$result=Querymysql("select * from teacher_cour where tea_user='$user' and cour_num='$cou_num'");
			if($result->num_rows)
			{
				$_SESSION['cour_hwork_id_view']=$idd;
				header("Location:homework_view.php");
			}
		}
	}

	$today = date('Y/m/d\ H:i:s');
				echo "今天：".$today;
	$result=Querymysql("select * from teacher_cour where tea_user='$user' and status=1");
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$cour_id=$row['cour_num'];
		$cour_name=$row['cour_name'];
		echo "<h3>$cour_name</h3>";
		echo "<a href='homework_admin.php?cour_id=$cour_id'>添加作业</a><br><br>";
		$result1=Querymysql("select * from course_homework where cour_num='$cour_id'");
		$type=array("","大作业","实验作业","普通作业");
		for($j=0;$j<$result1->num_rows;$j++)
		{
			$row1=$result1->fetch_array();
			$hwork_id=$row1['id'];
			$hwork_name=$row1['name'];
			$hwork_date=$row1['end_date'];
			$hwork_class=$row1['class'];

			echo "作业名称："."<a href='homework_admin.php?view=$hwork_id'>".$hwork_name."</a><br>";
			echo "作业类型：".$type["$hwork_class"]."<br>";
			echo "作业描述：".$row1["describ"]."<br>";
			echo "截止日期".$hwork_date."<br>";
			$date=floor((strtotime($hwork_date)-strtotime($today))/86400);
			echo "剩余：".$date."天";
			$hour=floor((strtotime($hwork_date)-strtotime($today))%86400/3600);
			echo $hour."小时";
			$minute=floor((strtotime($hwork_date)-strtotime($today))%86400%3600/60);
			echo $minute."分钟<br/>";
			echo "<a href='homework_admin.php?chang_id=$hwork_id'>修改</a><br><br>";
		}
	}

?>