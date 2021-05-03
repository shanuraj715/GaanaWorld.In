<?php

function is_logged(){
    if(isset($_SESSION['userid'])){
        return true;
    }
    else{
        return false;
    }
}

function include_page(){
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        if(file_exists('./pages/' . $page . '.php')){
            include './pages/' . $page . '.php';
        }
        else{
            include './pages/err404.php';
        }
    }
    else{
        include './pages/upload.php';
    }

}

function encryptPassword($password){
	$hashFormat = "$2y$10$";
	$salt = "iamagoodcoderofphp7151";
	$hash_and_salt = $hashFormat . $salt;
	$Encrypted_password = crypt($hash_and_salt, $password);
	return $Encrypted_password;
}

function limitChars( $data, $limit ){
    if(strlen($data) <= $limit){
        return $data;
    }
    else{
        return substr($data, 0, $limit) . '...';
    }
}

function loginDisabled(){
    echo "<h1 style='text-align: center;'>Feature is disabled for some time. We will come back soon. We are currently updating our server.</h1>";
}

?>