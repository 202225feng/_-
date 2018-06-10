<?php
	require_once "zheader.php";

	$today = date('Y/m/d\ H:i:s');

	echo <<<_end
	<div class="tab-content" id="myTabContent">
      <div class="tab-pane fade" id="testli">
        <div class="page-header" style="margin-top: 0px;padding-bottom: 1px; text-align: center;">
          <h3>
            我的考试
          </h3>
          <h4>
            现在时间: $today
          </h4>
        </div>
_end;
    $result=Querymysql("select * from exam where end_date>'$today' order by begin_date");
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
    $result1=Querymysql("select * from stu_infor where stu_num='$user'");
	if($result1->num_rows)
	{
		$row1=$result1->fetch_array();
		$name=$row1['name'];
		$gender=$row1['gender'];
		$phonenum=$row1['phonenum'];
		$school=$row1['school'];
		$major=$row1['major'];
		$degree=$row1['degree'];
		echo <<<_end
		<div class="tab-pane fade" id="psinfo" style="text-align: center;">
        <div style="margin:20px 0px 20px 0px; text-align: center">
          <a href="studing.php?#psinfo">
            <img alt="头像" class="img-circle" src="public/images/touxiang.jpg"/>
          </a>
        </div>
        <table class="table table-condensed table-hover" style="text-align: center;">
          <tbody>
            <tr>
              <td>
                姓名
              </td>
              <td>
                $name
              </td>
            </tr>
            <tr>
              <td>
                性别
              </td>
              <td>
                $gender
              </td>
            </tr>
            <tr>
              <td>
                电话号码
              </td>
              <td>
                $phonenum
              </td>
            </tr>
            <tr>
              <td>
                学校
              </td>
              <td>
                $school
              </td>
              <tr>
                <td>
                  专业
                </td>
                <td>
                  $major
                </td>
              </tr>
              <tr>
                <td>
                  学历
                </td>
                <td>
                  $degree
                </td>
              </tr>
            </tr>
          </tbody>
        </table>
        <button class="btn btn-primary btn-sm" data-target="#infochange" data-toggle="modal">
          修改信息
        </button>
        <div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="infochange" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                  ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  个人信息修改
                </h4>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" role="form" action = "studing.php" method="post">
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">
                      姓名
                    </label>
                    <div class="col-sm-10">
                      <input class="form-control" id="name" placeholder="$name" type="text" value = "$name" name = "name">
                      </input>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="sexual">
                      性别
                    </label>
                    <div class="col-sm-10">
                      <select class="form-control" id="sexual" name="gender" placeholder = "$gender">
_end;
if($gender=='男'||$gender=='nan')
echo <<<_end
                        <option value="男">
                          男
                        </option>
                        <option value="女">
                          女
                        </option>
_end;
else
echo <<<_end
                        <option value="女">
                          女
                        </option>
                        <option value="男">
                          男
                        </option>
_end;
echo <<<_end
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="phonumber">
                      电话号码
                    </label>
                    <div class="col-sm-10">
                      <input class="form-control" id="phonumber" placeholder="$phonenum" type="text" name = "phonenum" value = "$phonenum">
                      </input>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="school">
                      学校
                    </label>
                    <div class="col-sm-10">
                      <input class="form-control" id="school" placeholder="$school" type="text" name = "school" value = "$school">
                      </input>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="major">
                      专业
                    </label>
                    <div class="col-sm-10">
                      <input class="form-control" id="major" placeholder="$major" name = "major" value = "$major" type="text">
                      </input>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="degree">
                      学历
                    </label>
                    <div class="col-sm-10">
                      <input class="form-control" id="dgree" placeholder="$degree" name = "degree" value = "$degree" type="text">
                      </input>
                    </div>
                  </div>
                  <div class="modal-footer">
                  <button class="btn btn-default" data-dismiss="modal" type="button">
                  关闭
                </button>
                <button class="btn btn-primary" type="submit" name = "change">
                  提交更改
                </button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
          $(function () {
    var j = $('#myTab li:eq(1) a');
    $('#testli').addClass('in active');
    j.tab('show');
  });
        </script>
_end;
	}
	else
  {
		Querymysql("insert into stu_infor(stu_num) values('$user')");
		echo <<<_end
		<div class="tab-pane fade" id="psinfo" style="text-align: center;">
        <div style="margin:20px 0px 20px 0px; text-align: center">
          <a href="studing.php?#psinfo">
            <img alt="头像" class="img-circle" src="public/images/touxiang.jpg"/>
          </a>
        </div>
         <center><font color='red'>如果您不完善您的信息<br>将会影响您参加考试！！</font></center>
        <table class="table table-condensed table-hover" style="text-align: center;">
          <tbody>
            <tr>
              <td>
                姓名
              </td>
              <td>
                
              </td>
            </tr>
            <tr>
              <td>
                性别
              </td>
              <td>
                
              </td>
            </tr>
            <tr>
              <td>
                电话号码
              </td>
              <td>
               
              </td>
            </tr>
            <tr>
              <td>
                学校
              </td>
              <td>
                
              </td>
              <tr>
                <td>
                  专业
                </td>
                <td>
                  
                </td>
              </tr>
              <tr>
                <td>
                  学历
                </td>
                <td>
                  
                </td>
              </tr>
            </tr>
          </tbody>
        </table>
        <button class="btn btn-primary btn-sm" data-target="#infochange" data-toggle="modal">
          修改信息
        </button>
        <div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="infochange" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                  ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  个人信息修改
                </h4>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" role="form" action = "studing.php" method="post">
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">
                      姓名
                    </label>
                    <div class="col-sm-10">
                      <input class="form-control" id="name" placeholder="" type="text" value = "" name = "name">
                      </input>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="sexual">
                      性别
                    </label>
                    <div class="col-sm-10">
                      <select class="form-control" id="sexual" name="gender" placeholder = "">
                        <option value="男">
                          男
                        </option>
                        <option value="女">
                          女
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="phonumber">
                      电话号码
                    </label>
                    <div class="col-sm-10">
                      <input class="form-control" id="phonumber" placeholder="$phonenum" type="text" name = "phonenum" value = "">
                      </input>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="school">
                      学校
                    </label>
                    <div class="col-sm-10">
                      <input class="form-control" id="school" placeholder="" type="text" name = "school" value = "">
                      </input>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="major">
                      专业
                    </label>
                    <div class="col-sm-10">
                      <input class="form-control" id="major" placeholder="" name = "major" value = "" type="text">
                      </input>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="degree">
                      学历
                    </label>
                    <div class="col-sm-10">
                      <input class="form-control" id="dgree" placeholder="" name = "degree" value = "" type="text">
                      </input>
                    </div>
                  </div>
                  <div class="modal-footer">
                  <button class="btn btn-default" data-dismiss="modal" type="button">
                  关闭
                </button>
                <button class="btn btn-primary" type="submit" name = "change">
                  提交更改
                </button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
		$(function () {
	var j = $('#myTab li:eq(0) a');	
	$('#psinfo').addClass('in active');	
    $('#infchan').trigger('click');
  });
  </script>
_end;
  }
	if(isset($_POST['change']))
	{
		$name =sanitizeString($_POST['name']);
		$gender =sanitizeString($_POST['gender']);
        $phonenum =sanitizeString($_POST['phonenum']);
        $school =sanitizeString($_POST['school']);
        $major =sanitizeString($_POST['major']);
        $degree =sanitizeString($_POST['degree']);
        Querymysql("update stu_infor set name='$name',gender='$gender',phonenum='$phonenum',school='$school',major='$major',degree='$degree' where stu_num='$user'");
        echo <<<_end
		<script>
		alert('修改完成,五秒后自动跳转');
		window.setTimeout("window.location='studing.php'",500);
		</script>"
_end;
	}
	if(isset($_POST['cancel']))
	{
		header("Location:studing.php");
	}
?>