<?php
	require_once "header.php";
	require_once "PHPExcel-1.8\Classes\PHPExcel.php";
	if(!isset($_SESSION['cour_id_add']))
		header("Location:course_admin.php");
	$id=sanitizeString($_SESSION['cour_id_add']);

	$error='';
	if(isset($_POST['import']))
	{
		$name=iconv("UTF-8","gb2312", $_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"],
		"upload/" . $name);
	    $filename="upload\\".$name;
	    $reader = PHPExcel_IOFactory::createReader('excel2007');
		$PHPExcel = $reader->load($filename); 
		$sheet = $PHPExcel->getSheet(0); 
		$highestRow = $sheet->getHighestRow();
		$highestColumm = $sheet->getHighestColumn();
		for ($row = 2; $row <= $highestRow; $row++)
		{
			$dataset = $sheet->getCell('A'.$row)->getValue();
			$stu_num=sanitizeString($dataset);

			$result=$conn->query("select * from stu_infor where stu_num='$stu_num'");
			if(!$result)
				$error=$error."add $stu_num wrong <br>";
			else
			if($result->num_rows)
			{
				$result= $conn->query("select * from stu_cour where stu_num='$stu_num' and cour_num='$id'");
				if(!$result->num_rows){
					$conn->query("insert into stu_cour values(null,'$stu_num','$id',1)");
					if(!$result)
						$error=$error."add $stu_num wrong <br>";
					else
						$error=$error."$stu_num 已经添加<br>";
				}
				else
					$error=$error."$stu_num 已经添加le<br>";
			}
			else
				$error=$error."$stu_num 不存在该学生<br>";
		}
		
	}

	echo <<<_END
$error<br>
为了减少不必要的麻烦，请参考模板<br>
<a href='download.php?filepath=moban\\piliangdaorumoban2.xlsx'>下载模板</a><br>
<form action="stu_add_cour_quick.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" /> 
<br />
<input type="submit" name="import" value="Submit" />
</form>
<a href="stu_info_cour.php">返回</a><br>
_END;
?>