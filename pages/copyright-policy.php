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
            <h1 class="page_title">Copyright Policy</h1>
            <div class="page_data">
                <p style="text-align: left">All files and information contained in this Website are copyright by its creator. Our Website may contain our service marks or trademarks as well as those of our affiliates or other companies, in the form of words, graphics, and logos.</p>
                <p style="text-align: left">Your use of our Website or services does not constitute any right or license for you to use our service marks or trademarks, without the prior written permission of <?php echo SITE_TITLE;?>. </p>
                <hr />
                <p style="text-align: left">If you have any problem with any of our data, please tell us via <a href="<?php echo SITE_URL . 'contact-us';?>">Contact Us</a> page. We will take some action </p>
            </div>
        </div>
    </div>
    <?php
    include '../includes/other-features.php';
    include '../includes/footer.php';
    ?>
</body>
</html>