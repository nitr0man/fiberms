<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
 <head>
  <title>FiberMS</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  {if (!isset($smarty.get.print))}
	<link href="style/main.css" rel="stylesheet" type="text/css" media="screen" />  
	<link rel="stylesheet" type="text/css" href="style/map-menu-v.css" />
    <link rel="stylesheet" type="text/css" href="style/map-menu.css" />
  {/if}
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/ddsmoothmenu.js"></script>
  <script type="text/javascript" src="js/jquery.corner.js"></script>
  <script type="text/javascript" src="js/ajax.js"></script>
  <script type="text/javascript" src="js/menu.js"></script>
  {if (isset($smarty.get.print))}
	<style type="text/css">
		th {
			border: 1px solid black;
			font: bold;
			font-size: 12px;
			padding-left: 1px;
			padding-top: 1px;
			padding-right: 1px;
			padding-bottom: 1px;
		}
		td {
			border: 1px solid black;
			font: bold;
			font-size: 12px;
			padding-left: 1px;
			padding-top: 1px;
			padding-right: 1px;
			padding-bottom: 1px;
		}
		tr.cp {
			font: bold 100% serif;
			border: 1px solid black;
		}
		
		tr.bottomborder td {
			border-bottom: 2px solid black;
			border-top: 1px solid black;
			border-left: 1px solid black;
			border-right: 1px solid black;
			font: bold 12px serif;	
		}
		tr th {
			border-bottom: 2px solid black;
			border-top: 2px solid black;
		}
		caption {
			font-weight: bold;
			font-size: medium;
			padding-bottom: 5px;
		}
	</style>
{/if}
 </head>
<body>
{if (!isset($smarty.get.print))}
<div id="header">
<h1>Fiber management system {$version}</h1>
</div>
{/if}
<div id="loading-layer" style="display:none;font-family: Verdana;font-size: 11px;width:200px;height:50px;background:#FFF;padding:10px;text-align:center;border:1px solid #000">
    <div style="font-weight:bold" id="loading-layer-text">Загрузка. Пожалуйста, подождите...</div><br />
    <img src="pic/loading.gif" border="0" />
</div>
