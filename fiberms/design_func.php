<?php
function ShowMessage($message,$error) {
	global $smarty;
	if ($error == 1) {
		$result = '<font color="red"><u>Ошибка</u>: <b>'.$message.'</b></font>';
	} else {
		$result = $message;
	}
	$smarty->assign("message",$result);
	$smarty->display("message.tpl");
	die();
}

function GenPages($link,$PagesCount,$page) {
	if ($page == 1) {
		$pages = '1';
	} else {
		$pages = '<a href="'.$link.'page=1">1</a>';
	}
	$start = $page-5;
	if ($start <= 2) {
		$start = 2;
	} else {
		$pages .= ' .. ';
	}
	$count = $page+5;
	if ($count >= $PagesCount-1) {
		$count = $PagesCount-1;
	} else {
		$End = '..';
	}
	for ($i = $start; $i <= $count; $i++) {
		if ($i == $page) {
			$pages .= ' '.$i.' ';
		} else {
			$pages .= ' <a href="'.$link.'page='.$i.'">'.$i.'</a> ';
		}
	}
	if ($page != $PagesCount) {
		$pages .= $End.' <a href="'.$link.'page='.$PagesCount.'">'.$PagesCount.'</a>';
	} else {
		if ($page != 1) {
			$pages .= $End.''.$PagesCount.'';
		}
	}
	return $pages;
}
?>