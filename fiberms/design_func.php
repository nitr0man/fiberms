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

function GenPages2($link,$PagesCount,$page) {
	$count = 5;
	$start = 1;	
	if ($PagesCount <= 5) {
		$count = $PagesCount+1;
	} else {
		$count = 6;
		$LastPage = '<a href="'.$link.'page='.$PagesCount.'">'.$PagesCount.'</a>';
		if ($page+5 < $PagesCount) {
			$LastPage = '.. '.$LastPage;
		}
		if ($page > 5) {
			$start = $page;
			$StartPage = '<a href="'.$link.'page=1">1</a> ..';
			$count = $start+5;
		} else {
			$start = 1;
			$count = 5*2;
		}
	}
	if ($count > $PagesCount+1) {
		$count = $PagesCount;
		$i = $count;
		while ($i+5 != $PagesCount) {
			$i--;
		}
		$start = $i;
	} elseif ($count > 5) {
		if ($page-4 > 0) {
			$start = $page-4;
		}
	}
	for ($i = $start; $i < $count; $i++) {
		if ($i == $page) {
			$pages .= ' '.$i.' ';
		} else {
			$pages .= ' <a href="'.$link.'page='.$i.'">'.$i.'</a> ';
		}
	}
	$pages = $StartPage.$pages.$LastPage;
	return $pages;
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