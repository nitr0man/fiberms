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

function genPageLink($link, $page, $pagename, $selected) {
	if ($selected) {
		return "<b>$pagename</b> ";
	} else {
		return '<a href="'.$link.'page='.$page.'">'.$pagename.'</a> ';
	}
}

function genPages($link, $pagesCount, $page, $all='Все') {
	$pages = '';
	if ($all && ($pagesCount > 1 || $page == 0)) {
		$pages .= genPageLink($link, 0, $all, $page == 0);
	}
	$pages .= genPageLink($link, 1, '1', $page == 1);
	$start = $page-5;
	if ($start <= 2) {
		$start = 2;
	} else {
		$pages .= '.. ';
	}
	$count = $page+5;
	if ($count >= $pagesCount-1) {
		$count = $pagesCount-1;
		$End = '';
	} else {
		$End = '.. ';
	}
	for ($i = $start; $i <= $count; $i++) {
		$pages .= genPageLink($link, $i, "$i", $page == $i);
	}
	if ($pagesCount > 1) {
	    $pages .= $End . genPageLink($link, $pagesCount, "$pagesCount", $page == $pagesCount);
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