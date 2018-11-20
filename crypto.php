<?php
$bad = md5('123');
$average = sha1('123'); //+SALT = good
$good = password_hash('123', PASSWORD_DEFAULT);

echo $bad, PHP_EOL, $average, PHP_EOL, $good, PHP_EOL;

password_verify($_REQUEST['password'], $databaseHash);