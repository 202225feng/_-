<?php
	require_once "header.php";
	require_once "PHPExcel-1.8\Classes\PHPExcel.php";

	if($value!=1) die();

	if(isset($_GET['id']))
	$_SESSION['collage_id']=sanitizeString($_GET['id']);
	
	if(isset($_SESSION['collage_id']))
		$id=$_SESSION['collage_id'];
	else
		header("Location:collage_admin.php");

	$error="";

	if(isset($_POST['import']))
	{
		if ($_FILES["file"]["error"] > 0)
		{
		echo "Error: " . $_FILES["file"]["error"] . "<br />";
		}
		else
		{
		/*echo "Upload: " . $_FILES["file"]["name"] . "<br />";
		echo "Type: " . $_FILES["file"]["type"] . "<br />";
		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
		echo "Stored in: " . $_FILES["file"]["tmp_name"];*/

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
				$dataset = $sheet->getCell('B'.$row)->getValue();
				$stu_name=sanitizeString($dataset);

				$pass="@a@"+"1234"+"&asd";
				$pass=hash("sha256",$pass);
				$result=Querymysql("select * from collage_inforation where id='$id'");
				$row=$result->fetch_array();
				$num=$row['number'];
				$num++;
				Querymysql("update collage_inforation set number='$num' where id=$id");
				$query="insert into stu_infor(stu_num,name,pass,gender,coll_info,maj_infor,collage) values('$stu_num','$stu_name','$pass','unclear','unclear','unclear',$id)";
				$result = $conn->query($query);
				if(!$result) //die($conn->error);
					$error=$error."add $stu_num wrong,maybe already exists <br>";
				else
					$error=$error."add $stu_num succeed<br>";
			} 
			$_SESSION['collage_id']=null;
		}
	}

	echo <<<_END
	$error<br>
	为了减少不必要的麻烦，请参考模板<br>
	<a href='download.php?filepath=moban\\piliangdaorumoban.xlsx'>下载模板</a><br>
<form action="stu_add_quick.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" /> 
<br />
<input type="submit" name="import" value="Submit" />
</form>
<a href='collage_admin.php'>返回</a><br>
_END;
?>