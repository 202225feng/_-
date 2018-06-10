<?php
	require_once "function.php";
	$p_id=sanitizeString($_POST['pid']);
	$e_id=sanitizeString($_POST['eid']);
	$c_id=sanitizeString($_POST['cid']);
	$result2=Querymysql("select q_type,count(q_type) num from paper_ques where paper_id='$p_id' group by q_type");
	$num=array(0,0,0,0,0,0);
	for($k=0;$k<$result2->num_rows;$k++)
	{
		$row2=$result2->fetch_array();
		$n=$row2['q_type'];
		$m=$row2['num'];
		$num[$n]=$m;
	}
	$result1=Querymysql("select * from e_p_fen where e_id='$e_id' and p_id='$p_id'");
	$ff=array(0,0,0,0,0,0);
	if($result1->num_rows)
	{
		$row1=$result1->fetch_array();
		for($j=1;$j<=5;$j++)
		$ff[$j]=$row1["t$j"];
	}
	echo "<table border><tr><th></th><th>单选</th><th>多选</th><th>判断</th><th>填空</th><th>简答</th></tr><tr><td>每题分数</td>";
	for($i=1;$i<=5;$i++)
	{
		echo "<td><input type='text' id='t$i' style='width:29px' onblur='chafen()' value='$ff[$i]'></td>";
	}
	echo "</tr><tr><td>题型个数</td>";
	for($i=1;$i<=5;$i++)
	{
		echo "<td><font id='f$i'>$num[$i]</font></td>";
	}
	echo "</tr><tr><td>总分</td>";
	for($i=1;$i<=5;$i++)
	{
		$z=$ff[$i]*$num[$i];
		echo "<td><font id='z$i'>$z</font></td>";
	}
	echo "</tr></table><button onclick='sub_fen($e_id,$p_id,$c_id)'>确定</button>";
?>