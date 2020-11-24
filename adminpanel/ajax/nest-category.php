<?php
session_start();
include '../../config.php';
include '../../db.php';

if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
    if(isset($_POST['which']) and is_numeric($_POST['which']) and strlen($_POST['which'])){
        if(isset($_POST['to']) and is_numeric($_POST['to']) and strlen($_POST['to'])){
            $which = $_POST['which'];
            $to = $_POST['to'];
            if($which != $to){
                if(isToVaild( $userid, $to )){
                    if(isWhichValid( $userid, $which )){
                        global $conn;
                        $sql = "UPDATE categories SET parent = $to WHERE category_id = $which";
                        $query = mysqli_query($conn, $sql);
                        if($query){
                            echo "success";
                        }
                        else{
                            echo "Server is unable to update the category";
                        }
                    }
                    else{
                        echo 'Invalid category id';
                    }
                }
                else{
                    echo 'Invalid category id';
                }
            }
            else{
                echo "Both categories have same id. Error.";
            }
        }
        else{
            echo 'Invalid category id';
        }
    }
    else{
        echo 'invalid category id';
    }
}
else{
    echo "Please login to make changes";
}

function isToVaild( $userid, $to_cat ){
    global $conn;
    $sql = "SELECT * FROM categories WHERE belong_to_user = $userid AND category_id = $to_cat";
    $query = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($query);
    if($rows == 1){
        return true;
    }
    else{
        return false;
    }
}

function isWhichValid( $userid, $which_cat ){
    global $conn;
    $sql = "SELECT * FROM categories WHERE belong_to_user = $userid AND category_id = $which_cat";
    $query = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($query);
    if($rows == 1){
        return true;
    }
    else{
        return false;
    }
}
?>