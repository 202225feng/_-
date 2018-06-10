<?php  
   require_once "function.php";

   $filename =$_GET['filepath'];
header('Content-Disposition: attachment; filename=moban.xlsx');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Length: ' . filesize($filename));
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');
readfile($filename);
?> 