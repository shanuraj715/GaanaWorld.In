<div class="admin-category">
    <div class="admin_category_block">
        <div class="add-cat-block">
            <a class="add-cat-btn" href="<?php echo SITE_URL . 'adminpanel/?page=category&action=add';?>">Add Category</a>
        </div>
    <p class="admin_page_titles">Manage Categories</p>
        <div class="admin-show-category-block">
            <div class="admin_cat_head_block">
                <span class="admin-cat-head ac_id">Category ID</span>
                <span class="admin-cat-head ac_name">Category Name</span>
                <span class="admin-cat-head ac_childname" title="Only one category will show.">Child Category (1)</span>
                <span class="admin-cat-head ac_total_songs">Total Songs</span>
                <span class="admin-cat-head ac_action">Actions</span>
            </div>
            <?php
            $userid = $_SESSION['userid'];

            $sql = "SELECT * from categories WHERE belong_to_user = $userid";
            global $conn;
            $query = mysqli_query($conn, $sql);
            if($query){
                while($result = mysqli_fetch_assoc($query)){
                    $category_id = $result['category_id'];
                    /* getting song count */
                    $sql = "SELECT * FROM songs WHERE category_id = $category_id";
                    $total_song_query = mysqli_query($conn, $sql);
                    $total_songs = mysqli_num_rows($total_song_query);
                    $this_cat_id = mysqli_fetch_assoc($total_song_query);
                    $this_cat_id = $this_cat_id['category_id'];

                    /* getting child cats */

                    $sql = "SELECT * from categories WHERE parent = $category_id";
                    $child_cat_q = mysqli_query($conn, $sql);
                    if($child_cat_q){
                        $child_cat = mysqli_fetch_assoc($child_cat_q);
                        $child_cat = $child_cat['category_name'];
                    }
                    else{
                        $child_cat = '';
                    } ?>




                    <div class="admin_cat_child_block">
                        <span class="admin-cat-child ac_id"><?php echo $result['category_id'];?></span>
                        <span class="admin-cat-child ac_name">
                            <!-- <i class="fas fa-heart"></i> -->
                            <?php echo $result['category_name'];?>
                        </span>
                        <span class="admin-cat-child ac_childname">
                            <?php if($child_cat != ''){ ?>
                                <i class="fas fa-hand-point-right"></i>
                            <?php
                            }
                            echo $child_cat; ?>
                        </span>
                        <span class="admin-cat-child ac_total_songs">   
                            <?php echo $total_songs; ?>
                        </span>
                        <span class="admin-cat-child ac_action">
                            <a class="admin-cat_action" href="<?php echo SITE_URL . 'adminpanel/?page=category&action=rename&cat_id=' . $result['category_id'];?>" title="Rename category"><i class="far fa-edit admin-cat-action-btn"></i></a>
                            <a class="admin-cat_action" href="<?php echo SITE_URL . 'adminpanel/?page=category&action=manage_child&cat_id=' . $result['category_id'];?>" title="Manage child categories"><i class="fas fa-project-diagram admin-cat-action-btn"></i></a>
                            <a class="admin-cat_action" href="<?php echo SITE_URL . 'adminpanel/?page=category&action=delete&cat_id=' . $result['category_id'];?>" title="Delete category"><i class="far fa-trash-alt admin-cat-action-btn"></i></a>
                        </span>
                    </div>
                <?php
                }
            } ?>
        </div>







        <?php
        if(isset($_GET['action'])){
            if(isset($_GET['cat_id'])){
                $cat_id = mysqli_real_escape_string($conn, $_GET['cat_id']);
                if($_GET['action'] == 'rename'){ ?>
                    <p class="admin_page_titles">Rename Category</p>
                    <div class="admin_cat_rename_block">
                        <input type="text" class="admin_cat_rename_inp" id="rename_inp" value="<?php echo catIdToName($cat_id);?>" />
                        <button class="admin_cat_rename_btn">Rename</button>
                    </div>
                    <script>
                        $('.admin_cat_rename_btn').click( () => {
                            let rename_value = $('#rename_inp').val();
                            let cat_id = '<?php echo $cat_id;?>';
                            if(rename_value != ''){
                                $.ajax({
                                    type: 'POST',
                                    data: 'rename_to=' + rename_value + '&cid=' + cat_id,
                                    url: '<?php echo SITE_URL;?>adminpanel/ajax/rename-category.php',
                                    success: function( data ){
                                        if(data == 'success'){
                                            window.open('<?php echo SITE_URL . "adminpanel/?page=category";?>', "_self");
                                        }
                                        else{
                                            alert("Server returned an unknown error.");
                                        }
                                    },
                                    error: function(){
                                        alert("Something went wrong. Unable to change the category name.");
                                    }
                                });
                            }
                        });
                    </script>
                <?php
                }
                elseif($_GET['action'] == 'manage_child'){ ?>
                    <p class="admin_page_titles">Nest Category</p>
                    <div class="admin-cat-nest-block">
                        <span class="admin-cat-nest-span"><?php echo catIdToName($cat_id); ?></span>
                        <select class="admin-nest-select">
                        <?php
                            $sql = "SELECT * FROM categories WHERE belong_to_user = $userid";
                            $query = mysqli_query($conn, $sql);
                            while($result = mysqli_fetch_assoc($query)){
                                $selected = "";
                                if($cat_id == $result['parent']){
                                    $selected = "selected='selected'";
                                }
                                if( $cat_id != $result['category_id']){ ?>
                                    <option class="admin-nest-opt" value="<?php echo $result['category_id'];?>" <?php echo $selected;?>><?php echo $result['category_name'];?></option>
                                <?php
                                }
                            } ?>
                        </select>
                        <button class="admin_nest_submit">Update</button>
                    </div>
                    <script>
                        $('.admin_nest_submit').click(() => {
                            let nest_to = $('.admin-nest-select').children("option:selected").val();
                            
                            $.ajax({
                                type: 'POST',
                                data: 'which=' + <?php echo $cat_id;?> + '&to=' + nest_to,
                                url: '<?php echo SITE_URL;?>adminpanel/ajax/nest-category.php',
                                success: function( data ){
                                    if(data == 'success'){
                                        window.open('<?php echo SITE_URL;?>adminpanel/?page=category', '_self');
                                    }
                                    else{
                                        alert(data);
                                    }
                                },
                                error: function(){
                                    alert("Unable to send data to the server.");
                                }
                            });
                        });
                    </script>
                    <?php
                }

                elseif($_GET['action'] == 'delete'){ ?>
                    <p class="admin_page_titles">Delete Category</p>
                    <div class="admin-delete-category">
                        <span class="admin-cat-delete-span"><?php echo catIdToName($cat_id);?></span>
                        <button class="admin-delete-cat-btn">Delete</button>
                        <button class="admin-delete-cat-btn2">Cancel</button>
                    </div>
                    <script>
                        $('.admin-delete-cat-btn').click( () => {
                           $.ajax({
                                type: 'POST',
                                data: 'cid=<?php echo $cat_id;?>',
                                url: '<?php echo SITE_URL;?>adminpanel/ajax/delete-category.php',
                                success: function( data ){
                                    if(data == 'success'){
                                        window.open('<?php echo SITE_URL;?>adminpanel/?page=category', '_self');
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
                        $('.admin-delete-cat-btn2').click(() => {
                            window.open('<?php echo SITE_URL;?>adminpanel/?page=category', '_self')
                        });
                    </script>
                <?php
                }
            }

            elseif($_GET['action'] == 'add'){ ?>
                <p class="admin_page_titles">Add Category</p>
                <div class="admin-add-cat">
                    <input type="text" class="admin-add-cat-inp" value="" placeholder="Enter category name" />
                    <textarea class="admin-add-cat-tags" value="" placeholder="Enter category tags"></textarea>
                    <button class="admin-add-cat-btn">Create Category</button>
                </div>
                <script>
                    $('.admin-add-cat-btn').click( () => {
                        let new_cat_name = $('.admin-add-cat-inp').val();
                        let tags = $('.admin-add-cat-tags').val();
                        $.ajax({
                            type: 'POST',
                            data: 'cat_name=' + new_cat_name + '&tags=' + tags,
                            url: '<?php echo SITE_URL;?>adminpanel/ajax/create-category.php',
                            success: function(data){
                                if(data == 'success'){
                                    window.open('<?php echo SITE_URL;?>adminpanel/?page=category', '_self');
                                }
                                else{
                                    alert(data);
                                }
                            },
                            error: function(){
                                alert('Unable to send data to the server');
                            }
                        });
                    });
                </script>
                <?php
            }
        } ?>
        
        

    </div>
</div>