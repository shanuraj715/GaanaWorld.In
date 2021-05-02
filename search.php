<?php include './config.php';
include './db.php';
include './functions/functions.php';

$search_text = explode('/', THIS_PAGE);
$search_text = end($search_text);
$search_text = explode( '?', $search_text);
if(count($search_text) >= 1){
    $search_text = $search_text[0];
    $search_text = mysqli_real_escape_string($conn, $search_text);
}
else{
    $search_text = [0];
}

/* getting the curent page value from the query string */

if(isset($_GET['page']) and !empty($_GET['page'])){
    if(is_numeric($_GET['page'])){
        $page = $_GET['page'];
    }
    else{
        $page = 1;
    }
}
else{
    $page = 1;
}

// $is_data_available = false;

function getSearchedData( $search_data ){
    global $conn;
    
    $sql = "SELECT * FROM songs WHERE tags LIKE '%$search_data%'";
    $sql .= " OR title LIKE '%$search_data%'";
    $sql .= getCategoryId( $search_data );
    $sql .= getSingerId( $search_data );
    $sql .= ' ORDER BY song_id DESC LIMIT 20';

    $query = mysqli_query($conn, $sql);

    if($query){
        $rows = mysqli_num_rows($query);
        if($rows != 0){
            while( $result = mysqli_fetch_assoc($query) ){
                searched_songs( $result );
            }
        }
        else{
            notingFound();
        }
    }

}

function notingFound(){ ?>
    <h1 style="text-align: center;"> No Result Found</h1>
<?php
}

function searched_songs( $data ){
    $song_title_for_url = urlSongTitle($data['title']);
    ?>
    <div class="new_upload_block">
        <div class="new_upload_image_block">
            <i class="fas fa-music new_upload_song_music_icon"></i>
        </div>
        
        <div class="new_upload_song_meta">
            <p class="new_upload_song_title">
                <a class="new_upload_link" href="<?php echo SITE_URL . 'song/' . $data['song_id'] . '/' . $song_title_for_url;?>"><?php echo $data['title'];?></a>
            </p>
            <span class="new_uploads_category"><?php echo catIdToName($data['category_id']);?></span>
            <span class="new_uploads_singer"><?php echo singerIdToName( $data['singer']);?></span>
            <span class="new_uploads_size">Size: <?php echo $data['size'];?></span>
        </div>
    </div>
<?php
}

function getCategoryId($search_data){
    global $conn;
    $sql = "SELECT * FROM categories WHERE category_name LIKE '%$search_data%'";
    $query = mysqli_query($conn, $sql);
    if($query){
        $rows = mysqli_num_rows($query);
        if($rows != 0){
            $string = '';
            while( $result = mysqli_fetch_assoc($query) ){
                $string .= ' OR category_id = ' . $result['category_id'];
            }
            return $string;
        }
        else{
            return '';
        }
    }
    return '';
}

function getSingerId($search_data){
    global $conn;
    $sql = "SELECT DISTINCT * FROM singers WHERE singer_name LIKE '%$search_data%'";
    $query = mysqli_query($conn, $sql);
    if($query){
        $rows = mysqli_num_rows($query);
        if($rows != 0){
            $string = '';
            while( $result = mysqli_fetch_assoc($query) ){
                $string .= ' OR singer = ' . $result['singer_id'];
            }
            return $string;
        }
        else{
            return '';
        }
    }
    return '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './includes/head-files.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Result | <?php echo SITE_TITLE; ?></title>
    <?php include './includes/files.php'; ?>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W4K9RLS"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
        include './includes/header.php'; 
        include './includes/search.php';
		include './includes/horizontal-ad.php'; ?>
        <div class="main_title_cont">
            <p class="main_title">Search Result for <?php echo urldecode($search_text);?></p>
        </div>

        <?php
        
        getSearchedData( urldecode($search_text) );

        include './includes/other-features.php';
		include './includes/horizontal-ad.php';
        include './includes/footer.php';
    ?>
</body>
</html>