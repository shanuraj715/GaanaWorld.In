<div class="admin-category">
    <div class="admin_category_block" id="admin_uploads_block">
        <div class="add-cat-block">
            <a class="add-cat-btn" href="<?php echo SITE_URL . 'adminpanel/?page=upload';?>">Upload New Song</a>
        </div>
        <p class="admin_page_titles">Manage Uploads</p>
        <div class="admin-show-category-block">
            <div class="admin_cat_head_block">
                <span class="admin-cat-head admin-song_id">Song ID</span>
                <span class="admin-cat-head admin-song_name">Song Name</span>
                <span class="admin-cat-head admin-song_date">Date</span>
                <span class="admin-cat-head admin-song_category">Category</span>
                <span class="admin-cat-head admin-song_album">Album</span>
                <span class="admin-cat-head admin-song_singer">Singer</span>
                <span class="admin-cat-head admin-song_downloads">Down.</span>
                <span class="admin-cat-head admin-song_action">Actions</span>
            </div>
            <?php
            $userid = $_SESSION['userid'];
            
            /* limiting category list for pagination */

            if(isset($_GET['p']) and is_numeric($_GET['p'])){
                $p = $_GET['p'];
            }
            else{
                $p = 1;
            }
            $offset = ($p * ADMIN_SONG_LIMIT) - ADMIN_SONG_LIMIT;
            $limit = ADMIN_SONG_LIMIT;


            /* end limiting category list for pagination */


            
            $sql = "SELECT * from songs WHERE uploaded_by = $userid ORDER BY song_id DESC LIMIT $limit OFFSET $offset";
            global $conn;
            $query = mysqli_query($conn, $sql);
            if($query){
                while($result = mysqli_fetch_assoc($query)){
                    $category_id = $result['category_id'];

                    $song_id = $result['song_id'];
                    $title = limitChars($result['title'], 50);
                    $date = date('d-m-y', $result['upload_timestamp']);
                    $cat_name = limitChars(catIdToName($result['category_id']), 12);
                    $album_name = limitChars(albumIdToName($result['album_id']), 12);
                    $singer_name = limitChars(singerIdToName($result['singer']), 12);
                    $total_downloads = $result['total_downloads'];                    
                    ?>

                    <div class="admin_uploads_child_block">
                        <span class="admin-cat-child admin-song_id"><?php echo $song_id;?></span>
                        <span class="admin-cat-child admin-song_name" title="<?php echo $result['title'];?>"><?php echo $title;?></span>
                        <span class="admin-cat-child admin-song_date"><?php echo $date;?></span>
                        <span class="admin-cat-child admin-song_category" title="<?php echo catIdToName($result['category_id']);?>"><?php echo $cat_name;?></span>
                        <span class="admin-cat-child admin-song_album" title="<?php echo albumIdToName($result['album_id']);?>"><?php echo $album_name;?></span>
                        <span class="admin-cat-child admin-song_singer" title="<?php echo singerIdToName($result['singer']);?>"><?php echo $singer_name;?></span>
                        <span class="admin-cat-child admin-song_downloads"><?php echo $total_downloads;?></span>
                        <span class="admin-cat-child admin-song_action">
                            <!-- <a class="admin-cat_action" href="<?php //echo THIS_PAGE . '&action=rename&cat_id=' . $result['category_id'];?>" title="Rename Song"><i class="far fa-edit admin-cat-action-btn"></i></a> -->
                            <a class="admin-cat_action" href="<?php echo THIS_PAGE . '&action=delete&song_id=' . $result['song_id'];?>" title="Delete Song"><i class="far fa-trash-alt admin-cat-action-btn"></i></a>
                            <a class="admin-cat_action" href="<?php echo SITE_URL . 'song/' . $song_id . '/' . urlSongTitle($result['title']);?>" title="View Song (Opens in New Tab)" target="_blank"><i class="fas fa-eye admin-cat-action-btn"></i></a>
                        </span>
                    </div>
                <?php
                }
            } ?>
        </div>
        <div class="admin-pagination">
            <?php
            $sql = "SELECT song_id from songs WHERE uploaded_by = $userid";
            $query = mysqli_query($conn, $sql);
            $rows = mysqli_num_rows($query);
            $pages = ceil($rows / ADMIN_SONG_LIMIT);

            if(isset($_GET['p'])){
                $this_page_num = $_GET['p'];
            }
            else{
                $this_page_num = 1;
            }


            for($i = 1; $i <= $pages; $i++){
                if($this_page_num == $i){ ?>
                    <span class="admin_pagination_btn admin_this_page_pagination"><?php echo $i; ?></span>
                <?php
                }
                else{ ?>
                    <a class="admin_pagination_btn" href="<?php echo SITE_URL . 'adminpanel/?page=manage-uploads&p=' . $i;?>"><?php echo $i; ?></a>
                <?php
                } ?>
                
            <?php
            }
            ?>
        </div>







        <?php
        if(isset($_GET['action'])){
            if(isset($_GET['song_id'])){
                $song_id = mysqli_real_escape_string($conn, $_GET['song_id']);
                if($_GET['action'] == 'delete'){ ?>
                    <p class="admin_page_titles">Delete Song</p>
                    <div class="admin-delete-category">
                        <span class="admin-cat-delete-span"><?php echo songIdToName($song_id);?></span>
                        <button class="admin-delete-song-btn">Delete</button>
                        <button class="admin-delete-song-btn2">Cancel</button>
                    </div>
                    <script>

                        $('.admin-delete-song-btn').click( () => {
                           $.ajax({
                                type: 'POST',
                                data: 'sid=<?php echo $song_id;?>',
                                url: '<?php echo SITE_URL;?>adminpanel/ajax/delete-song.php',
                                success: function( data ){
                                    if(data == 'success'){
                                        window.open('<?php echo SITE_URL;?>adminpanel/?page=manage-uploads', '_self');
                                    }
                                    else{
                                        alert(data);
                                    }
                                },
                                error: function (){
                                    alert("Unable to send data to the server");
                                }
                            });
                        });
                        $('.admin-delete-song-btn2').click(() => {
                            window.open('<?php echo SITE_URL;?>adminpanel/?page=manage-uploads', '_self');
                        });
                    </script>
                <?php
                }
            }
        } ?>
        
        

    </div>
</div>