<?php
include './config.php';
include './db.php';
include './functions/functions.php';
include './functions/singer_page_functions.php';


$singer_name = THIS_PAGE;
$singer_name = explode('/', $singer_name);
$singer_name = end($singer_name);
$singer_name = explode('?', $singer_name);
$singer_name = $singer_name[0];

if(isset($_GET['page']) and is_numeric($_GET['page'])){
	$page = $_GET['page'];
}
else{
	$page = 1;
}

$singer = new Singer;
$singer -> page = $page;

$singer_id = singerNameToId( str_replace('-', ' ', $singer_name) );
$tags = getSingerTags( $singer_id );

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './includes/head-files.php'; ?>
	<meta charset="UTF-8">
	<title><?php echo ucfirst($singer_name) . ' Songs | ' . SITE_TITLE;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index,follow" />
	<!-- Meta -->
	<meta name="subject" content="<?php echo $tags;?>" />

	<meta name="description" content="Download all songs of <?php echo $singer_name;?> on your devide and enjoy. All songs are availabe in high quality." />

	<meta name="author" content="<?php echo SITE_TITLE;?>" />

	<meta name="keywords" content="<?php echo SITE_TITLE . ', ' . $tags;?>, gaanaworld.in, gaanaworld.com, gaana world website, gaanaworld site" />

	<meta name="revised" content="<?php echo date('l' . ',' . 'd F Y', time() - 86400);?>" />

	<meta name="revisit-after" content="1 days" />

	<meta name="og:title" content="<?php echo $singer_name . ' | ' . SITE_TITLE; ?>" />

	<meta name="og:url" content="<?php echo THIS_PAGE;?>" />

	<meta name="og:image" content="<?php echo SITE_URL;?>images/fevicon.png" />

	<meta name="og:site_name" content="<?php echo SITE_TITLE;?>" />

	<meta name="og:description" content="Download all songs of <?php echo $singer_name;?> on your devide and enjoy. All songs are availabe in high quality." />
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
		include './includes/horizontal-ad.php';
		$singer -> offset = (SONG_LIMIT * $page) - SONG_LIMIT;
		$singer -> singer_id = $singer_id;
		$singer -> singerSongs();
		include './includes/singer-pagination.php';
		include './includes/page_description.php';
		include './includes/horizontal-ad.php';
		include './includes/tags.php';
		include './includes/other-features.php';
		include './includes/footer.php';
	?>
</body>
</html>