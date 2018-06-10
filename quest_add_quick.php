<?php
	require_once "header.php";
	require_once "PHPExcel-1.8/Classes/PHPExcel.php";
echo "<link rel='stylesheet' type='text/css' href='css/biaodan.css'/>";

	$error='';
	if(isset($_POST['import']))
	{
		$b_id=sanitizeString($_POST['sel_b']);
		$c_id=sanitizeString($_POST['sel_c']);
		$name=iconv("UTF-8","gb2312", $_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"],
		"upload/" . $name);
	    $filename="upload/".$name;
	    $reader = PHPExcel_IOFactory::createReader('Excel2007');
		$PHPExcel = $reader->load($filename); 
		$sheet = $PHPExcel->getSheet(0); 
		$highestRow = $sheet->getHighestRow();
		$highestColumm = $sheet->getHighestColumn();
		$result=Querymysql("select * from qbase_chapter where id='$c_id'");
		$row=$result->fetch_array();
		$num=$row['number'];
		for ($row = 2; $row <= $highestRow; $row++)
		{
			$dataset = $sheet->getCell('A'.$row)->getValue();
			$exits=$dataset;
			$dataset = $sheet->getCell('B'.$row)->getValue();
			$qtype=$dataset;
			$dataset = $sheet->getCell('C'.$row)->getValue();
			$answer=$dataset;
			$ans=array();
			for($i=0,$j="D";$i<7;$i++)
			{
				$dataset = $sheet->getCell($j.$row)->getValue();
				$ans[$i]=$dataset;
				$j++;
			}
			$dataset = $sheet->getCell('K'.$row)->getValue();
			if($dataset=='')
				$nandu="中等";
			else
				$nandu=$dataset;
			$query="insert into question(id,book_id,cha_id,types,exits,answer,nandu,ans1,ans2,ans3,ans4,ans5,ans6,ans7) values(null,'$b_id','$c_id','$qtype','$exits','$answer','$nandu','$ans[0]','$ans[1]','$ans[2]','$ans[3]','$ans[4]','$ans[5]','$ans[6]')";
			$result=$conn->query($query);
			$i=$row-1;
			if(!$result)
				$error=$error."第$i 题 导入失败<br>";
			else
			{
				$num++;
				Querymysql("update qbase_chapter set number='$num' where id='$c_id'");
				$error=$error."第$i 题 导入成功<br>";
			}

		}
	}

	echo <<<_END
	<center>$error<br>
	为了减少不必要的麻烦，请参考模板<br>
	<a href='download.php?filepath=moban\\shitimoban.xlsx'>下载模板</a><br></center>
<form action="quest_add_quick.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" /> 
<br />
_END;
	$result=Querymysql("select * from qbase_book");
	echo "导入到：<select name='sel_b' onchange='qb_change(this)'>";
	$bb_id='';
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$tb_id=$row['id'];
		if($bb_id=='')
			$bb_id=$tb_id;
		$tb_name=$row['name'];
		echo "<option value='$tb_id'>$tb_name</option>";
	}
	echo "</select><select name='sel_c' id='sel_c'>";
	$result=Querymysql("select * from qbase_chapter where book_id='$bb_id'");
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$tc_id=$row['id'];
		$tc_name=$row['name'];
		echo "<option value='$tc_id'>$tc_name</option>";
		}
		echo "</select><br>";
echo <<<_END
<input type="submit" name="import" value="Submit" />
<a href='quest_admin.php'>返回</a><br>
</form>

_END;
?>