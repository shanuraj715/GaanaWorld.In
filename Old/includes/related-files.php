<?php

function related_files(){
    global $this_song_category;
    $category_id = $this_song_category; // getting category id from song page.
    global $album_id; // from songs page. Written for future purpose
    global $conn;

    $sql = "SELECT * FROM songs WHERE album_id = $album_id and category_id = $category_id ORDER BY RAND() LIMIT 6";
    $query = mysqli_query($conn, $sql);
    if($query){
        $rows = mysqli_num_rows($query);
        if($rows != 0){
            while($result = mysqli_fetch_assoc($query)){
                song_block( $result );
            }
        }
        if($rows < RELATED_FILES_LIMIT){
            $limit = RELATED_FILES_LIMIT - $rows;
            $sql = "SELECT * FROM songs WHERE category_id = $category_id ORDER BY RAND() LIMIT $limit";
            $query = mysqli_query($conn, $sql);
            if($query){
                while($result = mysqli_fetch_assoc($query)){
                    song_block ( $result );
                }
            }
        }
        
    }
}

function song_block( $data ){ ?>
    <div class="new_upload_block">
        <div class="new_upload_image_block">
            <i class="fas fa-music new_upload_song_music_icon"></i>
        </div>
        
        <div class="new_upload_song_meta">
            <p class="new_upload_song_title">
                <a class="new_upload_link" href="<?php echo SITE_URL . 'song/' . $data['song_id'] . '/' . urlSongTitle($data['title']);?>"><?php echo $data['title'];?></a>
            </p>
            <span class="new_uploads_category"><?php echo catIdToName($data['category_id']);?></span>
            <span class="new_uploads_singer"><?php echo singerIdToName( $data['singer']);?></span>
            <span class="new_uploads_size"><?php echo $data['size'];?></span>
        </div>
    </div>
<?php
}

?>



<div class="related_files">
    <div class="main_title_cont">
        <p class="main_title">Related Files</p>
    </div>
    <?php related_files(); ?>
</div>