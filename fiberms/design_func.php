<?php
function showMessage($message,$error) {
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

function genPages($link,$pagesCount,$page) {
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
	if ($count >= $pagesCount-1) {
		$count = $pagesCount-1;
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
	if ($page != $pagesCount) {
		$pages .= $End.' <a href="'.$link.'page='.$pagesCount.'">'.$pagesCount.'</a>';
	} else {
		if ($page != 1) {
			$pages .= $End.''.$pagesCount.'';
		}
	}
	return $pages;
}
?>