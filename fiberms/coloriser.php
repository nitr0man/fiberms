<?php
require_once("smarty.php");
if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		$body["color"] = $_POST["bodycolor"];
		$body["background"] = $_POST["bodybackground"];
		$content["background"] = $_POST["contentbackground"];
		$content["th-color"] = $_POST["contentth"];
		$content["td-color"] = $_POST["contenttd"];
		if ($_POST["alinkcolor"] = "") { $a["link-color"] = "#BC2417"; };
		if ($_POST["avisitedcolor"] = "") { $a["visited-color"] = "#BC2417"; };
		if ($_POST["aactivecolor"] = "") { $a["active-color"] = "#BC2417"; };
		$menu["background"] = $_POST["leftcolmenu"];
		if ($_POST["leftcolmenuh3"] = "") { $menu["h3-color"] = "#7A7A7A"; };
		$menu["menu-ul-li"] = $_POST["leftcolmenuulli"];
		$menu["menu-ul-li-li"] = $_POST["leftcolmenuullili"];
	//	$menu["li-li-border-color"] =  $_POST[""];
		$menu["menu-ul-li-hover"] = $_POST["leftcolmenuullihover"];
		if ($_POST["leftcolmenuullihover"] = "") { $menu["menu-ul-li-hover"] = "#e3e3e3 url('pic/bull_on.gif') no-repeat 0 4px"; };
/*		$menu["background-color-hover"] = $_POST[""];
		$menu["li-a-visited"] = $_POST[""];
		$menu["li-a-hover"] = $_POST[""];*/
		$contablebordercolor = $_POST["contable"];
		$css = "body {
	font-family: Tahoma, Arial, sans-serif;
	font-size: 12px; 
	color: ".$body["color"].";
	background: ".$body["background"].";
	line-height:16px;
	height:100%;
}
li { 
	background: #e3e3e3 url('pic/bull_on.gif') no-repeat 4px;
	}
#main {
	margin: 0 auto;
	width: 920px;
}

.leftcolumn {
	width: 210px;
	float: left;
	height: 400px;
	margin-bottom: 40px;
}
#content {
	width: 100%;
	background: ".$content["background"].";
	display:table-cell;
	position:relative;
	top: 5px;
 }
#content td {
background: ".$content["tdcolor"].";}
#content th {
background: ".$content["thcolor"].";}

ul, ol { list-style: none; }
h1, h2, h3, h4, h5, h6, pre, code, p { font-size: 1em; }
ul, ol, dl, li, dt, dd, h1, h2, h3, h4, h5, h6, pre, form, body, html, p, blockquote, fieldset, input { margin: 0; padding: 0; }
a img, :link img, :visited img { border: none; }

a:link { color: ".$a["link-color"]."; text-decoration: underline; }
a:visited { color: ".$a["visited-color"]."; text-decoration: underline; }
a:active { color: ".$a["active-color"]."; text-decoration: underline; }
a:hover { text-decoration: none; }

p { margin: 0 0 12px 0; line-height: 1.2em; }
small { font-size: 11px; }
blockquote { margin: 10px 25px 10px 25px; padding: 20px 25px 15px 45px; background: #EBF1C1; }

.left_col .menu { padding:20px; background: ".$menu["background"]."; margin: 5%; float: left; }
.left_col .menu h3 { font: 14px Tahoma, Arial; color: ".$menu["h3-color"]."; margin:0 0 20px 0; text-transform: uppercase; font-weight: bold; }
.left_col .menu ul li { padding:0 0 0 20px; background: ".$menu["menu-ul-li"]."; margin:0 0 0 0; list-style:none; }
.left_col .menu ul li li { ".$menu["menu-ul-li-li"]."; }
.left_col .menu ul li:hover { padding:0 0 0 20px; background: ".$menu["menu-ul-li-hover"]."; margin:0px 0 0 0; list-style:none; }
.menu ul li a, .menu ul li a:visited { font: 11px Tahoma, Arial; color:#BC2417; text-decoration:none; font-weight: bold; }
.menu ul li a:hover { font: 11px Tahoma, Arial; color:#df4336; text-decoration:none; font-weight: bold; }

.padding-a{
  padding-top: 12px;
  border: 0px solid black; 

}

.arrow-down{
  margin: 0px;
  padding: 0px;
}

.img-arrow{
  margin-top: 10px;
}
#contable {
  margin: 20px;
  border: ".$menu["contable"]."; }";
  $handle = fopen("tempcss.css", "w");
  ftruncate($handle, "1000000");
  fwrite($handle, $css);
  fclose($handle);
  //echo $css;
   } else {
	$smarty->display('Coloriser.tpl');
}
?>
