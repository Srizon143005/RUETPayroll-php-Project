<?php

$db['db_host'] = 'localhost:3307';
$db['db_user'] = 'root';
$db['db_pass'] = '';
$db['db_name'] = 'ruet_payroll';

foreach($db as $key => $value){
    define(strtoupper($key), $value);
}

$con = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

?>
