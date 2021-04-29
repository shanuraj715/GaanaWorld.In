<?php

include '../config.php';
include '../db.php';
include '../functions/functions.php';

header("Content-Type: application/json");

$json = ['status' => true];
$email = '';
if( isset($_SESSION['fav_song_user_email']) ){
    $email = $_SESSION['fav_song_user_email'];
}
else{
    $json['status'] = false;
    $json['error'] = 'Please login first';
    echo json_encode( $json );
    exit();
}


$sql = "SELECT * FROM fav_songs_users WHERE email = '$email' LIMIT 1";
$query = mysqli_query($conn, $sql);
if( $query ){
    if( mysqli_num_rows( $query ) == 1 ){
        $res = mysqli_fetch_assoc( $query );
        $list = str_replace(' ', '', $res['songs']);
        $sid_array = explode(',', $list);
        $data_array = [];
        foreach( $sid_array as $key => $value ){
            if( is_numeric($value) ){
                $sql = "SELECT * FROM songs WHERE song_id = $value and status = 1 LIMIT 1";
                $query = mysqli_query($conn, $sql);
                if( $query ){
                    if( mysqli_num_rows( $query ) ){
                        $song_data = mysqli_fetch_assoc( $query );
                        $category_id = $song_data['category_id'];
                        $album_id = $song_data['album_id'];
                        $singer_id = $song_data['singer'];
                        $category_name = catIdToName( $song_data['category_id']);
                        $album_name = albumIdToName( $song_data['album_id']);
                        $song_id = $value;
                        $title = $song_data['title'];
                        $image = songImage($song_data['image'], date('m_Y', $song_data['upload_timestamp']), $song_data['category_id']);
                        $upload_date = $song_data['upload_date'];
                        $upload_timestamp = $song_data['upload_timestamp'];
                        $singer = singerIdToName( $song_data['singer'] );
                        $size = $song_data['size'];
                        $length = $song_data['length'];
                        $tags = $song_data['tags'] != '' ? explode(',', str_replace(', ', ',', str_replace(' ,', ',', $song_data['tags']))) : null;
                        $file_name = $song_data['file_name'];
                        $file_path = getFilePath( $file_name, $upload_timestamp );

                        $data = [
                            'songId' => $song_id,
                            'categoryId' => $category_id,
                            'categoryName' => $category_name,
                            'albumId' => $album_id,
                            'albumName' => $album_name,
                            'singerId' => $singer_id,
                            'singerName' => $singer,
                            'title' => $title,
                            'image' => $image,
                            'uploadDate' => $upload_date,
                            'uploadTimestamp' => $upload_timestamp,
                            'fileSize' => $size,
                            'fileLength' => $length,
                            'tags' => $tags,
                            'fileName' => $file_name,
                            'filePath' => str_replace(' ', '%20', $file_path)
                        ];
                        array_push($data_array, $data);
                    }
                }
            }
        }
        $json['data'] = $data_array;
    }
}

echo json_encode( $json );

?>