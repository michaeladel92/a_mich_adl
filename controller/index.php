<?php
session_start();
if (!isset($_SESSION['id'])) {
			header("location:../404.php");
}elseif ($_SESSION['role'] == 'admin') {

}else{
					header("location:../404.php");
				}

?>