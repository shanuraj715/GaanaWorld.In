<?php
include './config.php';
include './db.php';
include './functions/functions.php';


$this_page = 1;
$limit = ALBUM_SHOW_LIMIT;
$offset = 0;

$caterogy_list_arr = [424145, 424146, 424147]; // category list to show. only these categories can show in this page.
//Another cat id will not display in this page

if(isset($_GET['page']) and !empty($_GET['page']) and is_numeric($_GET['page'])){
    $this_page = $_GET['page'];
    $offset = ($limit * $this_page) - $limit;
}

$category = 424145; // default for bollywood;

$cat_id = explode('/', THIS_PAGE);
$cat_id = end($cat_id);
$cat_id = explode('?', $cat_id);
$cat_id = $cat_id[0];

if(!in_array($cat_id, $caterogy_list_arr)){
    include './404.php';
    exit();
}


global $conn;
$sql = "SELECT * FROM albums WHERE category_id = $cat_id ORDER BY album_name ASC LIMIT $limit OFFSET $offset";
$album_query = mysqli_query($conn, $sql);
if(!$album_query){
    include './404.php';
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './includes/head-files.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo catIdToName($cat_id);?> Albums | <?php echo SITE_TITLE; ?></title>


    <meta name="robots" content="index,follow" />
    <!-- Meta -->
    <meta name="subject" content="Songs by album in <?php echo SITE_TITLE;?>" />

    <meta name="description" content="Download your favourite song from albums. All albums list are available." />

    <meta name="author" content="<?php echo SITE_TITLE;?>" />

    <meta name="keywords" content="gaanaworld albums, gaanaworld.in, gaanaworld.com, gaana world website, gaanaworld site" />

    <meta name="revised" content="<?php echo date('l' . ',' . 'd F Y', time() - 86400);?>" />

    <meta name="revisit-after" content="1 days" />

    <meta name="og:title" content="Albums | <?php echo SITE_TITLE; ?>" />

    <meta name="og:url" content="<?php echo THIS_PAGE;?>" />

    <meta name="og:image" content="<?php echo SITE_URL;?>images/fevicon.png" />

    <meta name="og:site_name" content="<?php echo SITE_TITLE;?>" />

    <meta name="og:description" content="Download your favourite song from albums. All albums list are available." />

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
                <p class="main_title"><?php echo catIdToName($cat_id);?> Music Albums</p>
            </div>
            <?php
                while($result = mysqli_fetch_assoc($album_query)){
                    $album_id = $result['album_id'];
                    $album_name = $result['album_name'];
                    
                    /* getting total songs of an album */

                    $total_songs = totalSongsOfAlbum($album_id);
                    
                    
                    ?>
                    <div class="category_block">
                        <p class="category_line">
                            <i class="fas fa-angle-double-right category_icon"></i>
                            <a class="category_link" href="<?php echo SITE_URL . 'show-album/' . $album_id . '/' . str_replace(' ', '_', $album_name); ?>">
                                <?php echo $album_name . ' (' . $total_songs . ')';?>
                            </a>
                        </p>
                    </div>
                    <?php
                }
            ?>
        </div>



        <?php
        include './includes/album-pagination.php';
        include './includes/other-features.php';
        include './includes/footer.php';
    ?>
</body>
</html>