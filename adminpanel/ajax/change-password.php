<?php
session_start();
include '../../config.php';
include '../../db.php';
include '../functions/functions.php';

if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
    if(isset($_POST['pass']) and strlen($_POST['pass']) >=8 and strlen($_POST['pass']) <= 32){
        global $conn;
        $password = mysqli_real_escape_string($conn, $_POST['pass']);
        $password = encryptPassword($password);

        $sql = "UPDATE accounts set password = '$password' WHERE user_id = $userid";
        $query = mysqli_query($conn, $sql);
        if($query){
            echo "success";
        }
        else{
            echo "unable to update the password";
        }
    }
    else{
        echo "password length is short or missing value or length exceed";
    }
}
else{
    http_response_code('500');
}


?>