<?php

//header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Credentials: true');
//header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE');

include('../life.php');
$life = new life();
$source = $life->get_by_request('source');
if($source == false) {
	exit(0);
}
$from = $life->get_by_request('from');
$to = $life->get_by_request('to');
$time = $life->get_by_request('time');
if($time == false) {
	exit(0);
}
$message = $life->get_by_request('message');
if($message === false || $message === NULL) {
	exit(0);
}

//define('DS', '/');
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

?>
