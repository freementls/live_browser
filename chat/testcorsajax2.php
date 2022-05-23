<?php

define('DS', '/');
include('..' . DS . '..' . DS . 'LOM' . DS . 'O.php');
$O = new O($to . '.xml');
$O->_new('<message><source>' . $source . '</source><from>' . $from . '</from><time>' . $time . '</time><text>' . $message . '</text></message>');
print('<div title="' . date('Y-m-d H:i:s', $time) . '">' . $from . ': ' . $message . '</div>
');
$O->save();

?>
