<?php
	require_once "function.php";
	$p_id=sanitizeString($_POST['pid']);
	$e_id=sanitizeString($_POST['eid']);
	$t1=sanitizeString($_POST['t1']);
	$t2=sanitizeString($_POST['t2']);
	$t3=sanitizeString($_POST['t3']);
	$t4=sanitizeString($_POST['t4']);
	$t5=sanitizeString($_POST['t5']);
	$result=Querymysql("select * from e_p_fen where e_id='$e_id' and p_id='$p_id'");
	if($result->num_rows)
	{
		Querymysql("update e_p_fen set t1='$t1',t2='$t2',t3='$t3',t4='$t4',t5='$t5' where e_id='$e_id' and p_id='$p_id'");
	}
	else
	{
		Querymysql("insert into e_p_fen(id,e_id,p_id,t1,t2,t3,t4,t5) values(null,'$e_id','$p_id','$t1','$t2','$t3','$t4','$t5')");
	}
?>