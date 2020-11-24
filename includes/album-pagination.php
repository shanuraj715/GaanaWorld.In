<?php

$prev_page_num = '#';
$next_page_num = '#';

$this_page_number = 1;
$preview_btn_disabled = false;
$next_btn_disabled = false;
$initial_count_for_pagination = 1;

$limit = ALBUM_SHOW_LIMIT;

$sql = "SELECT album_id from albums WHERE category_id = $cat_id";
$query = mysqli_query($conn, $sql);
if($query){
    $rows = mysqli_num_rows($query);

    $total_pages = ceil( $rows / ALBUM_SHOW_LIMIT );
}

if(isset($_GET['page']) and !empty($_GET['page'])){
    if(is_numeric($_GET['page'])){
        $this_page_number = $_GET['page'];
    }

    if($this_page_number == 1){
        $preview_btn_disabled = true;
        $prev_page_num = '#';
    }

    if($this_page_number == $total_pages){
        $next_btn_disabled = true;
    }
    else{

    }
}
else{

}

?>


<div class="pagination">
    <?php
    if(!$preview_btn_disabled and false){ ?>
        <div class="pagination_btn_block">
            <a class="paginatiion_prev_btn pagination_link" href='<?php echo SITE_URL . 'category/' . $category_id . '?page=' . $this_page_number - 1;?>'>Prev</a>
        </div>
    <?php
    } 
    
    while($initial_count_for_pagination <= $total_pages){
        
        if($initial_count_for_pagination == $this_page_number){ ?>
            <div class="pagination_btn_block">
                <span class="pagination_btn pagination_link active_page_pagination"><?php echo $initial_count_for_pagination; ?></span>
            </div>
        <?php
        }
        else{ ?>
            <div class="pagination_btn_block">
                <a class="pagination_btn pagination_link" href="<?php echo SITE_URL . 'albums/' . $cat_id . '?page=' . $initial_count_for_pagination;?>"><?php echo $initial_count_for_pagination; ?></a>
            </div>
        <?php
        }
        $initial_count_for_pagination++;
    }
    
    if(!$next_btn_disabled and false){ ?>
        <div class="pagination_btn_block">
            <a class="paginatiion_next_btn pagination_link" href=<?php echo SITE_URL . 'category/' . $category_id . '?page=' . $initial_count_for_pagination + 1;?>>Next</a>
        </div>
    <?php
    }
    
     ?>
    
    
</div>