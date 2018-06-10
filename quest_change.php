<?php
	require_once "header.php";
	if(isset($_GET['sure']))
	{
			$tem=sanitizeString($_GET['add']);
			$addr=explode(",",$tem);
			$qexits=sanitizeString($_GET['text']);
			$qanswer=sanitizeString($_GET['answer']);
			$nandu=sanitizeString($_GET['nandu']);
			$query="update question set exits='$qexits',answer='$qanswer',nandu='$nandu'";
			if($addr[2]==1||$addr[2]==2)
			for($i=0;$i<7;$i++)
			{
				$j=$i+1;
				$ans=sanitizeString($_GET["ans$i"]);
				$query=$query.",ans$j='$ans'";
			}
			else
			{
				if($addr[2]==3)
					$query=$query.",ans1='对',ans2='错'";
			}
			$query=$query." where id='$addr[2]'";
			echo $query;
			Querymysql($query);
			echo "OK<a href='quest_admin.php?viewb=".$addr[0]."&viewc=".$addr[1]."&type=".$addr[2]."'>返回</a>";
	}
	if(isset($_GET['q_id']))
	$id=sanitizeString($_GET['q_id']);
	else die();

	$result=Querymysql("select * from question where id='$id'");
	$row=$result->fetch_array();
	$b_id=$row['book_id'];
	$c_id=$row['cha_id'];
	$type=$row['types'];
	$exits=$row['exits'];
	$answer=$row['answer'];
	$nandu=$row['nandu'];
	echo <<<_end
<form method="get" action="quest_change.php">
<input type="hidden" name="sure" value="3">
<input type="hidden" value="$b_id,$c_id,$type" name="add">
题目内容：<textarea name='text' cols='50' rows='3'>$exits</textarea><br>
_end;
	if($type==1||$type==2)
	{
		$ans=array();
		for($i=0;$i<7;$i++)
		{
			$j=$i+1;
			$ans[$i]=$row["ans$j"];
		}
		echo "<table border><tr><th>选项 ：</th></tr>";
		for($i=0,$j="A"; $i<7;$i++,$j++)
		{
			echo <<<_end
			<tr><th>$j :</th><th><input type="text" name="ans$i" value="$ans[$i]"></th></tr>
_end;
		}
		echo <<<_end
</table><br>答案：<input type='text' name='answer' value="$answer"><br>
难度：
_end;
	}
	else if($type==3)
	{
		echo "答案:";
if($answer=="对")
echo <<<_end
<input type="radio" name="answer" value="对" checked>对<input type="radio" name="qans" value="错">错<br> 
难度：
_end;
else
echo <<<_end
<input type="radio" name="answer" value="对">对<input type="radio" name="qans" value="错" checked>错<br> 
难度：
_end;
	}
	else if($type==4)
	{
		echo <<<_end
注意：当题目内容中有需要填空的地方，请用“____”4个下划线表示。例如：“____是在线考试系统。”<br>
答案：<input type="text" name="answer" value="$answer"><br>
注意：当题目中有多个填空时，请在答案中用“|”线分割答案。例如：“答案1|答案2”<br>
_end;
	}
	else
	{
		echo "答案：<input type='text' name='answer' value='$answer'><br>";
	}
if($nandu=="困难")
	echo<<<_end
<input type="radio" name="nandu" value="困难" checked>困难
<input type="radio" name="nandu" value="中等">中等
<input type="radio" name="nandu" value="简单">简单<br>
<input type="submit" value="添加">
</form>
_end;
if($nandu=="中等")
	echo <<<_end
<input type="radio" name="nandu" value="困难">困难
<input type="radio" name="nandu" value="中等" checked>中等
<input type="radio" name="nandu" value="简单">简单<br>
<input type="submit" value="添加">
</form>
_end;
if($nandu=="简单")
	echo <<<_end
<input type="radio" name="nandu" value="困难">困难
<input type="radio" name="nandu" value="中等">中等
<input type="radio" name="nandu" value="简单" checked>简单<br>
<input type="submit" value="添加">
</form>
_end;
?>