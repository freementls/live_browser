<?php

//header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Credentials: true');
//header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE');

$source = get_by_request('source');
$from = get_by_request('from');
$to = get_by_request('to');
$time = get_by_request('time');
$message = get_by_request('message');

define('DS', '/');
include('..' . DS . '..' . DS . 'LOM' . DS . 'O.php');
//if(file_exists($to . '.xml')) {
//	file_put_contents($to . '.xml', '');
//}
$O = new O($to . '.xml');
$O->_new('<message><source>' . htmlentities($source) . '</source><from>' . htmlentities($from) . '</from><time>' . $time . '</time><text>' . htmlentities($message) . '</text></message>
');
print('<div title="' . date('Y-m-d H:i:s', $time) . '">' . $from . ': ' . $message . '</div>
');
$O->save();

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
