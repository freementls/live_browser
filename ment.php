<?php

//print('$_SERVER: ');var_dump($_SERVER);
//print('$_REQUEST: ');var_dump($_REQUEST);
//$data = get_by_request('data');
if(sizeof($_REQUEST) > 1) {
  // a (satanic) computer is really dumb!
  print('can\'t think about more than one thing at once! $_REQUEST: ');var_dump($_REQUEST);
  exit(0);
} else {
  foreach($_REQUEST as $about => $about_value) { break; }
}

define(DS, DIRECTORY_SEPARATOR);
include('..' . DS . 'LOM' . DS . 'O.php');
if(!file_exists('mind.xml')) {
  file_put_contents('mind.xml', '');
}
$O = new O('mind.xml');

// always just search for now. how to choose what to search with..?
// https://schema.org/ could be interesting results if we let the AI try to dynamically determine the relevant scheme!
$action = 'search';
print($action . ':' . $about);

$O->new_('<thought><about>' . $about . '</about><time>' . microtime() . '</time><action>' . $action . '</action></thought>
'); // don't really have to worry about the time format because if we are still using this in 2038 we have bigger problems ;p
$O->save();

function get_by_request($variable) {
  return $_REQUEST[$variable];
  // what about data types when it's not in the request?
}

?>
