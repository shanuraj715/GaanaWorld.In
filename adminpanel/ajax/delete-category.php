<?php
session_start();
include '../../config.php';
include '../../db.php';

if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
    if(isset($_POST['cid']) and is_numeric($_POST['cid']) and strlen($_POST['cid']) == 6){
        global $conn;
        $cat_id = mysqli_real_escape_string($conn, $_POST['cid']);
        if(checkForRootCategory( $userid, $cat_id )){
            if( validateUserWithCategory( $userid, $cat_id )){
    
                /* get parent to update child categories */
    
                $sql = "SELECT * FROM categories WHERE category_id = $cat_id";
                $query = mysqli_query($conn, $sql);
                $parent_id = mysqli_fetch_assoc($query);
                $parent_id = $parent_id['parent'];
    
    
                $sql = "DELETE FROM categories WHERE category_id = $cat_id";
                $query = mysqli_query($conn, $sql);
                if($query){
                    $sql = "UPDATE categories SET parent = $parent_id WHERE parent = $cat_id";
                    $query = mysqli_query($conn, $sql);
                    if($query){
                        if(updateSongCategory( $cat_id, $parent_id )){
                            echo 'success';
                        }
                        else{
                            echo "Unable to update the record for the song";
                        }
                    }
                    else{
                        echo "Delete Successful but child parent updation failed.";
                    }
                }
                else{
                    echo "Unable to delete the category";
                }
            }
            else{
                echo "Validation for the user failed.";
            }

        }
        else{
            echo "You can not delete your root category. Please contact the site admin for assistance";
        }
    }
    else{
        echo "Category id not found";
    }
}
else{
    echo "Please login first to make changes";
}

function validateUserWithCategory( $userid, $cat_id ){
    global $conn;
    $sql = "SELECT * FROM categories WHERE category_id = $cat_id AND belong_to_user = $userid";
    $query = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($query);
    if($rows == 1){
        return true;
    }
    else{
        return false;
    }
    
}

function checkForRootCategory( $userid, $cid ){
    global $conn;
    $sql = "SELECT * from categories WHERE category_id = $cid AND belong_to_user = $userid";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    if($result['is_user_root'] == 1){
        return false;
    }
    else{
        return true;
    }
}

function updateSongCategory( $this_cat, $next_cat ){
    global $conn;
    $sql = "UPDATE songs SET category_id = $next_cat WHERE category_id = $this_cat";
    $query = mysqli_query($conn, $sql);
    if($query){
        return true;
    }
    else{
        return false;
    }
}

?>