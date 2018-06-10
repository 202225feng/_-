<?php
	require_once "function.php";

	if(isset($_GET['view']))
		$id=$_GET['view'];
	$result=Querymysql("select * from ping_sub where id='$id'");
	if($result->num_rows)
	{
		$row=$result->fetch_array();
		$work_url=$row['work_url'];
		$user=$row['stu_num'];
	}
	else die();

	$file_name=trim(strrchr($work_url, '/'),'/');
	$file=fopen("$work_url".$user,"r");
	header("Content-Type: application/octet-stream");
	header("Accept-Ranges: bytes");
	header("Accept-Length: ".filesize("$work".$user));
	header("Content-Disposition: attachment; filename=$file_name");
	echo fread($file,filesize("$work_url$user"));
	fclose($file);
?>