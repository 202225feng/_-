<?php
	require_once "header.php";

	if(isset($_GET['viewb'])&&isset($_GET['viewc']))
	{
		$b_id=sanitizeString($_GET['viewb']);
		$c_id=sanitizeString($_GET['viewc']);

		if(isset($_GET['type']))
		{
			//echo "<a href='quest_admin.php?viewb=$b_id&viewc=$c_id'>返回</a><br><br>";
			$qtype=sanitizeString($_GET['type']);
			echo <<<_end
			<center>
<div class="content">
            <div class="buttons">
                <div class="button" id="one">
                        <a href='quest_add.php?type=3&b_id=1&c_id=1&qtype=$qtype'>添加试题</a>
                </div>
            </div>
        </div>
	</center>
_end;
			//echo "<a id = 'com' href='quest_add.php?type=3&b_id=$b_id&c_id=$c_id&qtype=$qtype'>添加试题</a><br><br>";
			$result=Querymysql("select * from question where book_id='$b_id' and cha_id='$c_id' and types='$qtype' ");
			echo "<form method='post' action='quest_trans.php'><table id = 'nor'><tr><th id='xuan'>选择</th><th id='tou'>题目内容</th><th>答案</th><th>难度</th><th>操作</th></tr>";
			for($i=0;$i< $result->num_rows;$i++)
			{
				$row=$result->fetch_array();
				$q_id=$row['id'];
				$exits=sanitizeString($row['exits']);
				$anss = array();
				for($j=1;$row["ans$j"]!='';$j++)
				{
					$anss["$j"]=htmlentities($row["ans$j"]);
				}
				$nandu=$row['nandu'];
				$answer=$row['answer'];
				echo "<tr><td><input type='checkbox' name='select[]' value='$q_id'></td><td>$exits<br>";
				$l="A";
				foreach($anss as $item)
				{
					echo "$l :".$item."<br>";
					$l++;
				}
				echo "</td><td>$answer</td><td>$nandu</td><td><a href='quest_change.php?q_id=$q_id'>修改</a></td></tr>";
			}
			echo "</table><center>";
			echo "<div id='func'><br>
			<div id='addr'>";
			$result=Querymysql("select * from qbase_book");
			echo "<select name='sel_b' onchange='qb_change(this)'>";
			for($i=0;$i<$result->num_rows;$i++)
			{
				$row=$result->fetch_array();
				$tb_id=$row['id'];
				$tb_name=$row['name'];
				if($tb_id==$b_id)
				{
					$b_name=$tb_name;
					echo "<option value='$tb_id' selected = 'selected'>$tb_name</option>";
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
					echo "<option value='$tc_id' selected = 'selected'>$tc_name</option>";
				else
				echo "<option value='$tc_id'>$tc_name</option>";
			}
			echo <<<_end
			</select>
			</div>
			<br>
			<button class="mov" type='submit' value='将所选内容复制到' name='copy'>将所选内容复制到'</button>
			<button class="mov" type='submit' value='将所选内容移动到' name='move'>将所选内容移动到</button>
			<br><br>
		</div>
	</center>
_end;
			die("</form></body></html>");
		}
		echo <<<_end
<div id="both">
                <table cellspacing="0">
                    <tr>
                        <th>
                            客观题
                        </th>
                        <th>
                            主观题
                        </th> 
                    </tr>
                    <tr>
                        <td>
                            <a href="quest_admin.php?viewb=$b_id&viewc=$c_id&type=1">
                                单择题
                            </a>
                        </td>
                        <td>
                            <a href="quest_admin.php?viewb=$b_id&viewc=$c_id&type=4">
                                填空题
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="quest_admin.php?viewb=$b_id&viewc=$c_id&type=2">
                                多择题
                            </a>
                        </td>
                        <td>
                            <a href="quest_admin.php?viewb=$b_id&viewc=$c_id&type=5">
                                简答题
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="quest_admin.php?viewb=$b_id&viewc=$c_id&type=3">
                                判断题
                            </a>
                        </td>
                        <td>
                            <a href="quest_admin.php?viewb=$b_id&viewc=$c_id&type=6">
                                综合题
                            </a>
                        </td>
                    </tr>
                </table>
                <div class="content" >
                            <div class="buttons">
                                <div class="button" >
                                <a href="quest_admin.php?viewb=1" style="text-decoration: none">
                                返回
                                 </a>
                             </div>
                         </div>
                     </div>
            </div>
_end;
		
		die("</body></html>");
	}

	if(isset($_GET['viewb']))
	{
		$b_id=sanitizeString($_GET['viewb']);
		
		$result=Querymysql("select * from qbase_chapter where book_id='$b_id'");
		echo "<table id='nor'><tr><th>题集名称</th><th>试题数量</th><th>描述</th></tr>";
		for($i=0;$i<$result->num_rows;$i++)
		{
			$row=$result->fetch_array();
			$qc_id=$row['id'];
			$qc_name=$row['name'];
			$qc_num=$row['number'];
			$qc_exits=$row['exits'];
			echo "<tr><td><a href='quest_admin.php?viewb=$b_id&viewc=$qc_id'>$qc_name</a></td><td>$qc_num</td><td>$qc_exits</td></tr>";
		}
		echo "</table>";
		echo <<<_end
<div class="content">
            <div class="buttons">
                <div class="button">
                    <a href="quest_add.php?type=2&b_id=$b_id" style="text-decoration: none;color: black">
                   添加题集
                </a>
                </div>
            </div>
        </div>

_end;
		die("</body></html>");
	}
	
	$result=Querymysql("select * from qbase_book");
	echo "<table id='nor'><tr><th>题库名称</th><th>管理人</th><th>题集数量</th><th>描述</th></tr>";
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$qb_id=$row['id'];
		$qb_name=$row['name'];
		$qb_user=$row['adminuser'];
		$qb_num=$row['number'];
		$qb_exits=$row['exits'];
		echo "<tr><td><a href='quest_admin.php?viewb=$qb_id'>$qb_name</a></td><td>$qb_user</td><td>$qb_num</td><td>$qb_exits</td></tr>";
	}
	echo "</table>";
?>
</body></html>