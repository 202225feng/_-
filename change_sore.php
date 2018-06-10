<?php
	session_start();
	require_once "function.php";

	if(isset($_POST['row']))
		$rows=sanitizeString($_POST['row']);
	if(isset($_POST['sore']))
		$sore=sanitizeString($_POST['sore']);
	echo "row=".$rows." "."sore=".$sore;

	require_once "PHPExcel-1.8\Classes\PHPExcel.php";

	if(!isset($_SESSION['cour_hwork_id_view']))
		die();
	$hwork_id=$_SESSION['cour_hwork_id_view'];

	$result=Querymysql("select * from course_homework where id='$hwork_id'");
	$row=$result->fetch_array();
	$cour_num=$row['cour_num'];
	$hw_name=$row['name'];//获取文件位置	

	//文件路径	
	$filename="course\\$cour_num\\$hwork_id-name\\hworksubinfo.xlsx";  

	//$reader = PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)  
	
	
	$objReader = PHPExcel_IOFactory::createReaderForFile($filename); //准备打开文件  
	$objPHPExcel = $objReader->load($filename);   //载入文件  
	$objPHPExcel->setActiveSheetIndex(0);         //设置第一个Sheet  
	/*$data = $objPHPExcel->getActiveSheet()->getCell('A2')->getValue();  //获取单元格A2的值  
	  */
	//写数据  
	$rows="C".$rows;
	echo $rows;
	$objPHPExcel->getActiveSheet()->setCellValue("$rows", "$sore");//指定要写的单元格位置   
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'excel2007');  
	$objWriter->save($filename); 

?>