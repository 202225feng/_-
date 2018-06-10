<?php
	session_start();

	require_once 'function.php';
	if(isset($_SESSION['user'])&&isset($_SESSION['value']))
	{
		$user =$_SESSION['user'];
		$value=$_SESSION['value'];
		$logged = TRUE;
	}
	else die();

	if(isset($_POST['sure']))
	{
		$cour_id =sanitizeString($_POST['cid']);
		$ex_name=sanitizeString($_POST['name']);
		$ex_exits=sanitizeString($_POST['text']);
		$be_time=sanitizeString($_POST['begintime']);
		$en_time=sanitizeString($_POST['endtime']);
		Querymysql("insert into exam(id,cour_num,name,begin_date,end_date,exits) values(null,'$cour_id','$ex_name','$be_time','$en_time','$ex_exits')");
		//echo "OK<a href='exam_admin.php?viewc=$cour_id'>返回</a><br>";
		echo <<<_END
		<script>
		alert('OK，5秒后自动跳转');
		window.setTimeout("window.location='exam_admin.php?viewc=$cour_id'",500);
		</script>
_END;
		die("</body></html>");
	}

	if(isset($_POST['add']))
	{
		$paper_id=$_POST['select'];
		$ex_id=sanitizeString($_POST['eid']);
		$c_id=sanitizeString($_POST['cid']);
		foreach ($paper_id as $item) {
			$result=Querymysql("select * from paper where id='$item'");
			$row=$result->fetch_array();
			$paper_name=$row['paper_name'];
			$query="insert into exam_paper(id,ex_id,pa_id,paper_name) values(null,'$ex_id','$item','$paper_name')";
			//echo $query."<br>".$item."<br>";
			Querymysql($query);
			
		}
		
		echo<<<_END
		<script>
		alert('OK，5秒后自动跳转');
		window.setTimeout("window.location='exam_admin.php?viewc=$c_id&viewe=$ex_id'",500);
		</script>
_END;
		die("</body></html>");
	}

	if(isset($_GET['eid'])&&isset($_GET['cid']))
	{
		$ex_id=sanitizeString($_GET['eid']);
		$c_id=sanitizeString($_GET['cid']);
		$result=Querymysql("select * from paper where cour_num='$c_id'");
		echo "<form method='post' action='exam_add.php'><table><tr><th>试卷名称</th><th>选择</th></tr>";
		for($i=0;$i<$result->num_rows;$i++)
		{
			$row=$result->fetch_array();
			echo "<tr><td><a >".$row['paper_name']."</a></td><td><input type='checkbox' name='select[]' value='".$row['id']."'></td></tr>";
		}
		echo "</table><input type='hidden' value='$ex_id' name='eid'><input type='hidden' value='$c_id' name='cid'><input type='submit' value='添加' name='add'>";

		die("</body></html>");
	}

	if(isset($_POST['cid']))
	{
		$cour_id=sanitizeString($_POST['cid']);	
		echo <<<_end
 <form action="exam_add.php" method="post">
 <table><tr><td>
                        考试名称：</td>
                        <td><input name="name" type="text"></td>
                        </tr>
                                <tr><td>描述</td><td>
                                <textarea cols="50" name="text" rows="3">
                                </textarea></td>
                                </tr>
                                    <tr><td>开始时间</td>
                                    <td><input name="begintime" type="datetime-local">
                                        </td></tr>
                                           <tr><td> 结束时间</td><td>
                                            <input name="endtime" type="datetime-local">
                                                </td></tr></table>
                                                    <input name="cid" type="hidden" value="$cour_id">
                                                        <input name="sure" type="submit" value="添加">
                                                        <a href='exam_admin.php'>
                                                            取消
                                                         </a>
                                                        
                    </form>
_end;
	}

?>
