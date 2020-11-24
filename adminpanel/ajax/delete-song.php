<?php session_start();
include '../../config.php';
include '../../db.php';

if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
    if(isset($_POST['sid']) and is_numeric($_POST['sid']) and strlen($_POST['sid']) == 6){
        $sid = $_POST['sid'];
        if( validateUserForSongAccess($userid, $sid) and deleteFile($sid) ){
            $sql = "DELETE FROM songs WHERE song_id = $sid AND uploaded_by = $userid";
            global $conn;
            $query = mysqli_query($conn, $sql);
            if($query){
                echo 'success';
            }
            else{
                echo "Unable to delete the song.";
            }
        }
        else{
            echo "You are not allowed to delete this song";
        }
    }
    else{
        echo 'Song id is invalid or missing';
    }
}
else{
    echo "Please Log in to get access.";
}

function validateUserForSongAccess( $userid, $sid ){
    return true;

}

function deleteFile($song_id){

    global $conn;
    $sql = "SELECT * FROM songs WHERE song_id = $song_id";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    $file_name = $result['file_name'];
    $image = $result['image'];

    $address = '../../uploads/';

    $file_address = $address . date('m_Y', $result['upload_timestamp']) . '/' . $file_name;
    $image_address = $address . date('m_Y', $result['upload_timestamp']) . '/images/' . $image;

    if(file_exists($file_address) and file_exists($image_address)){
        if(unlink( $file_address )){
            if($image != ''){
                unlink( $image_address );
                return true;
            }
            else{
                return true;
            }
            
        }
        else{
            return false;
        }
    }
    else{
        return true;
    }

}


?>