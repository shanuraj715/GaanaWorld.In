<?php

$this_page = explode('/', $_SERVER['SCRIPT_NAME']);
$this_page = end($this_page);

$breadcrumb_array = [];

if($this_page == 'song.php'){
    $url_values = explode('/', THIS_PAGE);
    $index = array_search('song', $url_values);

    if(!is_numeric($index)){
        echo "Incorrect parameters for the song.";
        exit();
    }
    else{
        $song_id = $url_values[$index + 1];
    }

    $sql = "SELECT category_id from songs where song_id = $song_id";
    // $query = mysqli_query($conn, $sql);
    // if($query){
    //     $result = mysqli_fetch_assoc($query);
    //     $category_id = $result['category_id'];
    //     $category_name = catIdToName($result['category_id']);
    //     $arr = [$category_name => $result['category_id']];
    //     $breadcrumb_array = array_merge($breadcrumb_array, $arr);


    //     print_r($breadcrumb_array);
    //     $sql = "SELECT category_id from categories WHERE category_id = $parent_id";
    //     $query = mysqli_query($conn, $sql);
    //     if($query){
    //         $rows = mysqli_num_rows($query);
    //         if($rows == 1){
    //             $result = mysqli_fetch_assoc($query);
    //             $category_id = $result['category_id'];
    //             $category_name = catIdToName( $result['category_id'] );
    //             $arr = [$category_name => $category_id];
    //             $breadcrumb_array = array_merge( $breadcrumb_array, $arr );
    //             print_r($breadcrumb_array);
    //         }
    //     }
    // }


    $query = mysqli_query($conn, $sql);
    if($query){
        $result = mysqli_fetch_assoc($query);
        $category_name = catIdToName($result['category_id']);
        $category_id = $result['category_id'];
        $arr = [$category_name => $category_id];
        $breadcrumb_array = array_merge($breadcrumb_array, $arr);
        // print_r($breadcrumb_array);

        $sql = "SELECT * FROM categories WHERE category_id = $category_id";
        $query = mysqli_query($conn, $sql);
        if($query){
            $result = mysqli_fetch_assoc($query);
            $parent_id = $result['parent'];
            if($result['parent'] != 0){
                $parent_id = $result['parent'];
                while($parent_id != 0){

                    $sql = "SELECT * from categories WHERE category_id = $parent_id";
                    $query = mysqli_query($conn, $sql);
                    if($query){
                        $result = mysqli_fetch_assoc($query);
                        $category_id = $result['category_id'];
                        $category_name = catIdToName($result['category_id']);
                        $arr = [$category_name => $category_id];
                        $breadcrumb_array = array_merge($breadcrumb_array, $arr);
                        $parent_id = $result['parent'];
                    }
                    else{
                        $parent_id = 0;
                    }
                }
            }
        }
        $breadcrumb_array = array_reverse($breadcrumb_array);
        $arr = [ucwords($title) => '#'];
        $breadcrumb_array = array_merge($breadcrumb_array, $arr);
        
    }
}
elseif($this_page == 'category.php'){
    $this_category = explode('/', THIS_PAGE);
    $this_category = end($this_category);

    $this_category = explode('?', $this_category);
    $this_category = $this_category[0];
    
    $sql = "SELECT * from categories WHERE category_id = $this_category";
    $query = mysqli_query($conn, $sql);
    if($query){
        $result = mysqli_fetch_assoc($query);
        $category_name = catIdToName($result['category_id']);
        $arr = [$category_name => $category_id];
        $breadcrumb_array = array_merge($breadcrumb_array, $arr);
        // print_r($breadcrumb_array);

        if($result['parent'] != 0){
            $parent_id = $result['parent'];
            while($parent_id != 0){
                $sql = "SELECT * from categories WHERE category_id = $parent_id";
                $query = mysqli_query($conn, $sql);
                if($query){
                    $result = mysqli_fetch_assoc($query);
                    $category_id = $result['category_id'];
                    $category_name = catIdToName($result['category_id']);
                    $arr = [$category_name => $category_id];
                    $breadcrumb_array = array_merge($breadcrumb_array, $arr);
                    $parent_id = $result['parent'];
                }
                else{
                    $parent_id = 0;
                }
            }
        }
    }
    $breadcrumb_array = array_reverse($breadcrumb_array);
}



?>


<div class="breadcrumb">
    <p class="breadcrumb_row">
        <a class="breadcrumb_link" href="<?php echo SITE_URL; ?>">Home</a>
        <span class="breadcrumb_saperator"> <i class="fas fa-caret-right breadcrumb-saperator"></i> </span>
        <?php
        foreach($breadcrumb_array as $category_name => $category_id){
            if($category_id != '#'){ ?>
                <a class="breadcrumb_link" href="<?php echo SITE_URL . 'category/' . $category_id;?>"><?php echo $category_name; ?></a>
                <span class="breadcrumb_saperator"> <i class="fas fa-caret-right breadcrumb-saperator"></i> </span>
            <?php
            }
            else{ ?>
                <span class="breadcrumb_link"><?php echo $category_name; ?></span>
            <?php
            }
        } ?>
    </p>
</div> 