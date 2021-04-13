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
    <meta name="subject" content="Ganaaworld Account Registration Page." />

    <meta name="description" content="Register a free account and ready to share your songs to the world. It is absolutely free and also you can upload unlimited songs." />

    <meta name="author" content="<?php echo SITE_TITLE;?>" />

    <meta name="keywords" content="<?php echo SITE_TITLE;?>, register account gaanaworld, gaanaworld register account, create account, gaanaworld, create account gaanaworld, gaanaworld create new account" />

    <meta name="revised" content="<?php echo date('l' . ',' . 'd F Y', time() - 86400);?>" />

    <meta name="revisit-after" content="1 days" />

    <meta name="og:title" content="<?php echo SITE_TITLE;?>" />

    <meta name="og:url" content="<?php echo SITE_URL;?>" />

    <meta name="og:image" content="<?php echo SITE_URL;?>images/fevicon.png" />

    <meta name="og:site_name" content="<?php echo SITE_TITLE;?>" />

    <meta name="og:description" content="Register a free account and ready to share your songs to the world. It is absolutely free and also you can upload unlimited songs." />

    <meta http-equiv="Pragma" content="cache" />
    <meta http-equiv="Cache-Control" content="cache" />
    <title>Create Account | <?php echo SITE_TITLE;?></title>
    <?php include '../includes/files.php'; ?>
</head>
<body>
<?php
    include '../includes/header.php'; 
    include '../includes/search.php'; ?>
    <div class="page_container">
        <div  class="page_window">
            <p class="page_title">Create Account</p>
            <div class="page_data">
                <p>We support remixers and we allow them to upload songs on our site. If you are a song <strong>producer</strong>, <strong>composer</strong> or <strong>remixer</strong> then you can join us to share your songs to the world.<p>
                <p>To get your own account please whatsapp on our number <?php echo ADMIN_WHATSAPP;?></p>
                <p>We will reply you as soon as possible.</p>
                <br />
                <p><strong>Whatsapp : <?php echo ADMIN_WHATSAPP;?></strong></p>
                <p>You can message us in <strong>Hindi, English, Punjabi</strong> and some more North Indian Languages</p>
            </div>
        </div>
    </div>
    <?php
    include '../includes/other-features.php';
    include '../includes/footer.php';
    ?>
</body>
</html>