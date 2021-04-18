<?php

$db['host']         = 'localhost';
<<<<<<< HEAD
$db['username']     = 'root';
$db['password']     = '';
$db['db_name']      = 'gaanaworld.in';
=======
$db['username']     = 'db_username';
$db['password']     = 'db_pass';
$db['db_name']      = 'db_name';
>>>>>>> bcf70f4ccd2e161ddb13900fff271a3e1def9c27

foreach($db as $key => $value){
    define(strtoupper($key), $value);
}

$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME);


if(!$conn){
    die("Unable to connect to the database.");
}

?>
