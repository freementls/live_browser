<?php

/*include('life.php');
$life = new life();
$life->recursiveChmod('');*/
mkdir('cache\test_dir');
$put_result1 = file_put_contents('cache\test_dir\test_file.txt', 'some contents');
$put_result2 = file_put_contents('cache\www.spriters-resource.com\includes\css\some_file.txt', 'some txt contents');
$put_result3 = file_put_contents('cache\www.spriters-resource.com\includes\css\some_file.css', 'some css contents');
print('$put_result1, $put_result2, $put_result3: ');var_dump($put_result1, $put_result2, $put_result3);

?>