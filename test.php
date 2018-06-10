<?php
	require_once "function.php";
	require_once "PHPExcel-1.8\Classes\PHPExcel.php";

	$objExcel = new PHPExcel();   
	$objWriter = new PHPExcel_Writer_Excel2007($objExcel);     // 用于其他版本格式   
$objExcel->setActiveSheetIndex(0);   
$objActSheet = $objExcel->getActiveSheet();  
$objActSheet->setCellValue('A2', '中国11');  // 设置Excel中的内容  A2表示坐标
$objActSheet->setCellValue('A3', '中国11'); 
$objActSheet->setCellValue('A4', '中国111'); 
$objWriter->save('./test.xlsx');  
?>