<?php
	require_once "function.php";
	session_start();
	if(isset($_SESSION['user']))
		{
			Destorysession();
			header("Location:index.php");
		}
		else
			echo "<div class='main'>Wrong because you don't logged in ";
?>