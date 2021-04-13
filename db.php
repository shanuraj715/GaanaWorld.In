<?php

$db['host']         = 'localhost';
$db['username']     = 'db_username';
$db['password']     = 'db_pass';
$db['db_name']      = 'db_name';

foreach($db as $key => $value){
    define(strtoupper($key), $value);
}

$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME);


if(!$conn){
    die("Unable to connect to the database.");
}

?>
