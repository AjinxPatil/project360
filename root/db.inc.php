<?php
define('MYSQL_HOST','localhost');
define('MYSQL_USER','projecti_1234');
define('MYSQL_PASSWORD','huzzah');
define('MYSQL_DB','projecti_123');
$db = mysql_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASSWORD) or die('Unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB,$db) or die(mysql_error($db));
?>