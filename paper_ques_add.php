<?php
	require_once "header.php";

	if(isset($_POST['pid'])&&isset($_POST['sel_b'])&&isset($_POST['sel_c']))
	{
		$p_id=sanitizeString($_POST['pid']);
		$b_id=sanitizeString($_POST['sel_b']);
		$c_id=sanitizeString($_POST['sel_c']);
	}

	if(isset($_POST['add']))
	{
		if(isset($_POST['select']))
		{
			$q_id=$_POST['select'];
			$b_name=$_POST['bname'];
			$c_name=$_POST['cname'];
			foreach ($q_id as $item) {
			$result=Querymysql("select * from question where id='$item'");
			$row=$result->fetch_array();
			$q_type=$row['types'];
			$query="insert into paper_ques(id,paper_id,q_id,q_type,book_name,cha_name) values(null,'$p_id','$item','$q_type','$b_name','$c_name')";
			Querymysql($query);
			echo "第$item 题添加成功<br>";
			}
		}
		else
			echo "请选择题目<br>";
	}

	$result=Querymysql("select * from qbase_book");
	echo "<form action='paper_ques_add.php' method='post'> 查询：<select name='sel_b' onchange='qb_change(this)'>";
	for($i=0;$i<$result->num_rows;$i++)
	{

		$row=$result->fetch_array();
		$tb_id=$row['id'];
		$tb_name=$row['name'];
		if($tb_id==$b_id)
		{
			echo "<option value='$tb_id' selected = 'selected'>$tb_name</option>";
			$book_name=$tb_name;
		}
		else
			echo "<option value='$tb_id'>$tb_name</option>";
	}
	echo "</select><select name='sel_c' id='sel_c'>";
	$result=Querymysql("select * from qbase_chapter where book_id='$b_id'");
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$tc_id=$row['id'];
		$tc_name=$row['name'];
		if($tc_id==$c_id)
		{
			echo "<option value='$tc_id' selected = 'selected'>$tc_name</option>";
			$cha_name=$tc_name;
		}
		else
			echo "<option value='$tc_id'>$tc_name</option>";
	}
		echo "</select>";
echo <<<_END
<input type='hidden' value='$p_id' name='pid'>
<input type="submit" name="import" value="检索">
</form>
_END;


	
	$result=Querymysql("select * from question where book_id='$b_id' and cha_id='$c_id' order by types");
	echo "<form method='post' action='paper_ques_add.php'><table border><tr><th>选择</th><th>题型</th><th>题库id</th><th>题目内容</th><th>难度</th>";
	$type=array("","单选","多选","判断","填空","简答");
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$q_id=$row['id'];
		$q_exits=$row['exits'];
		$q_type=$row['types'];
		$q_nandu=$row['nandu'];
		echo "<tr><th><input type='checkbox' value='$q_id' name='select[]'></th><th>$type[$q_type]</th><th>$q_id</th><th>$q_exits</th><th>$q_nandu</th></tr>";
	}
	echo "</table>
		<input type='hidden' value='$p_id' name='pid'>
		<input type='hidden' value='$book_name' name='bname'>
		<input type='hidden' value='$b_id' name='sel_b'>
		<input type='hidden' value='$cha_name' name='cname'>
		<input type='hidden' value='$c_id' name='sel_c'>
		<input type='submit' value='添加所选题目' name='add'>
		</form>";
?>
</body></html>