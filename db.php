<?php

$db['host']         = 'localhost';
$db['username']     = 'root';
$db['password']     = 'vips';
$db['db_name']      = 'new_djraj';
// $db['host']         = '103.129.98.12';
// $db['username']     = 'techfact_new_dj';
// $db['password']     = 'shanuraj715';
// $db['db_name']      = 'techfact_new_djraj';

foreach($db as $key => $value){
    define(strtoupper($key), $value);
}

$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME);


if(!$conn){
    die("Unable to connect to the database.");
}

?>