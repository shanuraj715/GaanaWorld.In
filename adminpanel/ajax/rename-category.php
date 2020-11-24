<?php
session_start();
include '../../config.php';
include '../../db.php';

global $conn;
if(isset($_SESSION['userid'])){
    if(isset($_POST['cid']) and is_numeric($_POST['cid']) and (strlen($_POST['cid']) == 6)){
        if(isset($_POST['rename_to']) and (strlen($_POST['rename_to']) >= 4)){
            $category_id = mysqli_real_escape_string($conn, $_POST['cid']);
            $rename_text = mysqli_real_escape_string($conn, $_POST['rename_to']);
            $sql = "UPDATE categories SET category_name = '$rename_text' WHERE category_id = $category_id";
            $query = mysqli_query($conn, $sql);
            if($query){
                echo "success";
            }
            else{
                echo "fail1";
            }
        }
        else{
            echo 'fail2';
        }
    }
    else{
        echo 'fail3';
    }
}
else{
    echo 'fail4';
}