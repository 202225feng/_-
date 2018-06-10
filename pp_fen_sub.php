<?php
	require_once "header.php";
	if(isset($_POST['sure']))
	{
		$e_id=sanitizeString($_POST['eid']);
		$p_id=sanitizeString($_POST['pid']);
		$u_id=sanitizeString($_POST['uid']);
		$z_fen=sanitizeString($_POST['zfen']);
		$tf1=sanitizeString($_POST['fen1']);
		$timeuse=sanitizeString($_POST['timeuse']);
		$pingjia =sanitizeString($_POST['pingjia']);
		$fen=$_POST['fen'];
		$ff=0;
		$cor=0;
		$zz=0;
		foreach ($fen as $value) {
			$ff+=$value;
			$zz++;
			if($value!=0)
				$cor++;
		}
		$tf2=$ff-$tf1;
		$rate=$cor*1.0/$zz;
		$result=Querymysql("select * from exam_read where e_id='$e_id' and p_id='$p_id' and user='$u_id'");
		if($result->num_rows)
		{
			$row=$result->fetch_array();
			$id=$row['id'];
			$query="update exam_read set timeuse='$timeuse',fen='$ff',c_rate='$rate',z_fen='$z_fen',ft1='$tf1',ft2='$tf2',pingjia='$pingjia' where id='$id'";
			Querymysql($query);
		}
		else
		{
			$query="insert into exam_read(id,e_id,p_id,user,timeuse,fen,c_rate,z_fen,ft1,ft2,pingjia) values(null,'$e_id','$p_id','$u_id','$timeuse','$ff','$rate','$z_fen','$tf1','$tf2','$pingjia')";
			Querymysql($query);
		}
		echo <<<_END
		<script>
		alert('OK，5秒后自动跳转');
		window.setTimeout("window.location='e_p_info.php?viewe=$e_id'",500);
		</script>
_END;
	}
?>