<?php

//print('$_REQUEST: ');var_dump($_REQUEST);
//define('DS', '/');
include('../life.php');
$life = new life();
//print('update001');
//$to = urlencode($life->get_by_request('to'));
$to = $life->get_by_request('to');
$time = $life->get_by_request('time') / 1000;
//print('$to, $time: ');var_dump($to, $time);
//print('update002');

if(file_exists($to . '.xml')) {
	$found_local = true;
	$to = $to . '.xml';
}
//print('update0001<br />' . PHP_EOL);
if(!$found_local) {
	//print('update0002<br />' . PHP_EOL);
	$parsed_to = parse_url($life->ensure_scheme($to));
	//print('$parsed_to: ');var_dump($parsed_to);
	if($parsed_to['host'] == false || $parsed_to['path'] == false) {
		print('<code>no communications</code>'); // could differentiate between locals and remotes but that would defeat the eventual purpose
		exit(0);
	} else { // otherwise try remote
		//print('update0003<br />' . PHP_EOL);
		if(strpos($path, '/') === false) {
			$path .= '/'; // this makes the parser like it beter...
		}
		//$source = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
		$life->current_path = $source;
		//print('$to, $source: ');var_dump($to, $source);
		$absolutized_path = $life->absolutize_path($to);
		//print('$absolutized_path: ');var_dump($absolutized_path);
		$headers = get_headers($absolutized_path);
		//print('$headers: ');var_dump($headers);
		if($headers == false) {
			print('<code>no communications</code>');
			exit(0);
		} else {
			//print('update0004<br />' . PHP_EOL);
			$external_to = substr($absolutized_path, strpos($absolutized_path, '?to=') + 4);
			$external_to = substr($absolutized_path, 0, $life->strpos_last($absolutized_path, '/') + 1) . $life->query_encode($external_to) . '.xml';
			//print('$external_to, file_exists($external_to), file_get_contents($external_to): ');var_dump($external_to, file_exists($external_to), file_get_contents($external_to));
			$headers = get_headers($external_to);
			//if(file_exists($external_to)) {
			if(stripos($headers[0], '200 OK') !== false) {
				//$to = $external_to;
				$to = file_get_contents($external_to); // tricky
			} else {
				print('<code>' . $headers[0] . '</code>');
				exit(0);
			}
		}
	}
}
//print('update0005<br />' . PHP_EOL);
include('..' . DS . '..' . DS . 'LOM' . DS . 'O.php');
$O = new O($to);
foreach($O->get_tagged('message') as $message) {
	$existing_time = $O->_('time', $message);
	if($existing_time > $time) { // only print new messages
		print('<div title="' . date('Y-m-d H:i:s', $existing_time) . '">' . $O->_('from', $message) . ': ' . $O->_('text', $message) . '</div>
');
	}
}

?>
