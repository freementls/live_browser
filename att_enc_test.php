<?php

$contents = 'ccc<a href="http://somelink">some link text</a>ddd';
//print('here001<br />');
define(DS, DIRECTORY_SEPARATOR);
//print('here002<br />');
include('..' . DS . 'LOM' . DS . 'O.php');
//print('here003<br />');
$O = new O($contents);
//print('here004<br />');
$a = $O->get_tagged('a@href=' . $O->enc('http://somelink'));
//print('here005<br />');exit(0);
print('$a: ');var_dump($a);

?>