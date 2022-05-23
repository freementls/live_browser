<?php

$to = get_by_request('to');

define('DS', '/');
include('..' . DS . '..' . DS . 'LOM' . DS . 'O.php');
$O = new O($to . '.xml');
foreach($O->get_tagged('message') as $message) {
	$existing_time = $O->_('time', $message);
	print('<div title="' . date('Y-m-d H:i:s', $existing_time) . '">' . $O->_('from', $message) . ': ' . $O->_('text', $message) . '</div>
');
}

function get_by_request($variable) {
	if($_REQUEST[$variable] == '') {
		//warning($variable . ' not properly specified.<br>');
		return false;
	} else {
		$variable = query_decode($_REQUEST[$variable]);
	}
	return $variable;
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
