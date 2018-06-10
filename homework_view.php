<?php
	require_once "header.php";
	if($value!=2) die();

	require_once "PHPExcel-1.8\Classes\PHPExcel.php";

	if(!isset($_SESSION['cour_hwork_id_view']))
		header("Location:homework_admin.php");
	$hwork_id=$_SESSION['cour_hwork_id_view'];

	$result=Querymysql("select * from course_homework where id='$hwork_id'");
	$row=$result->fetch_array();
	$cour_num=$row['cour_num'];
	$hw_name=$row['name'];

	$filename="course\\$cour_num\\$hwork_id-name\\hworksubinfo.xlsx";  
	//$reader = PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)  
	$reader = PHPExcel_IOFactory::createReader('excel2007');
	$PHPExcel = $reader->load($filename); // 载入excel文件  
	$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表  
	$highestRow = $sheet->getHighestRow(); // 取得总行数  
	$highestColumm = $sheet->getHighestColumn(); // 取得总列数  
	  
	/** 循环读取每个单元格的数据 */ 
	echo "<table border><tr><th>学号</th><th>提交</th><th>得分</th></tr> "; 
	for ($row = 1; $row <= $highestRow; $row++)   
	{  
		$dataset = $sheet->getCell('A'.$row)->getValue();
		if($dataset!='')
		{
			echo "<tr><th>";    
	       	echo $dataset."</th><th>";
	       	$dataset = $sheet->getCell('B'.$row)->getValue();
	       	if($dataset=='')
	       		echo "未提交";
	       	else
	       		echo "$dataset";
	       	echo "</th><th>";
	       	$dataset = $sheet->getCell('C'.$row)->getValue();
	       	if($dataset=='')
	       		echo "<input type='text' maxlength='3' name='user' value='未打分'  onblur='chasore($row,this)'>";
	       	else
	       		echo "<input type='text' maxlength='3' name='user' value='$dataset'  onblur='chasore($row,this)'>";
	       	echo "</th></tr>"; 
	     }
	} 

	/*$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Hello');//指定要写的单元格位置   
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
	$objWriter->save('2.xls');*/

?>