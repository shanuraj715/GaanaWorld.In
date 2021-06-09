<?php include 'config.php';
include './db.php';
include './functions/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './includes/head-files.php'; ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-W4K9RLS');</script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="index,follow" />
    <!-- Meta -->
    <meta name="subject" content="Download all latest mp3 songs. All Original, Dj and Remixed songs is available on our website. Download high quality mp3 songs. Bollywood, Punjabi, Bhojpuri, Haryanavi and many more language songs." />

    <meta name="description" content="Download all latest mp3 songs. All Original, Dj and Remixed songs is available on our website. Download high quality mp3 songs. Bollywood, Punjabi, Bhojpuri, Haryanavi and many more language songs." />

    <meta name="author" content="<?php echo SITE_TITLE;?>" />

    <meta name="keywords" content="<?php echo SITE_TITLE;?>, bhojpuri dj song, gaana world, gaana, gaanaworld, gaana world bhojpuri song, gaana world hindi song, gaana world mp3 song, bhojpuri song gaana world, latest songs, gaanaworld.in, gaanaworld.com, gaana world website, gaanaworld site" />

    <meta name="revised" content="<?php echo date('l' . ',' . 'd F Y', time() - 86400);?>" />

    <meta name="revisit-after" content="1 days" />

    <meta name="og:title" content="<?php echo SITE_TITLE;?>" />

    <meta name="og:url" content="<?php echo SITE_URL;?>" />

    <meta name="og:image" content="<?php echo SITE_URL;?>images/fevicon.png" />

    <meta name="og:site_name" content="<?php echo SITE_TITLE;?>" />

    <meta name="og:description" content="Download all latest mp3 songs. All Original, Dj and Remixed songs is available on our website. Download high quality mp3 songs. Bollywood, Punjabi, Bhojpuri, Haryanavi and many more language songs." />


    <title><?php echo SITE_TITLE; ?></title>
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
        if( !(isset($_COOKIE['ads']) && $_COOKIE['ads'] =='disabled') ){
			include './includes/horizontal-ad.php';
		}
        include './includes/new-added.php';
        
        if( !(isset($_COOKIE['ads']) && $_COOKIE['ads'] =='disabled') ){
			include './includes/horizontal-ad.php';
		}
        include './includes/categories.php';
        include './includes/other-features.php';
        if( !(isset($_COOKIE['ads']) && $_COOKIE['ads'] =='disabled') ){
			include './includes/horizontal-ad.php';
		}
        include './includes/footer.php';
    ?>
</body>
</html>