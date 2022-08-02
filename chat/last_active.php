<?php

$to = get_by_request('to');

define('DS', '/');
include('..' . DS . '..' . DS . 'LOM' . DS . 'O.php');
$last_activity = 0;
$O = new O($to . '.xml');
foreach($O->get_tagged('message') as $message) {
	$existing_time = $O->_('time', $message);
	if($existing_time > $last_activity) {
		$last_activity = $existing_time;
	}
	// would be nice to safely to assume that the last message would be the last activity, although with how the chat is asynchronous this isn't necessarily true
}
//print('getmicrotime(), $last_activity: ');var_dump(getmicrotime(), $last_activity);
//print(date('Y<\a\b\b\r \t\i\t\l\e="\y\e\a\r\s">\y</\a\b\b\r>m<\a\b\b\r \t\i\t\l\e="\m\o\n\t\h\s">\m</\a\b\b\r>d<\a\b\b\r \t\i\t\l\e="\d\a\y\s">\d</\a\b\b\r>H<\a\b\b\r \t\i\t\l\e="\h\o\u\r\s">\h</\a\b\b\r>i<\a\b\b\r \t\i\t\l\e="\m\i\n\u\t\e\s">\m</abbr>s<\a\b\b\r \t\i\t\l\e="\s\e\c\o\n\d\s">\s</\a\b\b\r>', floor(getmicrotime() - $last_activity)));
$seconds = floor(getmicrotime() - $last_activity);
if($seconds > 28292000) {
	$years = floor($seconds / 28292000);
	print($years . '<abbr title="years">Y</abbr>');
} elseif($seconds > 2572000) {
	$months = floor($seconds / 2572000);
	print($months . '<abbr title="months">M</abbr>'); // of course, we are approximating... thanks to Gregory and Julius
} elseif($seconds > 86400) {
	$days = floor($seconds / 86400);
	print($days . '<abbr title="days">d</abbr>');
} elseif($seconds > 3600) {
	$hours = floor($seconds / 3600);
	print($hours . '<abbr title="hours">h</abbr>');
} elseif($seconds > 60) {
	$minutes = floor($seconds / 60);
	print($minutes . '<abbr title="minutes">m</abbr>');
} else {
	print($seconds . '<abbr title="seconds">s</abbr>');
}

function getmicrotime() {
	list($usec, $sec) = explode(' ', microtime());
	return (float)$usec + (float)$sec;
}

function get_by_request($variable) {
	return query_decode($_REQUEST[$variable]);
}

function query_encode($string) {
	$string = str_replace('&', '%26', $string);
	return $string;
}

function query_decode($string) {
	$string = str_replace('%26', '&', $string);
	return $string;
}

?>
