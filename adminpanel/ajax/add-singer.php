<?php
session_start();
include '../../config.php';
include '../../db.php';

if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
    if(isset($_POST['singer_name']) and !empty($_POST['singer_name'])){
        global $conn;
        $singer_name = mysqli_real_escape_string($conn, $_POST['singer_name']);
        if(validateAdminForAccess( $userid )){
            $tags = '';
            if(isset($_POST['tags'])){
                $tags = mysqli_real_escape_string($conn, $_POST['tags']);
            }
            $sql = "INSERT INTO singers(singer_name, tags) VALUES('$singer_name', '$tags')";
            $query = mysqli_query($conn, $sql);
            if($query){
                echo 'success';
            }
            else{
                echo "Server is unable to add singer data in the database.";
            }
        }
        else{
            echo "You are not an authorized user to access this file.";
        }
    }
    else{
        echo "Singer name is missing";
    }
}
else{
    echo "Please login to continue";
}

function validateAdminForAccess($userid){
    global $conn;
    $sql = "SELECT * FROM accounts WHERE user_id = $userid";
    $query = mysqli_query($conn, $sql);
    if($query){
        $result = mysqli_fetch_assoc($query);
        if($result['is_admin'] == 1){
            return true;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}
?>