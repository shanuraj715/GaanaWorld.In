<?php
include './config.php';
include './db.php';
include './functions/functions.php';
if( isset($_GET['sid']) and !empty($_GET['sid']) and isset($_GET['key'])){
	$song_id = $_GET['sid'];
    $timestamp = $_GET['key'];
    $current_time = time();
    try{
        // check for valid song id

        $sql = "SELECT * from songs WHERE song_id = $song_id LIMIT 1";
        $query = mysqli_query( $conn, $sql );
        if( mysqli_num_rows( $query ) == 1 ){
            $result = mysqli_fetch_assoc( $query );

            if( $current_time - $timestamp <= 21600 && $timestamp <= $current_time ){ // checking for time expiry
                $song_dir = date('m_Y', $result['upload_timestamp']);
                $file_name = $result['file_name'];
                $song_file_http_address = SITE_URL . 'uploads/' . $song_dir . '/' . $file_name;
                $song_file_path = SITE_DIR . 'uploads/' . $song_dir . '/' . $file_name;
                if( file_exists( $song_file_path ) ){
                    header("Content-Disposition: attachment; filename=" . basename($song_file_path));
                    header("Content-Length: " . filesize($song_file_path));
                    header("Content-Type: application/octet-stream;");
                    header('Content-Transfer-Encoding: binary');
                    ob_clean();
                    flush();
                    readfile($song_file_path);
                }
                else{
                    header('Location:' . SITE_URL . 'song/' . $song_id . '/' . urlSongTitle($result['title']) );
                }
            }
            else{
                header('Location:' . SITE_URL . 'song/' . $song_id . '/' . urlSongTitle($result['title']) );
            }
        }
        else{
            header('Location:' . SITE_URL );
        }
    }
    catch( Exception $e){
        header('Location:' . SITE_URL );
    }
}
else{
    include './404.php';
    exit();
}


?>