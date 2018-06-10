<?php
	$dbhost = 'localhost';
	$dbname = 'studing';
	$dbuser = 'root';
	$dbpass = '1234';
	$dbport = 3306;
	$appname = 'sp';

	$conn = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
	if($conn->connect_error) die($conn->connect_error);

	mysqli_query($conn,"set names utf8");

	function Createtable($name,$query)
	{
		Querymysql("create table if not exists $name($query)");
		echo "Table '$name' created or already exists.<br>";
	}

	function Querymysql($query)
	{
		global $conn;
		$result = $conn->query($query);
		if(!$result) die($conn->error);
		return $result;
	}

	function Destorysession()
	{
		$_SESSION = array();
		if(session_id()!=""||isset($_COOKIE[session_name()]))
			setcookie(session_name(),'',time()-259200,'/');

		session_destroy();
	}

	function sanitizeString($var)
	{
		global $conn;
		$var = stripslashes($var);//消除下划线
		$var = strip_tags($var);
		$var = htmlentities($var);//消除html语句
		return $conn->real_escape_string($var);
	}

	function Showprofile($user)
	{
		if(file_exists("tp\/$user.jpg"))
			echo "<img src='tp\/$user.jpg' style='float:left;'>";
		$result = Querymysql("select * from profiles where user='$user'");
		if($result->num_rows)
		{
			$row = $result->fetch_array();
			echo stripslashes($row['text'])."<br style='clear:left;'><br>";
		}
	}
		//48~57	65~90	97~122
	function create_password($pw_length ) 
	{ 
	$randpwd = ''; 
	for ($i = 0; $i < $pw_length; $i++) 
	{ 
		if($i%2)
			$randpwd .= chr(mt_rand(48,57)); 
		else
			$randpwd .= chr(mt_rand(97,122));
	} 
	return $randpwd; 
	}
?>