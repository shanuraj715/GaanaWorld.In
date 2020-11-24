<?php
include './config.php';
include './db.php';
include './functions/functions.php';

$album_id = explode('/', THIS_PAGE);
$total_indexes = count($album_id);
if(is_numeric($album_id[$total_indexes - 1])){
    $album_id = end($album_id);
}
elseif(is_numeric($album_id[$total_indexes - 2])){
    $album_id = $album_id[$total_indexes - 2];
}
else{
    include './404.php';
    exit();
}

$album_name = albumIdToName($album_id);


global $conn;
$sql = "SELECT * FROM songs WHERE album_id = $album_id ORDER BY title ASC LIMIT 100";
$album_query = mysqli_query($conn, $sql);
if(!$album_query){
    include './404.php';
    exit();
}
$tags = '';
$tags_array = [' songs', ' gaanaworld', ' all songs', ' song list', ' songs download', ' mp3 song download'];
$comma_inserter = false;
foreach($tags_array as $value){
    if($comma_inserter){
        $tags .= ',';
    }
    $new_tag = $album_name . $value;
    $tags .= $new_tag;
    $comma_inserter = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './includes/head-files.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All songs of <?php echo $album_name;?> | <?php echo SITE_TITLE; ?></title>


    <meta name="robots" content="index,follow" />
    <!-- Meta -->
    <meta name="subject" content="Songs by album <?php echo $album_name;?>" />

    <meta name="description" content="Download your favourite song from album <?php echo $album_name;?>. All aongs are available in high quality." />

    <meta name="author" content="<?php echo SITE_TITLE;?>" />

    <meta name="keywords" content="<?php echo $tags;?>" />

    <meta name="revisit-after" content="1 days" />

    <meta name="og:title" content="All songs of <?php echo $album_name . ' | ' . SITE_TITLE; ?>" />

    <meta name="og:url" content="<?php echo THIS_PAGE;?>" />

    <meta name="og:image" content="<?php echo SITE_URL;?>images/fevicon.png" />

    <meta name="og:site_name" content="<?php echo SITE_TITLE;?>" />

    <meta name="og:description" content="Download your favourite song from album <?php echo $album_name;?>. All aongs are available in high quality." />

    <meta http-equiv="Pragma" content="cache" />
    <meta http-equiv="Cache-Control" content="cache" />
    
    <?php include './includes/files.php'; ?>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W4K9RLS"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
        include './includes/header.php';
        include './includes/search.php'; ?>

        <div class="categories_container">
            <div class="main_title_cont">
                <p class="main_title">Songs of Album <?php echo $album_name;?></p>
            </div>
            <?php
                while($result = mysqli_fetch_assoc($album_query)){
                    $song_link = SITE_URL . 'song/' . $result['song_id'] . '/' . str_replace(' ', '_', $result['title']);
                    $title = $result['title'];
                    $category_name = catIdToName($result['category_id']);
                    $singer_name = singerIdToName($result['singer']);
                    $size = $result['size'];
                    ?>
                    <div class="new_upload_block">
                        <div class="new_upload_image_block">
                            <i class="fas fa-music new_upload_song_music_icon"></i>
                        </div>

                        <div class="new_upload_song_meta">
                            <p class="new_upload_song_title"><a class="new_upload_link" href="<?php echo $song_link;?>"><?php echo $title;?></a></p>
                            <span class="new_uploads_category"><?php echo $category_name; ?></span>
                            <span class="new_uploads_singer"><?php echo $singer_name; ?></span>
                            <span class="new_uploads_size">Size: <?php echo $size; ?></span>
                        </div>
                    </div>
                    <?php
                }
            ?>
        </div>



        <?php
        include './includes/tags.php';
        include './includes/other-features.php';
        include './includes/footer.php';
    ?>
</body>
</html>