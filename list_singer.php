<?php
include './config.php';
include './db.php';
include './functions/functions.php';
include './functions/singer_page_functions.php';
$singer = new SingerPage;

$total_singers = $singer -> totalSingers();

if(isset($_GET['page']) and is_numeric($_GET['page'])){
	$page = $_GET['page'];
}
else{
	$page = 1;
}
$total_pages = ceil($total_singers / SINGER_SHOW_LIMIT);

$offset = (SINGER_SHOW_LIMIT * $page) - SINGER_SHOW_LIMIT;

$tags = 'Neha kakkar all songs, Arijit singh songs, Tony kakkar, Honey singh, Mika Singh, Badshah, songs download, all songs download, bollywood singers list';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './includes/head-files.php'; ?>
	<meta charset="UTF-8">
	<title>Songs by Singer Name | <?php echo SITE_TITLE;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="index,follow" />
	<!-- Meta -->
	<meta name="subject" content="All Singers list. Songs by singer name." />

	<meta name="description" content="List of all singers. Download neha kakkar, tony kakkar, arijit singh, palak mucchal songs on gaanaworld.in" />

	<meta name="author" content="<?php echo SITE_TITLE;?>" />

	<meta name="keywords" content="<?php echo SITE_TITLE . ', ' . $tags;?>, gaanaworld.in, gaanaworld.com, gaana world website, gaanaworld site" />

	<meta name="revised" content="<?php echo date('l' . ',' . 'd F Y', time() - 86400);?>" />

	<meta name="revisit-after" content="1 days" />

	<meta name="og:title" content="Songs by Singer Name | <?php echo SITE_TITLE;?>" />

	<meta name="og:url" content="<?php echo THIS_PAGE;?>" />

	<meta name="og:image" content="<?php echo SITE_URL;?>images/fevicon.png" />

	<meta name="og:site_name" content="<?php echo SITE_TITLE;?>" />

	<meta name="og:description" content="List of all singers. Download neha kakkar, tony kakkar, arijit singh, palak mucchal songs on gaanaworld.in" />

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
		$singer -> offset = $offset;
		$singer -> page_number = $page;
		$singer -> singerList();

		echo "<div style='display:none' class='hidden_pagination'>";
		$anchor_tag_count = 1;
		while($anchor_tag_count <= $total_pages){ ?>
			<a href="<?php echo SITE_URL . 'singer-list?page=' . $anchor_tag_count;?>" style="display: none; opacity: 0; visibility: hidden;">Page <?php echo $anchor_tag_count;?></a>
			<?php
			$anchor_tag_count++;
		}
		echo '</div>';
		include './includes/singer-list-pagination.php';
		include './includes/page_description.php';
		include './includes/other-features.php';
		include './includes/footer.php';
	?>
</body>
</html>