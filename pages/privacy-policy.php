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
    <meta name="subject" content="Ganaaworld Privacy Policy Page." />

    <meta name="description" content="Read more about our users data privacy. We do not share personal information of our users to any third party company oe organization. Your personal data is secured." />

    <meta name="author" content="<?php echo SITE_TITLE;?>" />

    <meta name="keywords" content="<?php echo SITE_TITLE;?>, privacy policy gaanaworld, gaanaworld privacy policy, privacy policy, gaanaworld, privacy policy page gaanaworld, gaanaworld privacy policy page" />

    <meta name="revised" content="<?php echo date('l' . ',' . 'd F Y', time() - 86400);?>" />

    <meta name="revisit-after" content="1 days" />

    <meta name="og:title" content="<?php echo SITE_TITLE;?>" />

    <meta name="og:url" content="<?php echo SITE_URL;?>" />

    <meta name="og:image" content="<?php echo SITE_URL;?>images/fevicon.png" />

    <meta name="og:site_name" content="<?php echo SITE_TITLE;?>" />

    <meta name="og:description" content="Read more about our users data privacy. We do not share personal information of our users to any third party company oe organization. Your personal data is secured." />

    <meta http-equiv="Pragma" content="cache" />
    <meta http-equiv="Cache-Control" content="cache" />
    <title>Privacy Policy | <?php echo SITE_TITLE;?></title>
    <?php include '../includes/files.php'; ?>
</head>
<body>
<?php
    include '../includes/header.php'; 
    include '../includes/search.php'; ?>
    <div class="page_container">
        <div  class="page_window">
            <p class="page_title">Privacy Policy</p>
            <div class="page_data">
                <p>We will update our privacy policy soon.</p>
            </div>
        </div>
    </div>
    <?php
    include '../includes/other-features.php';
    include '../includes/footer.php';
    ?>
</body>
</html>