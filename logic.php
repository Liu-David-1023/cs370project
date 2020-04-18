<?php
if(!isset($_SESSION)) { session_start(); }

function createuser($username, $pass, $db)
{
	$SQL="insert into user (name, pass, joined) values ('".$username."','".md5($pass)."', now())";
	//echo $SQL;
	$result = $db->query($SQL);

	if($result)
	{
		$last_id = $db->insert_id;
		return $last_id;
	}
	else
		return "notcreated";
}


function checkuser($username, $pass, $db)
{
	$SQL="Select id from user where name='".$username."'";

	//echo $SQL;
	$result = $db->query($SQL);

	$rows=mysqli_num_rows($result);
	
	if($rows > 0 )
	{
		$SQL="Select id from user where name='".$username."' and pass='".md5($pass)."'";
		//echo $SQL;
		if($rows > 0 )
		{
			
			$row=mysqli_fetch_assoc($result);
			
			return $row["id"];
		}
		else
		{
			return "mismatch";
		}
			
	}
	else
	{
		$user = createuser($username, $pass, $db);
			
			return $user;
	}
}



function storestats($id, $level, $timer, $db)
{
	$SQL="insert into gamestats (userid, levelno, score, played) values ('".$id."','".$level."','".$timer."', now())";
	echo $SQL;
	$result = $db->query($SQL);

	if($result)
		return "saved";
	else
		return "notisaved";
}

function userstats($id, $db)
{
	$SQL="Select * from gamestats where userid='$id' order by played desc limit 1,10";
	//echo $SQL;
	$result = $db->query($SQL);
	$showresult = "";
	
	$rows=mysqli_num_rows($result);
	
	if($rows > 0 )
	{
		$showresult = "
		
		<style>
			td {width:30%;}
		</style>
		
		<table style='width:100%;color:black;margin:0 15px;'>";
		
		while($row=mysqli_fetch_assoc($result))
		{
			$showresult .= "<tr><td>".$row["id"] ."</td><td>" .  $row["levelno"] ."</td><td>" . $row["score"] ."</td></tr>";
		}
		
		$showresult .= "</table>";
		
		return $showresult;
	}
	else
		return "nogames";
}

function top10($db)
{
	$SQL="Select g.id, u.name, g.levelno, g.score from gamestats g, user u where g.userid = u.id order by g.levelno desc, g.score limit 1,10";
	//echo $SQL;
	$result = $db->query($SQL);
	$showresult = "";
	
	$rows=mysqli_num_rows($result);
	
	if($rows > 0 )
	{
		$showresult = "
		
		<style>
			td {width:30%;}
		</style>
		
		<table style='width:100%;color:black;margin:0 15px;'>";
		while($row=mysqli_fetch_assoc($result))
		{		
			$showresult .= "<tr><td>".$row["id"] ."</td><td>" .  $row["name"] ."</td><td>" .  $row["levelno"] ."</td><td>" . $row["score"] ."</td></tr>";
		}
		$showresult .= "</table>";
		
		return $showresult;
	}
	else
		return "nogames";
}

?>