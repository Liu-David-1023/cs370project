<?php
 header("Access-Control-Allow-Origin: *");
if(!isset($_SESSION)) { session_start(); }


require_once "dbconnect.php";
require_once "logic.php";

	$act=mysqli_real_escape_string($db, $_POST["act"]);
	$ret = "";

	switch ($act)
	{
		case "login" :  $name=mysqli_real_escape_string($db, $_POST["name"]);
						$pass=mysqli_real_escape_string($db, $_POST["pass"]);
						$ret = checkuser($name, $pass, $db);
						break;
						
		case "stats" :  $pid=mysqli_real_escape_string($db, $_POST["player"]);
						$ret = userstats($pid, $db); break;
						
		case "top10" :  $ret = top10($db); break;
		case "save" :  
						$pid=mysqli_real_escape_string($db, $_POST["player"]);
						$level=mysqli_real_escape_string($db, $_POST["level"]);
						$time=mysqli_real_escape_string($db, $_POST["time"]);
						$ret = storestats($pid, $level, $time, $db); break;
	}


	if($ret == "mismatch")
		echo "User/Password incorrect";
	elseif($ret == "notcreated")
		echo "User not created";
	elseif($ret == "nogames")
		echo "No Games, Start playing now!!";
	elseif($ret == "saved")
		echo "Score saved successfully";
	elseif($ret == "notsaved")
		echo "Score not saved!!";
	else
		echo $ret;

?>