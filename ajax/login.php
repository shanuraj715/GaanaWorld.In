<?php
include '../config.php';
include '../db.php';

$json = ['status' => true];
if(isset($_POST['email'])){
    $email = mysqli_real_escape_string( $conn, $_POST['email']);
    $sql = "SELECT * FROM fav_songs_users WHERE email = '$email' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if( mysqli_num_rows( $query ) == 0 ){
        $sql = "INSERT INTO fav_songs_users(`email`, `songs`) VALUES( '$email', '' )";
        $query = mysqli_query( $conn, $sql );
        if( !$query ){
            $json['status'] = false;
        }
        else{
            $_SESSION['fav_song_user_email'] = $email;
            
        }
    }
    else{
        $_SESSION['fav_song_user_email'] = $email;
    }
}

echo json_encode($json);

?>