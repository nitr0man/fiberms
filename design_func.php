<?php
function showMessage($message, $error) {
	global $smarty;
	if ($error == 1) {
		$result = '<font color="red"><u>Ошибка</u>: <b>'.$message.'</b></font>';
	} else {
		$result = $message;
	}
	$smarty->assign("message", $result);
	$smarty->display("message.tpl");
	die();
}

function genPages($link, $pagesCount, $page) {
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
		$End = '';
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
	if ($page < $pagesCount) {
		$pages .= $End.' <a href="'.$link.'page='.$pagesCount.'">'.$pagesCount.'</a>';
	} else {
		if ($page != 1) {
			$pages .= $End.''.$pagesCount.'';
		}
	}
	return $pages;
}

function gen_csv($data, $fields = NULL,  $separator = ';') {
    $ret = '';
    if ($fields) {
	foreach ($fields as $field => $title) {
	    $ret .= $title . $separator;
	}
	$ret .= "\r\n";
    }
    foreach ($data as $row) {
	if ($fields) {
	    foreach ($fields as $field => $title) {
		$ret .= $row[$field] . $separator;
	    }
	} else {
	    foreach ($row as $data) {
		$ret .= $data . $separator;
	    }
	}
	$ret .= "\r\n";
    }
    return $ret;
}
?>