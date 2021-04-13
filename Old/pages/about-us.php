<?php include '../config.php';
include '../db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="index,follow" />
    <!-- Meta -->
    <meta name="subject" content="Ganaaworld About Page." />

    <meta name="description" content="Know more about Gaanaworld.in. We have a large database of high quality mp3 songs. We also support you work in music industry. Everyone who is a music producer or remixer, can register a free account and they can uoload their songs free." />

    <meta name="author" content="<?php echo SITE_TITLE;?>" />

    <meta name="keywords" content="<?php echo SITE_TITLE;?>, about us gaanaworld, gaanaworld about us, about, about us, gaanaworld, about us page gaanaworld" />

    <meta name="revised" content="<?php echo date('l' . ',' . 'd F Y', time() - 86400);?>" />

    <meta name="revisit-after" content="1 days" />

    <meta name="og:title" content="<?php echo SITE_TITLE;?>" />

    <meta name="og:url" content="<?php echo SITE_URL;?>" />

    <meta name="og:image" content="<?php echo SITE_URL;?>images/fevicon.png" />

    <meta name="og:site_name" content="<?php echo SITE_TITLE;?>" />

    <meta name="og:description" content="Know more about Gaanaworld.in. We have a large database of high quality mp3 songs. We also support you work in music industry. Everyone who is a music producer or remixer, can register a free account and they can uoload their songs free." />

    <meta http-equiv="Pragma" content="cache" />
    <meta http-equiv="Cache-Control" content="cache" />
    <title>About Us | <?php echo SITE_TITLE;?></title>
    <?php include '../includes/files.php'; ?>
</head>
<body>
<?php
    include '../includes/header.php'; 
    include '../includes/search.php'; ?>
    <div class="page_container">
        <div  class="page_window">
            <p class="page_title">About Us</p>
            <div class="page_data">
                <p>This site is in under development. We will come back after some time with some great updates</p>
                <p>Thanks for visiting our site</p>
            </div>
        </div>
    </div>
    <?php
    include '../includes/other-features.php';
    include '../includes/footer.php';
    ?>
</body>
</html>