<?php

$host='localhost';
$user='dbuser';
$pass='B836e6$dca90&';
$dbname='ripndip';
$base_url="https://290px.com/ripndip/";

if($db=@mysqli_connect($host,$user,$pass)){
	
	if(!mysqli_select_db($db,$dbname)){
		echo'could not connect to the database name';
	}
	
	}else{
	echo 'could not connect to the server!';
}

?>