<?php
	require_once "function.php";
	if(!session_id())
	session_start();
	if(isset($_SESSION['user'])&&isset($_SESSION['value']))
	{
		$user =$_SESSION['user'];
		$value=$_SESSION['value'];
		$logged = TRUE;
	}
	else die();
	$e_id=sanitizeString($_POST['eid']);
	$p_id=sanitizeString($_POST['pid']);
	$q_id=sanitizeString($_POST['qid']);
	$q_type=sanitizeString($_POST['types']);
	$num=sanitizeString($_POST['num']);
	$ans=sanitizeString($_POST['ans']);
	$time=sanitizeString($_POST['time']);
	if($num==0)
	{
		$_SESSION['time']=$time;
		$result=Querymysql("select * from paper_ques where paper_id=$p_id order by q_type");
		$_SESSION['quest']=array();
		$_SESSION['quest'][0]=$result->num_rows;
		for($i=0;$i<$result->num_rows;$i++)
		{
			$j=$i+1;
			$row=$result->fetch_array();
			$_SESSION['quest'][$j]=$row['q_id'];
		}
		if(!$result->num_rows)
		{
			echo "空试卷";
			die();
		}
		$num++;
	}
	else
	{
		$timeuse=floor(strtotime($time)-strtotime($_SESSION['time']));
		$_SESSION['time']=$time;
		$result=Querymysql("select * from exam_ans where e_id='$e_id' and p_id='$p_id' and q_id='$q_id' and user='$user'");
		if($result->num_rows)
		{
			$row=$result->fetch_array();
			$tu=$row['timeuse']+$timeuse;
			$query="update exam_ans set ans='$ans',timeuse='$tu' where id='".$row['id']."'";
			//echo "$query";
			Querymysql($query);
		}
		else{
			$query="insert into exam_ans(id,e_id,p_id,q_id,q_type,user,ans,timeuse) values(null,'$e_id','$p_id','$q_id','$q_type','$user','$ans','$timeuse')";
			Querymysql($query);
		}
	}
	$query="select * from question where id='".$_SESSION['quest'][$num]."'";
	$result=Querymysql($query);
	$row=$result->fetch_array();
	$q_id=$row['id'];
	$exits=$row['exits'];
	$q_type=$row['types'];
	$result3=Querymysql("select * from e_p_fen where e_id='$e_id' and p_id='$p_id'");
	$fen=array(0,0,0,0,0,0);
	if($result3->num_rows)
	{
		$row3=$result3->fetch_array();
		for($i=1;$i<=5;$i++)
		{
			$fen[$i]=$row3["t$i"];
		}
	}
	echo "<div class='wrapper'>
	       <div id='answer' class='card_wrap'>
            <div class='card_cont card1'>
              <div class='card' style='margin-left: 0px'>
                    <p class='question'>
                    <span>第$num 题<small>($fen[$q_type] 分)</small></span>
                    $exits</p>";

	if($q_type==1||$q_type==2)
	{
		echo "<ul class='select'>";

		$result1=Querymysql("select * from exam_ans where e_id='$e_id' and p_id='$p_id' and q_id='$q_id' and user='$user'");
		if($result1->num_rows)
		{
			$row1=$result1->fetch_array();
			$j="A";
			for($i=0;$i<7;$i++)
			{
				$k=$i+1;
				$inputid="q"+$i;
				if($row["ans$k"]!=''){
					if($j!=$row1['ans']){
						if($q_type==1){
							echo "<li>
                            <input id='$inputid' type='radio' value='$j' name='ans' >
                            <label for='$inputid'>$j:".$row["ans$k"]."</label>
                        </li>";
						}
						else{
							echo "<li>
                            <input id='$inputid' type='checkbox' value='$j' name='ans' >
                            <label for='$inputid'>$j:".$row["ans$k"]."</label>
                            </li>";
						}
					}
					//echo "<input type='checkbox' value='$j' name='ans' style='display:none'>$j:".$row["ans$k"]."<br>";
					else{
						if($q_type==1){
							echo "<li>
                            <input id='$inputid' type='radio' checked='checked' value='$j' name='ans' >
                            <label for='$inputid'>$j:".$row["ans$k"]."</label>
                        </li>";
						}else{
							echo "<li>
                            <input id='$inputid' type='checkbox' checked='checked' value='$j' name='ans' >
                            <label for='$inputid'>$j:".$row["ans$k"]."</label>
                        </li>";
						}
					}
						//echo "<input type='checkbox' checked  value='$j' name='ans'>".$j.":".$row["ans$k"]."<br>";
				}
				$j++;
			}
		}
		else{
			$j="a";
			for($i=0;$i<7;$i++)
			{
				$k=$i+1;
				$inputid="q".i;
				if($row["ans$k"]!=''){
					if($q_type==1){
						echo "<li>
                            <input id='$inputid' type='radio' value='$j' name='ans' >
                            <label for='$inputid'>$j:".$row["ans$k"]."</label>
                        </li>";
					}else{
						echo "<li>
                            <input id='$inputid' type='checkbox' value='$j' name='ans' >
                            <label for='$inputid'>$j:".$row["ans$k"]."</label>
                        </li>";
					}
				$j++;
			    }
			}
		}
		echo "</ul>";
	}
	else if($q_type==3)
	{
		$result1=Querymysql("select * from exam_ans where e_id='$e_id' and p_id='$p_id' and q_id='$q_id' and user='$user'");
		if($result1->num_rows)
		{
			$row1=$result1->fetch_array();
			if($row1['ans']=='对')
			{
				echo "<input type='checkbox' checked value='对' name='ans'>".$row["ans1"]."<br>";
				echo "<input type='checkbox' value='错' name='ans'>".$row["ans2"]."<br>";
			}
			else
			{
				echo "<input type='checkbox' value='对' name='ans'>".$row["ans1"]."<br>";
				echo "<input type='checkbox' checked value='错' name='ans'>".$row["ans2"]."<br>";
			}
		}
		else{
			echo "<input type='checkbox' value='对' name='ans'>".$row["ans1"]."<br>";
			echo "<input type='checkbox' value='错' name='ans'>".$row["ans2"]."<br>";
		}
	}
	else if($q_type==4)
	{
		$result1=Querymysql("select * from exam_ans where e_id='$e_id' and p_id='$p_id' and q_id='$q_id' and user='$user'");
		if($result1->num_rows){
			$row1=$result1->fetch_array();
			$aaa=$row1['ans'];
			echo "答案：<input type='text' name='ans' value='$aaa'><br>";
		}
		else
			echo "答案：<input type='text' name='ans'><br>";
	}
	else
	{
		$result1=Querymysql("select * from exam_ans where e_id='$e_id' and p_id='$p_id' and q_id='$q_id' and user='$user'");
		if($result1->num_rows)
		{
			$row1=$result1->fetch_array();
			$aaa=$row1['ans'];
			echo "答案:<textarea name='ans' cols='50' rows='3'>$aaa</textarea><br>";
		}
		else
		echo "答案:<textarea name='ans' cols='50' rows='3'></textarea><br>";
	}
	$today = date('Y/m/d\ H:i:s');
	if($num!=1)
	{
		$n=$num-1;
		echo <<<_end
		<div class="card_bottom">
		<button class = "btn btn-default" onclick="s_q($e_id,$p_id,$q_id,$q_type,$n,'$today')">上一题 </button>
_end;
	}else{
		echo <<<_end
		<div class="card_bottom">
		<button class = "btn btn-default">到头了</button>
_end;
	}
	if($num+1<=$_SESSION['quest'][0])
	{
		$n=$num+1;
		echo <<<_end
		<button class = "btn btn-default" onclick="s_q($e_id,$p_id,$q_id,$q_type,$n,'$today')" >下一题 </button>
		</div>
_end;
	}else{
		echo <<<_end
		<button class = "btn btn-default" onclick="" >提交试卷</button>
		</div>
_end;
	}
	echo <<<_end
	    </div>
    </div>
    </div>
  </div>
_end;
?>
