<?php include 'header.php' ?>
<!--<body onload="javascript: getformfornewbox(1);">-->
<!--<body>   -->
<?php include "menu.php";
if (isset($_GET['page']) == false)
	{
		$page = 0;
	}
else
	{		$page = $_GET['page'];
	}
switch ($page)
{
	case 0:     //login
		print("Hello world!");
		break;
	case 1: //networkboxtype
		include "networkbox.php";
		break;
	case 2: //boxeslist with type
		include "boxeslist.php";
		break;
	default:
		print("Hacking attempt!");
}
?>
</html>
