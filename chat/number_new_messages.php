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
// what about remote?
print(getmicrotime() - $last_activity);

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
