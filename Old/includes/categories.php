<?php
$this_page = $_SERVER['SCRIPT_NAME'];
$this_page = explode('/', $_SERVER['SCRIPT_NAME']);
$this_page = end($this_page);
// echo $this_page;

function category_list(){
    global $conn;
    $category_id = explode('/', THIS_PAGE);
    $category_id = end($category_id);

    if(is_numeric($category_id)){
        $sql = "SELECT * FROM categories WHERE parent = $category_id ORDER BY category_name ASC";
        $query = mysqli_query($conn, $sql);
        if($query){
            $rows = mysqli_num_rows($query);
            if($rows >= 1){
                while($result = mysqli_fetch_assoc($query)){
                    $category_name = $result['category_name'];
                    $category_id = $result['category_id']; ?>
                    <div class="category_block">
                        <p class="category_line">
                            <i class="fas fa-angle-double-right category_icon"></i>
                            <a class="category_link" href="<?php echo SITE_URL . 'category/' . $category_id; ?>"><?php echo $category_name;?></a>
                        </p>
                    </div>
                    <?php
                }
            }
        }
    }
}

function homepage_category_list(){
    global $conn;
    $sql = "SELECT * FROM categories WHERE parent = 0";
    $query = mysqli_query($conn, $sql);
    if($query){
        while($result = mysqli_fetch_assoc($query)){
            $category_name = $result['category_name'];
            $category_id = $result['category_id']; ?>
            <div class="category_block">
                <p class="category_line">
                    <i class="fas fa-angle-double-right category_icon"></i>
                    <a class="category_link" href="<?php echo SITE_URL . 'category/' . $category_id; ?>"><?php echo $category_name;?></a>
                </p>
            </div>
            <?php
        } ?>
        <div class="category_block">
            <p class="category_line">
                <i class="fas fa-angle-double-right category_icon"></i>
                <a class="category_link" href="<?php echo SITE_URL . 'albums/424145';?>">Hindi Albums</a>
            </p>
        </div>
        <!-- <div class="category_block">
            <p class="category_line">
                <i class="fas fa-angle-double-right category_icon"></i>
                <a class="category_link" href="<?php //echo SITE_URL . 'albums/424146';?>">Bhojpuri Albums</a>
            </p>
        </div>
        <div class="category_block">
            <p class="category_line">
                <i class="fas fa-angle-double-right category_icon"></i>
                <a class="category_link" href="<?php //echo SITE_URL . 'albums/424147';?>">Haryanavi Albums</a>
            </p>
        </div> -->
        <div class="category_block">
            <p class="category_line">
                <i class="fas fa-angle-double-right category_icon"></i>
                <a class="category_link" href="<?php echo SITE_URL . 'singer-list';?>">Songs by Singer Name</a>
            </p>
        </div>
        <?php
    }
    else{
        echo "Unable to fetch category list from the server.";
    }
}

?>




<div class="categories_container">
    <div class="main_title_cont">
        <p class="main_title">Music Categories</p>
    </div>
    <?php $this_page == 'category.php' ? category_list() : homepage_category_list(); ?>
</div>