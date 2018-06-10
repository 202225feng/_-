<?php 
	require_once "header.php";

	if(isset($_GET['viewp']))
	{
		$p_id=sanitizeString($_GET['viewp']);
		$cour_id=sanitizeString($_GET['viewc']);
		$result=Querymysql("select * from qbase_book");
	echo "<form action='paper_ques_add.php' method='post'> 查询：<select name='sel_b' onchange='qb_change(this)'>";
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
		echo "</select>";
echo <<<_END
<input type='hidden' value='$p_id' name='pid'>
<input type="submit" name="import" value="检索">
</form>
_END;
		$result=Querymysql("select * from paper_ques where paper_id='$p_id' order by q_type");
		echo "<form action='paper_trans.php' method='post'><table border><tr><th>选择</th><th>题号</th><th>题库路径</th><th>题目内容</th><th>题型</th></tr>";
		$types = array("","单选","多选","判断","填空","简答");
		for($i=0;$i<$result->num_rows;$i++)
		{
			$row=$result->fetch_array();
			$pq_id=$row['id'];
			$q_id=$row['q_id'];
			$q_type=$row['q_type'];
			$book_name=$row['book_name'];
			$cha_name=$row['cha_name'];
			$result1=Querymysql("select * from question where id='$q_id'");
			$row1=$result1->fetch_array();
			$exits=$row1['exits'];
			echo "<tr><th><input type='checkbox' name='select[]' value='$pq_id'></th><th>$q_id</th><th>$book_name / $cha_name</th><th>$exits</th><th>$types[$q_type]</th></tr>";
		}
		echo "<tr><th><input type='submit' value='删除所选题目' name='delete'></th><th></th>";
			echo "<th><input type='submit' value='将所选题目移动到' name='move'><input type='submit' value='将所选题目复制到' name='copy'></th>";
			$result=Querymysql("select * from paper where cour_num='$cour_id'");
			echo "<th><select name='sel_p'>";
			for($i=0;$i<$result->num_rows;$i++)
			{
				$row=$result->fetch_array();
				if($row['id']==$p_id)
					echo "<option value='".$row['id']."' selected = 'selected'>".$row['paper_name']."</option>";
				else
					echo "<option value='".$row['id']."'>".$row['paper_name']."</option>";
			}
			echo "</select></th>";
			echo "<input type='hidden' value='$p_id' name='papid'><input type='hidden' value='$cour_id' name='couid'>";
		echo "</table></form>";
		die("</body></html>");
	}

	if(isset($_GET['viewc']))
	{
		$cour_num=sanitizeString($_GET['viewc']);
		$cour_name=sanitizeString($_GET['cname']);
		echo "<a href='paper_create.php?cid=$cour_num&cname=$cour_name'>创建试卷</a><br>";
		$result=Querymysql("select * from paper where cour_num='$cour_num'");
		echo "<table border><tr><th>试卷名称</th><th>所属课程</th><th>管理教师</th><th>创建时间</th></tr>";
		for($i=0;$i<$result->num_rows;$i++)
		{
			$row=$result->fetch_array();
			$p_id=$row['id'];
			$adm_tea=$row['admin_tea'];
			$p_name=$row['paper_name'];
			$p_time=$row['time'];
			echo "<tr><th><a href='paper_admin.php?viewc=$cour_num&viewp=$p_id'> $p_name</a></th><th>$cour_name</th><th>$adm_tea</th><th>$p_time</th></tr>";
		}

		die("</body></html>");
	}

	$result=Querymysql("select * from cour_info");
	echo "<table border><tr><th>Group</th><th>试卷数量</th></tr>";
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$cour_num=$row['cour_num'];
		$cour_name=$row['cour_name'];
		$result1=Querymysql("select * from paper where cour_num='$cour_num'");
		echo "<tr><th><a href='paper_admin.php?viewc=$cour_num&cname=$cour_name' >$cour_name</a></th><th>$result1->num_rows</th></tr>";
	}
?>
</body></html>