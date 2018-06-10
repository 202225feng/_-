<?php
	$error1=$error2=$error3='';
	if(isset($_GET['sure']))
	{
		$arr=array();
		$arr[0]=$_GET['score'];
		$arr[1]=$_GET['taken'];
		$arr[2]=$_GET['fid'];
		$arr[3]=$_GET['key'];
		$arr[4]=$_GET['uid'];
		echo $arr[0]." ".$arr[1]." ".$arr[2]." ".$arr[3]." ".$arr[4]." "."<br>";
		$sub=$arr[2]."LPislKLodlLKKOSNlSDOAADLKADJAOADALAklsd" .$arr[2];
		$error1=md5($sub);
		$error2=md5($error1);
		$error3=md5($error2);
		echo $error2."<br>";

		$sub="SDALPlsldlnSLWPElsdslSE".$arr[3].$arr[0].$arr[2].$arr[1]. "PKslsO";
		$error1=md5($sub);
		$error2=md5($error1);
		$error3=md5($error2);
		echo $error3."<br>";


		/*for($i=0;$i<5;$i++)
		{
			for($j=0;$j<5;$j++)
			{
				for($k=0;$k<5;$k++)
				{
					for($l=0;$l<5;$l++)
					{
						for($n=0;$n<5;$n++)
						{
							if($i!=$j&&$i!=$k&&$i!=$l&&$i!=$n&&$j!=$k&&$j!=$l&&$j!=$n&&$k!=$l&&$k!=$n&&$l!=$n)
							{
								//$sub="SDALPlsldlnSLWPElsdslSE".$arr[$i].$arr[$j].$arr[$k].$arr[$l].$arr[$n]."PKslsO";
								$sub=$arr[$i].$arr[$j].$arr[$k].$arr[$l].$arr[$n];
								$error1=md5($sub);
								$error2=md5($error1);
								$error3=md5($error2);
								echo $error3."<br>";
							}
						}
					}
				}
			}
		}*/

	}

echo "<form method='get' action='MD5.php'>score：<input type='text' name='score'><br>taken<input type='text' name='taken'><br>fid:<input type='text' name='fid'><br>key:<input type='text' name='key'><br>uid<input type='text' name='uid'><br><input type='submit' name='sure' value='查询'><br></form>";
?>