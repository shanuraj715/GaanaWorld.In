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
    <meta name="subject" content="Ganaaworld Copyright Policy Page." />

    <meta name="description" content="Read more about our copyright policy. We are here to help you on every copyright issue. If you have any concern about copyright, please contact us." />

    <meta name="author" content="<?php echo SITE_TITLE;?>" />

    <meta name="keywords" content="<?php echo SITE_TITLE;?>, copyright policy gaanaworld, gaanaworld copyright policy, copyright policy, gaanaworld, copyright policy gaanaworld page, gaanaworld copyright page" />

    <meta name="revised" content="<?php echo date('l' . ',' . 'd F Y', time() - 86400);?>" />

    <meta name="revisit-after" content="1 days" />

    <meta name="og:title" content="<?php echo SITE_TITLE;?>" />

    <meta name="og:url" content="<?php echo SITE_URL;?>" />

    <meta name="og:image" content="<?php echo SITE_URL;?>images/fevicon.png" />

    <meta name="og:site_name" content="<?php echo SITE_TITLE;?>" />

    <meta name="og:description" content="Read more about our copyright policy. We are here to help you on every copyright issue. If you have any concern about copyright, please contact us." />

    <meta http-equiv="Pragma" content="cache" />
    <meta http-equiv="Cache-Control" content="cache" />
    <title>Copyright Policy | <?php echo SITE_TITLE;?></title>
    <?php include '../includes/files.php'; ?>
</head>
<body>
<?php
    include '../includes/header.php'; 
    include '../includes/search.php'; ?>
    <div class="page_container">
        <div  class="page_window">
            <p class="page_title">Copyright Policy</p>
            <div class="page_data">
                <p>We will update our copyright policy soon. You can also visit our contact us page for assistance or clain a copyright issue.</p>
            </div>
        </div>
    </div>
    <?php
    include '../includes/other-features.php';
    include '../includes/footer.php';
    ?>
</body>
</html>