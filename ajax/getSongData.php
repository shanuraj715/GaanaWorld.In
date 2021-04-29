<?php
include '../config.php';
include '../db.php';
include '../functions/functions.php';

$json = ['status' => false];
if( isset($_POST['sid']) and !empty($_POST['sid'])){
    if( is_numeric($_POST['sid'])){
        $sid = mysqli_real_escape_string($conn, $_POST['sid']);
        $sql = "SELECT * FROM songs WHERE song_id = $sid LIMIT 1";
        $query = mysqli_query( $conn, $sql );
        if( mysqli_num_rows( $query ) == 1 ){
            $res = mysqli_fetch_assoc( $query );
            $json['title'] = $res['title'];
            // songImage($result['image'], date('m_Y', $result['upload_timestamp']), $result['category_id']);
            $json['image'] = songImage( $res['image'], date('m_Y', $res['upload_timestamp']), $res['category_id']);
            $json['file'] = SITE_URL . 'uploads/' . date('m_Y', $res['upload_timestamp']) . '/' . $res['file_name'];
            $json['pageTitle'] = urlSongTitle( $res['title']);

            $json['status'] = true;
        }
    }
}

echo json_encode($json);
?>
