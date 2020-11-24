<?php
session_start();
include '../../config.php';
include '../../db.php';

if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
    if(isset($_POST['cat_name']) and !empty($_POST['cat_name'])){
        global $conn;
        $cat_name = mysqli_real_escape_string($conn, $_POST['cat_name']);
        $tags = mysqli_real_escape_string($conn, $_POST['tags']);
        $parent = getUserTopParentCat( $userid );
        $created_dt = time();

        $sql = "INSERT INTO categories (category_name, parent, tags, created_date_time, belong_to_user)";
        $sql .= " VALUES('$cat_name', $parent, '$tags', '$created_dt', $userid)";
        $query = mysqli_query($conn, $sql);
        if($query){
            echo 'success';
        }
        else{
            // echo "Unable to add category.";
            echo mysqli_error($conn);
        }
    }
    else{
        echo "Category name missing.";
    }
}
else{
    echo "Please login first to continue";
}

function getUserTopParentCat( $userid ){
    global $conn;
    $sql = "SELECT * FROM categories WHERE belong_to_user = $userid AND is_user_root = 1";
    $query = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($query);
    if($rows == 1){
        $result = mysqli_fetch_assoc($query);
        return $result['category_id'];
    }
    else{
        return '0';
    }
   
}


?>