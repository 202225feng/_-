<?php
	require_once "zheader.php";

	if(isset($_GET['view']))
	{
		$v_c_id=sanitizeString($_GET['view']);
		$result=Querymysql("select * from stu_cour where stu_num='$user' and cour_num='$v_c_id' and status=1");
		if($result->num_rows)
		{
			$result=Querymysql("select * from exam where cour_num='$v_c_id'");
			echo <<<_end
			<div class="table-responsive">
		          <table class="table table-striped table-hover">
		            <thead>
		              <tr>
		                <th>
		                  名称
		                </th>
		                <th>
		                  开始时间
		                </th>
		                <th>
		                  结束时间
		                </th>
		                <th>
		                  主办单位
		                </th>
		              </tr>
		            </thead>
		            <tbody>
_end;
		    
			for($i=0;$i<$result->num_rows;$i++)
			{
				$row=$result->fetch_array();
				$e_id=$row['id'];
				$c_id=$row['cour_num'];
				$b_time=$row['begin_date'];
				$e_time=$row['end_date'];
				$e_name=$row['name'];
				$result1=Querymysql("select * from cour_info where cour_num='$c_id'");
				$row=$result1->fetch_array();
		        $c_name=$row['cour_name'];
				echo <<<_end
				<tr><td><a href="zexam.php?viewc=$c_id&viewe=$e_id">$e_name</a></td><td>$b_time</td><td>$e_time</td><td>$c_name</td></tr>
_end;
			}
			echo <<<_end
			</tbody>
		        </table>
		      </div>
		    </div>
_end;
		}
		else
		{
			$url="show_group.php?view=$v_c_id";
			echo <<<_end
			<div id='ask'>
				您还不在该Group是否申请加入该group<br>
				<a href='show_group.php'>取消</a> 
				<button onclick='change(ask,app)'>加入</button>
			</div>
			<div id="app" style='display:none;'>
				请输入该group邀请码：<br>
				<input type='text' id='ap'><br>
				<button onclick="apply($v_c_id,'$url')">提交</button>
			</div>
_end;
		}
		die("</body></html>");
	}

	$result=Querymysql("select * from cour_info");
	for($i=0;$i<$result->num_rows;$i++)
	{
		$row=$result->fetch_array();
		$c_id=$row['cour_num'];
		$c_name=$row['cour_name'];
		$collage=$row['collage'];
		echo "<a href='show_group.php?view=$c_id'>$c_name</a>隶属单位：$collage<br>";
	}
?>