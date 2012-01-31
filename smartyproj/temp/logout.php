<?
session_start();
if (isset($_SESSION['user']))
{
	unset($_SESSION['user']);	  
	setcookie('token', '');	  	  
}
header("location: index.php");
?>
