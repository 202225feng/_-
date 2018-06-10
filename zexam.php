<?php
	
	require_once 'function.php';
	if(isset($_SESSION['user'])&&isset($_SESSION['value']))
	{
		$user =$_SESSION['user'];
		$value=$_SESSION['value'];
		$logged = TRUE;
	}
	else die();
	echo <<<_end
	<!DOCTYPE html><html><head>
	<title>RUC智慧招聘——答题端</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
	<link href="public/css/bootstrap.min.css" rel="stylesheet"/>
	<link href="font-style.css" rel="stylesheet" media="screen" />
	<link href="s_q/risk_test.css" rel="stylesheet" />
	  <script src="public/js/jquery.min.js">
      </script>
      <script src="public/js/bootstrap.min.js">
      </script>
      <script src="javascript.js">
      </script>
	</head><body style="background-image: url('public/images/test.jpg')">
	<div class="logobar" style="background-color:#aadc21">
      <img alt="RUC招聘" class="img-responsive" src="public/images/ICON.jpg"/>
    </div>
_end;

	if(isset($_GET['viewe']))
	{
		$e_id=sanitizeString($_GET['viewe']);
	}
	else die("</body></html>");
	$result=Querymysql("select * from exam where id='$e_id'");
	$row=$result->fetch_array();
	$c_id=$row['cour_num'];
	$today = date('Y/m/d\ H:i:s');
	$result=Querymysql("select * from stu_cour where cour_num='$c_id' and stu_num='$user' and status=1");
	if($result->num_rows)
	{
		$result=Querymysql("select * from exam where id='$e_id'");
		$row=$result->fetch_array();
		$b_time=$row['begin_date'];
		$e_time=$row['end_date'];
		if((strtotime($b_time)-strtotime($today))>0)
		{
			$left=(strtotime($b_time)-strtotime($today));
			$date=floor((strtotime($b_time)-strtotime($today))/86400);
			$hour=floor((strtotime($b_time)-strtotime($today))%86400/3600);
			$minute=floor((strtotime($b_time)-strtotime($today))%86400%3600/60);
			$second=floor((strtotime($b_time)-strtotime($today))%60);
			echo <<<_end
			<div class="page-header" style="margin-top: 5px;padding-bottom: 5px; text-align: center;">
               <h4>考试还未开始<br></h4>
               <div class="loader font4" style="font-size: 25px;width: 200px;margin: 0 auto;">
                    <span>距</span>
                    <span class="span2">离</span>
                    <span class="span3">考</span>
                    <span class="span4">试</span>
                    <span class="span5">开始</span>
                    <span class="span6">还</span>
                    <span class="span7">有</span>
                </div>
               <div class="btn-group">
               <button type="button" class="btn btn-default showd" >$date 天</button>
               <button type="button" class="btn btn-default showh" >$hour 小时</button>
               <button type="button" class="btn btn-default showm" >$minute 分钟</button>
               <button type="button" class="btn btn-default shows" >$second 秒</button>
               </div>
             </div>
             <script>
      var left = $left;
      var f1 = function(){
      	var date = Math.floor(left/86400);
      	var hour = Math.floor(left%86400/3600);
      	var minute = Math.floor(left%86400%3600/60);
      	var second = Math.floor(left%60);
      	$('.showd').html(date + " 天");
      	$('.showh').html(hour + " 小时");
      	$('.showm').html(minute + " 分钟");
      	$('.shows').html(second + " 秒");
      	left--;
      	return f1;
      }
      setInterval(f1(),1000);
      </script>
_end;
		}
		else if((strtotime($e_time)-strtotime($today))<0)
		{
			echo <<<_end
			<div class="page-header" style="margin-top: 5px;padding-bottom: 5px; text-align: center;">
               <h3>考试已结束</h3>
            </div>
_end;
		}
		else
		{
			$left=(strtotime($e_time)-strtotime($today));
			$hour=floor((strtotime($e_time)-strtotime($today))%86400/3600);
			$minute=floor((strtotime($e_time)-strtotime($today))%86400%3600/60);
			$second=floor((strtotime($e_time)-strtotime($today))%60);
			//echo "$e_id";
			$result=Querymysql("select * from exam_paper where ex_id='$e_id'");
			echo <<<_end
			<div class="page-header" style="margin-top: 5px;padding-bottom: 5px; text-align: center;">
                <div class="loader font4" style="font-size: 25px;width: 210px;margin: 0 auto;">
                    <span>距</span>
                    <span class="span2">离</span>
                    <span class="span3">考</span>
                    <span class="span4">试</span>
                    <span class="span5">结束</span>
                    <span class="span6">还</span>
                    <span class="span7">有</span>
                </div>
                <div class="btn-group">
                <button type="button" class="btn btn-info showh" >$hour 小时</button>
                <button type="button" class="btn btn-success showm" >$minute 分钟</button>
                <button type="button" class="btn btn-info shows" style="width: 65px">$second 秒</button>
                </div>
            </div>
            <script>
      var left = $left;
      var f2 = function(){
      	var hour = Math.floor(left%86400/3600);
      	var minute = Math.floor(left%86400%3600/60);
      	var second = Math.floor(left%60);
      	$('.showh').html(hour + " 小时");
      	$('.showm').html(minute + " 分钟");
      	$('.shows').html(second + " 秒");
      	left--;
      	return f2;
      }
      setInterval(f2(),1000);
      </script>
_end;
			echo "<div id='main' class='bit_main_content'>";
			for($i=0;$i<$result->num_rows;$i++)
			{
				$row=$result->fetch_array();
				$p_id=$row['pa_id'];
				$p_name=$row['paper_name'];
				echo <<<_end
				<div class = "panel panel-primary" style="opacity:0.7">
				    <div class = "panel-heading">
				     <h3 class="panel-title">$p_name</h3>
				    </div>
				    <div class="panel-body">
				  <button class = "btn btn-success" onclick="s_q($e_id,$p_id,0,0,0,'$today')">开始答题
				  </button>
				  </div>
				</div>
_end;
			}
			echo "</div>";
		}
	}
	else
	{
		$url="zexam.php?viewc=$c_id&viewe=$e_id";
		echo <<<_end
		<div class="panel panel-warning">
      <div class="panel-heading">
      <h3 class="panel-title">
      提示:您还不在该Group</h3>
      </div>
      <div id='ask' class="panel-body">
        是否申请加入该group
        <a href='studing.php' class="btn btn-danger btn-sm" role="button">取消</a> 
        <button class='btn btn-success btn-sm' onclick='change(ask,app)'>加入</button>
      </div>
      <div id="app" class="panel-footer" style='display:none;'>
        <form class="form-inline" role="form">
          <div class="form-group">
        <input type='text' class='form-control' id='ap' placeholder="请输入该group邀请码" style="width: 70% ">
          </div>
        <button class='btn btn-success btn-sm' onclick="apply($c_id,'$url')">提交</button>
        </form>
      </div>
      </div>
      
_end;
	}
?>
</body></html>
