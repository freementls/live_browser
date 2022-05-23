<?php

$string = 'aaa_bbb_ccc a_b_c';
preg_match_all('/\w+/is', $string, $matches);
print('$matches: ');var_dump($matches);

?>