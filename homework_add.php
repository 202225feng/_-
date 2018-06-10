<?php
	require_once "header.php";
	require_once "PHPExcel-1.8\Classes\PHPExcel.php";
	if($value!=2)
		die();

	if(!isset($_SESSION['cour_id_hwork']))
		header("Location:homework_admin.php");
	$id=$_SESSION['cour_id_hwork'];

	if(isset($_POST['add']))
	{
		$name= sanitizeString($_POST['name']);
		$date=sanitizeString($_POST['datetime']);
		$class=sanitizeString($_POST['class']);
		$text=sanitizeString($_POST['text']);
		Querymysql("insert into course_homework values(null,'$name','$date','$class','$id','$text')");

		$result=Querymysql("select id from course_homework where name='$name' and cour_num='$id' ");
		$row=$result->fetch_array();
		$cour_id=$row['id'];
		$dir = iconv("UTF-8", "GBK", "course/$id/$cour_id-name");
		 mkdir ($dir,0777,true);

		$filename="course\\$id\\$cour_id-name\\hworksubinfo.xlsx";
		$objExcel = new PHPExcel();   
		$objWriter = new PHPExcel_Writer_Excel2007($objExcel);     // 用于其他版本格式   
		$objExcel->setActiveSheetIndex(0);   
		$objActSheet = $objExcel->getActiveSheet(); 
		$result=Querymysql("select * from stu_cour where cour_num='$id' and status=1");
		for($i=0;$i<$result->num_rows;$i++)
		{
			$j=$i+1;
			$j="A".$j;
			$row=$result->fetch_array();
			$stu_num=$row['stu_num'];
			$objActSheet->setCellValue("$j","$stu_num"); 
		} 
		 // 设置Excel中的内容  A2表示坐标

		$objWriter->save($filename); 
		echo "<h4>OK<a href='homework_admin.php'>返回</a></h4>";
	}
	echo <<<_end
<form method="post" action="homework_add.php">
作业名称：<input type="text" name="name" required><br>
截止日期：<input type="datetime-local" name="datetime" required><br>
作业描述：<textarea name='text' cols='50' rows='3'></textarea><br>
作业类型：<input type="radio" name="class" value=1 required>大作业
<input type="radio" name="class" value=2 required>实验作业
<input type="radio" name="class" value=3 required>普通作业<br>
<input type="submit" name="add" value="提交">
</form>
_end;

?>
