<?php 
	require_once "header.php";
	if(isset($_SESSION['cour_id_add']))
		$_SESSION['cour_id_add']=null;
	if(isset($_SESSION['cour_id']))
		$_SESSION['cour_id']=null;
	if(isset($_POST['change']))
	{
		$iid=sanitizeString($_POST['id']);
		if($value==1)
		$_SESSION['cour_id']=$iid;
		else
		{
			$result= Querymysql("select * from teacher_cour where tea_user='$user' and cour_num='$iid' and status=1");
			if($result->num_rows)
				$_SESSION['cour_id']=$iid;
		}
		header("Location:course_change.php");
	}

	if(isset($_GET['view']))
	{	
		$vie_id=sanitizeString($_GET['view']);
		if($value==1)
		$_SESSION['cour_id_add']=$vie_id;
		else{
			$result= Querymysql("select * from teacher_cour where tea_user='$user' and cour_num='$vie_id' and status=1");
			if($result->num_rows)
				$_SESSION['cour_id_add']=$vie_id;
		}
		header("Location:stu_info_cour.php");
	}

	if(isset($_POST['delete']))
	{
		if($value==1)
		{
			$cour_id=sanitizeString($_POST['id']);
			$result=Querymysql("select * from cour_info where cour_num='$cour_id'");
			if($result->num_rows)
			{
				$result=Querymysql("select * from stu_cour where cour_num='$cour_id'");
				if(!$result->num_rows)
				{
					Querymysql("delete from cour_info where cour_num='$cour_id'");
				}
			}
			
		}
	}

		if($value==1)
		{
			echo <<<_end
			<div id="modal-container">
            <div class="modal-background">
                <div class="modal" id='modalchange'>
                    
                </div>
            </div>
        </div>
_end;
			$result=Querymysql("select * from cour_info");
			echo "<div id='fdw-pricing-table'>";
			for($i=0;$i<$result->num_rows;$i++)
			{
				$row=$result->fetch_array();
				$id=$row['cour_num'];
				$name=$row['cour_name'];
				$collage=$row['collage'];
				$term=$row['term'];
				echo <<<_end

<div class="plan plan1">
	<div class="header">
                    GROUP：
                    <a href="course_admin.php?view=$id">
                        $name
                    </a>
                </div>
                <div class="detail">
                    <br>
                        描述：$collage
                        <br>
                                面试官：
_end;
				$result1=Querymysql("select tea_name from teacher_cour where cour_num='$id' and class=1 and status=1 ");
				for($j=0;$j<$result1->num_rows;$j++)
				{
					$row1=$result1->fetch_array();
					echo $row1['tea_name']."<br>";
				}
				
				echo <<<_end
				</div>
<form action="course_admin.php" method="post">
                        <div class="content" style="background: white">
                            <div class="buttons">
                                <div class="button" id="one" onclick="">
<input type="submit" name="change" value="修改" >
                                </div>
                                <div class="button">
                                   
								<input type='submit' name="delete" value="删除">

                                    <input name="id" type="hidden" value="$id">
                                    </input>
                                </div>
                </div>
            </div>
        </form>
    </div>
_end;
			}
			echo "</div>";
		}
		else if ($value==2) {
			$result=Querymysql("SELECT * FROM cour_info WHERE cour_num in (select cour_num from teacher_cour where tea_user = '$user' and status=1 and class=1) ");
			echo <<<_end
			<div id="modal-container">
            <div class="modal-background">
                <div class="modal" id='modalchange'>
                    
                </div>
            </div>
        </div>
_end;
echo "<div id='fdw-pricing-table'>";

			
			for($i=0;$i<$result->num_rows;$i++)
			{
				$row=$result->fetch_array();
				$id=$row['cour_num'];
				$name=$row['cour_name'];
				$collage=$row['collage'];
				$term=$row['term'];
				echo <<<_end

<div class="plan plan1">
	<div class="header">
                    GROUP：
                    <a href="course_admin.php?view=$id">
                        $name
                    </a>
                </div>
                <div class="detail">
                    <br>
                        描述：$collage
                        <br>
                                面试官：
_end;
				$result1=Querymysql("select tea_name from teacher_cour where cour_num='$id' and class=1 and status=1 ");
				for($j=0;$j<$result1->num_rows;$j++)
				{
					$row1=$result1->fetch_array();
					echo $row1['tea_name']."<br>";
				}
				
				echo <<<_end
				</div>
<form action="course_admin.php" method="post">
                        <div class="content" style="background: white">
                            <div class="buttons">
                                <div class="button" id="one" onclick="">
<input type="submit" name="change" value="修改" >
                                </div>
                                <div class="button">
                                   
								<input type='submit' name="delete" value="删除">

                                    <input name="id" type="hidden" value="$id">
                                    </input>
                                </div>
                </div>
            </div>
        </form>
    </div>
_end;
			}
		
			echo "</div>";
	}

?>
</body>
</thml>