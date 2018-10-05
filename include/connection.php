<?php


$host 	 = 'localhost';
$user 	 = 'root';
$pass 	 = '';
$db_name = 'a_mich_adl';

$connect = mysqli_connect($host, $user, $pass, $db_name);
if (!$connect) {
		echo mysqli_connect_errno();

}else{
		//echo "connected";

}

function db_close(){
	global $connect;
	mysqli_close($connect);
}
?>