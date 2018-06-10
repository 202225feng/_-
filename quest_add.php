<?php
	require_once "header.php";

	echo "<link rel='stylesheet' type='text/css' href='css/biaodan.css'/>";

	if(isset($_POST['sure']))
	{
		$type=sanitizeString($_POST['sure']);
		if($type==1)
		{
			$bname=sanitizeString($_POST['name']);
			$buser=sanitizeString($_POST['admin_tea']);
			$exits=sanitizeString($_POST['text']);
			Querymysql("insert into qbase_book(id,name,adminuser,number,exits) values(null,'$bname','$buser',0,'$exits')");
		//	echo "OK "."<a href='quest_admin.php'>返回</a><br>";
			echo <<<_end
<script>
		alert('OK，5秒后自动跳转');
		window.setTimeout("window.location='quest_admin.php'",500);
		</script>
_end;
		}
		else if($type==2)
		{
			$b_id=sanitizeString($_POST['b_id']);
			$cname=sanitizeString($_POST['name']);
			$cexits=sanitizeString($_POST['text']);
			Querymysql("insert into qbase_chapter(id,book_id,name,number,exits) values(null,'$b_id','$cname',0,'$cexits') ");
			$result= Querymysql("select * from qbase_book where id='$b_id'");
			$row=$result->fetch_array();
			$num=$row['number']+1;
			Querymysql("update qbase_book set number='$num' where id='$b_id'");
			//echo "OK "."<a href='quest_admin.php?viewb=$b_id'>返回</a><br>";
			echo <<<_end
<script>
		alert('OK，5秒后自动跳转');
		window.setTimeout("window.location='quest_admin.php?viewb=$b_id'",500);
		</script>
_end;
		}
		else if($type==3)
		{
			$tem=sanitizeString($_POST['add']);
			$addr=explode(",",$tem);
			$qexits=sanitizeString($_POST['text']);
			$qanswer=sanitizeString($_POST['answer']);
			$nandu=sanitizeString($_POST['nandu']);
			$query="insert into question(id,book_id,cha_id,types,exits,answer,nandu,ans1,ans2,ans3,ans4,ans5,ans6,ans7) values(null,'".$addr[0]."','".$addr[1]."','".$addr[2]."','$qexits','$qanswer','$nandu'";
			if($addr[2]==1||$addr[2]==2)
			for($i=0;$i<7;$i++)
			{
				$ans=sanitizeString($_POST["ans$i"]);
				$query=$query.",'$ans'";
			}
			else
			{
				if($addr[2]==3)
					$query=$query.",'对','错','','','','',''";
				else
					$query=$query.",'','','','','','',''";
			}
			$query=$query.")";
			//echo $query;
			Querymysql($query);
			$result=Querymysql("select * from qbase_chapter where id='$addr[1]'");
			$row=$result->fetch_array();
			$num=$row['number']+1;
			Querymysql("update qbase_chapter set number='$num' where id='$addr[1]'");
			echo <<<_end
<script>
		alert('OK，5秒后自动跳转');
		window.setTimeout("window.location='quest_admin.php?viewb=$addr[0]&viewc=$addr[1]&type=$addr[2]'",500);
		</script>
_end;
			//echo "OK<a href='quest_admin.php?viewb=".$addr[0]."&viewc=".$addr[1]."&type=".$addr[2]."'>返回</a>";
		}

	}

	if(isset($_GET['type']))
	{
		$type=sanitizeString($_GET['type']);
		if($type==1)
		{
			echo <<<_end
			<form action="quest_add.php" method="post" >
            题库名称
            <input name="name" type="text"><br>
            管理员：
_end;
			$result=Querymysql("select * from teacher_info where class='1' or class='2'");
			for ($i=0;$i< $result->num_rows;$i++)
			{ 
				$row=$result->fetch_array();
				$tea_user=$row['tea_user'];
				$tea_name=$row['tea_name'];
				echo "<input name='admin_tea' required type='radio' value='admin'>$tea_user($tea_name) ";
			}
			echo <<<_end
				<br>
				描述：<textarea name='text' cols='50' rows='3'></textarea><br> 
				<input type="hidden" value='$type' name='sure'>
				<button type="submit" value="添加">添加</button>
				</form>
_end;
		}

		else if($type==2)
		{
			$b_id=sanitizeString($_GET['b_id']);
			echo <<<_end
				<form method="post" action="quest_add.php">
				题集名称：<input type="text" name="name"><br>
				描述：<textarea name='text' cols='50' rows='3'></textarea><br> 
				<input type="hidden" name="sure" value='$type'>
				<input type="hidden" name="b_id" value='$b_id'>
				<button type="submit">添加</button>
				</form>
_end;
		}
		else if($type==3)
		{
			$b_id=sanitizeString($_GET['b_id']);
			$c_id=sanitizeString($_GET['c_id']);
			$q_type=sanitizeString($_GET['qtype']);

			if($q_type==1||$q_type==2)
			{
				echo <<<_end
		
					<form action="quest_add.php" method="post"style="font-size: medium;font-family: 黑体;text-align: center;">
					<input type="hidden" name="sure" value="3">
					<input type="hidden" value="$b_id,$c_id,$q_type" name="add">
					题目：<textarea name='text' cols='50' rows='3' style='margin:0px 0px 0px 0px;'></textarea><table cellspacing="0" ><tr><th>选项 ：</th></tr>
_end;
				for($i=0,$j="A"; $i<7;$i++,$j++)
				{
					echo <<<_end
					<tr><td class='tt'>$j :</td><td><input type="text" name="ans$i"></td></tr>
_end;
				}
				echo <<<_end
				</table><br>答案：<input type='text' name='answer'><br>
				难度：<input type="radio" name="nandu" value="困难">困难
				<input type="radio" name="nandu" value="中等" checked>中等
				<input type="radio" name="nandu" value="简单">简单<br>
				<input type="submit" value="添加">
				</form>
				

_end;
			}
			else if($q_type==3)
			{
				echo <<<_end
					<form method="post" action="quest_add.php">
					<input type="hidden" name="sure" value="3">
					<input type="hidden" value="$b_id,$c_id,$q_type" name="add">
					题目：<textarea name='text' cols='50' rows='3'></textarea>
					答案<input type="radio" name="answer" value="对">对<input type="radio" name="qans" value="错">错<br>
					难度：<input type="radio" name="nandu" value="困难">困难
					<input type="radio" name="nandu" value="中等" checked>中等
					<input type="radio" name="nandu" value="简单">简单<br>
					<input type="submit" value="添加">
					</form>
_end;
			}
			else if($q_type==4)
			{
				echo <<<_end
<form method="post" action="quest_add.php">
<input type="hidden" name="sure" value="3">
<input type="hidden" value="$b_id,$c_id,$q_type" name="add">
注意：当题目内容中有需要填空的地方，请用“____”4个下划线表示。例如：“____是在线考试系统。”<br>
题目内容：题目描述：<textarea name='text' cols='50' rows='3'></textarea><br>
注意：当题目中有多个填空时，请在答案中用“|”线分割答案。例如：“答案1|答案2”<br>
答案：<input type="text" name="answer"><br>
难度：<input type="radio" name="nandu" value="困难">困难
<input type="radio" name="nandu" value="中等" checked>中等
<input type="radio" name="nandu" value="简单">简单<br>
<input type="submit" value="添加">
</form>
_end;
			}
			else
			{
echo <<<_end
<form method="post" action="quest_add.php">
<input type="hidden" name="sure" value="3">
<input type="hidden" value="$b_id,$c_id,$q_type" name="add">
试题内容：<textarea name='text' cols='50' rows='3'></textarea><br>
答案：<input type="text" name="answer"><br>
难度：<input type="radio" name="nandu" value="困难">困难
<input type="radio" name="nandu" value="中等" checked>中等
<input type="radio" name="nandu" value="简单">简单<br>
<input type="submit" value="添加">
	</form>
_end;
			}
		}
	}
?>
</body></html>






