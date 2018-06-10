<?php
    require_once "header.php";

    if(isset($_POST['change']))
    {
        $cour_id=sanitizeString($_POST['cid']);
    	$exam_id=sanitizeString($_POST['eid']);
        $result=Querymysql("select * from exam where id='$exam_id'");
        $row=$result->fetch_array();
        $ex_name=$row['name'];
        $ex_exits=$row['exits'];
        $be_time=$row['begin_date'];
        $en_time=$row['end_date'];
    	echo <<<_end
<form action="exam_change.php" method="post">
考试名称：<input type="text" name="name" value="$ex_name"><br>
描述<textarea name="text" cols='50' rows='3' value="$ex_exits"></textarea><br>
开始时间<input type="datetime-local" name="begintime" value="$be_time"><br>
结束时间<input type="datetime-local" name="endtime" value="en_time"><br>
<input type='hidden' value='$exam_id' name='eid'>
<input type='hidden' value='$cour_id' name='cid'>
<input type="submit" name="sure" value="修改">
<input type="submit" name="cancel" value="取消">
</form>
_end;
    }
    if(isset($_POST['drop']))
    {
        $exam_id=sanitizeString($_POST['eid']);
        $cour_id=sanitizeString($_POST['cid']);
        $result=Querymysql("select * from exam where id='$exam_id'");
        $row=$result->fetch_array();
        $ex_name=$row['name'];
        Querymysql("delete from exam where id='$exam_id'");
        echo "<script>alert('已经删除考试$ex_name')</script>";
        header("Location:exam_admin.php?viewc=$cour_id");
    }
    if(isset($_POST['sure']))
    {
        $cour_id=sanitizeString($_POST['cid']);
    	$exam_id =sanitizeString($_POST['eid']);
		$ex_name=sanitizeString($_POST['name']);
		$ex_exits=sanitizeString($_POST['text']);
		$be_time=sanitizeString($_POST['begintime']);
		$en_time=sanitizeString($_POST['endtime']);
		Querymysql("update exam set name='$ex_name',exits='$ex_exits',begin_date='$be_time',end_date='$en_time' where id='$exam_id'");
		echo "<script>alert('修改完成')</script>";
		header("Location:exam_admin.php?viewc=$cour_id");
    }
    if(isset($_POST['cancel']))
    {
        $cour_id=sanitizeString($_POST['cid']);
    	header("Location:exam_admin.php?viewc=$cour_id");
    }

?>