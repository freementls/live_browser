<?php

//print('refresh001');
$to = get_by_request('to');
$time = get_by_request('time');
//print('$to, $time: ');var_dump($to, $time);
//print('refresh002');

define('DS', '/');
include('..' . DS . '..' . DS . 'LOM' . DS . 'O.php');
//if(file_exists($to . '.xml')) {
//	file_put_contents($to . '.xml', '');
//}
//print('refresh003');
$O = new O($to . '.xml');
foreach($O->get_tagged('message') as $message) {
	$existing_time = $O->_('time', $message);
	if($existing_time > $time) { // only print new messages
		print('<div title="' . date('Y-m-d H:i:s', $existing_time) . '">' . $O->_('from', $message) . ': ' . $O->_('text', $message) . '</div>
');
	}
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
