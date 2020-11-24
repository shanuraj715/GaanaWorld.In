<?php
session_start();
include '../../config.php';
include '../../db.php';

if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
    
    if(isset($_POST['singer_id']) and is_numeric($_POST['singer_id'])){
        $singer_id = $_POST['singer_id'];
        global $conn;
        if(validateAdminForAccess( $userid )){
            $sql = "DELETE FROM singers WHERE singer_id = $singer_id";
            $query = mysqli_query($conn, $sql);
            if($query){
                echo 'success';
            }
            else{
                echo "Server is unable to delete the record.";
            }
        }
        else{
            echo "You are not an authorized user to access this file.";
        }
    }
    else{
        echo "Singer id is missing";
    }
}
else{
    echo "Please login to continue";
}





function validateAdminForAccess( $userid ){
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