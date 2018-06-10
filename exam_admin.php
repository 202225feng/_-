<?php
	require_once "header.php";

	if(isset($_GET['viewp'])&&isset($_GET['viewc'])&&isset($_GET['viewe']))
	{
		$ve_id=sanitizeString($_GET['viewe']);
		$cour_id=sanitizeString($_GET['viewc']);
		$p_id=sanitizeString($_GET['viewp']);
		$result=Querymysql("select * from qbase_book");
	
		$result=Querymysql("select * from paper_ques where paper_id='$p_id' order by q_type");
		echo "<table border><tr><th>题号</th><th>题库路径</th><th>题目内容</th><th>题型</th></tr>";
		$types = array("","单选","多选","判断","填空","简答");
		for($i=0;$i<$result->num_rows;$i++)
		{
			$row=$result->fetch_array();
			$q_id=$row['q_id'];
			$q_type=$row['q_type'];
			$book_name=$row['book_name'];
			$cha_name=$row['cha_name'];
			$result1=Querymysql("select * from question where id='$q_id'");
			$row1=$result1->fetch_array();
			$exits=$row1['exits'];
			echo "<tr><th>$q_id</th><th>$book_name / $cha_name</th><th>$exits</th><th>$types[$q_type]</th></tr>";
		}
		
		echo "</table>";
		die("</body></html>");
	}

	if(isset($_GET['viewc'])&&isset($_GET['viewe']))
	{
		$fen=array(0,0,0,0,0,0);
		$ve_id=sanitizeString($_GET['viewe']);
		$cour_id=sanitizeString($_GET['viewc']);

		$result=Querymysql("select * from exam_paper where ex_id='$ve_id'");
		echo "<div id='pfen'><table border><tr><th>题目数量(每提分数)</th><th>单选</th><th>多选</th><th>判断</th><th>填空</th><th>简答</th><th>总计</th><th>修改每题分数</th></tr>";
		for($i=0;$i<$result->num_rows;$i++)
		{
			$row=$result->fetch_array();
			$p_name=$row['paper_name'];
			$pa_id=$row['pa_id'];
			$result1=Querymysql("select * from e_p_fen where e_id='$ve_id' and p_id='$pa_id'");
			$ff=array(0,0,0,0,0,0);
			if($result1->num_rows)
			{
				$row1=$result1->fetch_array();
				for($j=1;$j<=5;$j++)
					$ff[$j]=$row1["t$j"];
			}
			$result2=Querymysql("select q_type,count(q_type) num from paper_ques where paper_id='$pa_id' group by q_type");
			$num=array(0,0,0,0,0,0);
			for($k=0;$k<$result2->num_rows;$k++)
			{
				$row2=$result2->fetch_array();
				$n=$row2['q_type'];
				$m=$row2['num'];
				$num[$n]=$m;
			}
			$all=0;
			echo "<tr><td><a href='exam_admin.php?viewc=$cour_id&viewe=$ve_id&viewp=$pa_id'>$p_name</a></td>";
			for($k=1;$k<=5;$k++)
			{
				echo "<td>$num[$k]($ff[$k])</td>";
				$all+=$num[$k]*$ff[$k];
				$fen[$k]+=$num[$k]*$ff[$k];
			}
			echo <<<_end

			<td>$all</td><td><button onclick="change_fen($ve_id,$pa_id,'pfen','show_fen.php',$cour_id)">修改</button></td></tr>
_end;
		}
		for($all=0,$k=1;$k<=5;$k++)
		{
			$all+=$fen[$k];
		}
		echo "<tr><td>总计</td><td>$fen[1]</td><td>$fen[2]</td><td>$fen[3]</td><td>$fen[4]</td><td>$fen[5]</td><td>$all</td></tr>";
		echo "</div></table>";
		//echo "<a href='e_p_info.php?viewe=$ve_id'>查看考生信息</a>";
		echo <<<_end
	<div class="content">
            <div class="buttons">
                <div class="button" id="one">
                        <a href='exam_add.php?eid=$ve_id&cid=$cour_id'>添加试卷</a>
                </div>
                <div class="button">
                    <a href="e_p_info.php?viewe=$ve_id" style="text-decoration: none;color: black">
                    查看考生信息
                </a>
                </div>
            </div>
        </div>
_end;

		die("</body></html>");
	}

	if(isset($_GET['viewc']))
	{

		$vc_id=sanitizeString($_GET['viewc']);
		echo "<a href='exam_add.php?cid=$vc_id'>创建考试</a><br>";
		$result1=Querymysql("select * from exam where cour_num='$vc_id'");
		echo "<table cellspacing='0'><tr> <th>考试名称</th><th>开始时间</th> <th>结束时间</th><th>状态</th><th>描述</th><th>修改</th><th>删除</th></tr>";
		for($i=0;$i<$result1->num_rows;$i++)
		{
			$row=$result1->fetch_array();
			$e_id=$row['id'];
			$e_name=$row['name'];
			$cour_num=$row['cour_num'];
			$begin_date=$row['begin_date'];
			$end_date=$row['end_date'];
			$exits=$row['exits'];
			$today = date('Y/m/d\ H:i:s');
			echo "<tr><td><a href='exam_admin.php?viewc=$vc_id&viewe=$e_id'>$e_name</a></td><td>$begin_date</td><td>$end_date</td><td>";
			if((strtotime($begin_date)-strtotime($today))>0)
				echo "考试未开始";
			else if((strtotime($end_date)-strtotime($today))>0)
				echo "考试中";
			else echo "考试已结束";
			echo <<<_end
			</td><td>$exits</td><td>
			<form action="exam_change.php" method="post">
			<input type="hidden" name="eid" value="$e_id">
			<input type="hidden" name="cid" value="$cour_num">
		    <input type="submit" name="change" value="修改">
		    </form>
			</td>
			<td>
			<form action="exam_change.php" method="post">
			<input type="hidden" name="eid" value="$e_id">
			<input type="hidden" name="cid" value="$cour_num">
		    <input type="submit" name="drop" value="删除">
		    </form>
		    </td>
		    </tr>
_end;
		}
		echo "</table>";
		die("</body></html>");
	}

	echo <<<_end
	<div id="modal-container">
            <div class="modal-background">
                <div class="modal" id='mol_add_exam'>

                </div>
            </div>
        </div>
_end;
	echo "<div id='fdw-pricing-table'>";
	if($value==1)
		$result =Querymysql("select * from cour_info");
	else
		$result=Querymysql("select * from cour_info where cour_num in (select cour_num from teacher_cour where tea_user='$user')");
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$cour_num=$row['cour_num'];
		$cour_name=$row['cour_name'];
		$result1=Querymysql("select * from exam where cour_num='$cour_num'");

		echo <<<_end
		<div class="plan plan1">
                <div class="header">
                    <a href="exam_admin.php?viewc=$cour_num" style="color: black;text-decoration: none;">
                        $cour_name
                    </a>
                </div>
                <div class="monthly">
                    考试数量：$result1->num_rows
                </div>
                <div class="detail"> <b>
                考试:<br>
_end;
		for($j=0;$j<$result1->num_rows;$j++)
		{
			$row1=$result1->fetch_array();
			$e_id=$row1['id'];
			$e_name=$row1['name'];
			echo <<<_end
<b>
                               $e_name
                            </b>
                            <br>
_end;
		}
		echo <<<_end
	</div>
                <div class="button" id="one" onclick="changeinfo($cour_num,'exam_add.php','mol_add_exam')")>
                    <a class="signup" href="#" >
                        创建考试
                    </a>
                </div>
            </div>
_end;
	}
	echo <<<_end
</div>
        <script src="js/jquery-3.3.1.min.js">
        </script>
        <script src="js/but.js" type="text/javascript">
        </script>
_end;
?>
</body></html>