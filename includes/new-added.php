<?php


function new_added(){
    global $conn;
    $limit = NEW_SONG_LIMIT;
    $db_string = "SELECT * FROM songs WHERE status = 1 ORDER BY upload_timestamp DESC LIMIT $limit";
    $query = mysqli_query($conn, $db_string);
    if($query){
        while($result = mysqli_fetch_assoc($query)){
            $title = $result['title'];
            $category_name = catIdToName(  $result['category_id'] );
            $singer_name = singerIdToName ( $result['singer'] );
            $total_downloads = $result['total_downloads'];
            $size = $result['size'];
            $song_link = SITE_URL . 'song/' . $result['song_id'] . '/' . urlSongTitle($result['title']);
            ?>
            <div class="new_upload_block">
                <div class="new_upload_image_block">
                    <i class="fas fa-music new_upload_song_music_icon"></i>
                </div>
                
                <div class="new_upload_song_meta">
                <p class="new_upload_song_title"><a class="new_upload_link" href="<?php echo $song_link;?>"><?php echo $result['title'];?></a></p>
                    <span class="new_uploads_category"><?php echo $category_name; ?></span>
                    <span class="new_uploads_singer"><?php echo $singer_name; ?></span>
                    <span class="new_uploads_size"><?php echo $result['size']; ?></span>
                </div>
            </div>
        <?php
        }
    }
}


?>



<div class="new_uploads_container">
    <div class="main_title_cont">
        <p class="main_title">New Added Songs</p>
    </div>
    <?php new_added(); ?>
</div>