<?php
include './config.php';
include './db.php';
include './functions/functions.php';

$url_values = explode('/', THIS_PAGE);
$index = array_search('song', $url_values);

if(!is_numeric($index)){
	include './404.php';
	exit();
}
else{
	$song_id = $url_values[$index + 1];
}

$sql = "SELECT * FROM `songs` WHERE `song_id` = $song_id AND `status` = 1";
$query = mysqli_query($conn, $sql);
$rows = mysqli_num_rows( $query );
if($query && $rows == 1){
	$result = mysqli_fetch_assoc($query);

	$song_id = $result['song_id'];

	$this_song_category = $result['category_id'];
	$title = $result['title'];
	$category = catIdToName( $result['category_id']);
	$image = songImage($result['image'], date('m_Y', $result['upload_timestamp']), $result['category_id']);
	$total_downloads = $result['total_downloads'];
	$uploaded_by = $result['uploaded_by'];
	$upload_date = date('d-M-Y', $result['upload_timestamp']);
	$singer_id = $result['singer'];
	$upload_timestamp = $result['upload_timestamp'];
	$song_dir = date('m_Y', $result['upload_timestamp']);
	$upload_time = date('h:i A',$result['upload_timestamp']);
	$singer = singerIdToName( $result['singer'] );
	$size = $result['size'];
	$album_id = $result['album_id'];
	$album_name = albumIdToName( $album_id );
	$length = $result['length'];
	$tags = $result['tags'];
	$file_name = $result['file_name'];
}
else{
	include './404.php';
	exit();
}
incrementTotalDownloads( $song_id, $total_downloads );
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include './includes/head-files.php'; ?>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo page_title(ucwords($title), true);?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>css/particles.css">
	<?php include './includes/files.php'; ?>

	<meta name="robots" content="index,follow" />
	<!-- Meta -->
	<meta name="subject" content="<?php echo $tags;?>" />

	<meta name="description" content="<?php echo 'Download ' . ucfirst($title) . ' mp3 song on your device and enjoy it.';?>" />

	<meta name="author" content="<?php echo SITE_TITLE;?>" />

	<meta name="keywords" content="<?php echo SITE_TITLE . ', ' . $tags;?>, gaanaworld.in, gaanaworld.com, gaana world website, gaanaworld site" />

	<meta name="revised" content="<?php echo date('l' . ',' . 'd F Y', time() - 86400);?>" />

	<meta name="revisit-after" content="1 days" />

	<meta name="og:title" content="<?php echo page_title(ucwords($title), true); ?>" />

	<meta name="og:url" content="<?php echo THIS_PAGE;?>" />

	<meta name="og:image" content="<?php echo $image;?>" />

	<meta name="og:site_name" content="<?php echo SITE_TITLE;?>" />

	<meta name="og:description" content="<?php echo 'Download ' . ucfirst($title) . ' mp3 song on your device and enjoy it.';?>" />

	<meta http-equiv="Pragma" content="cache" />
	<meta http-equiv="Cache-Control" content="cache" />

	<style type="text/css">
	#particles-js{
		width: 100%;
		height: 100%;
		background-color: transparent;
		background-image: url('');
		background-size: cover;
		background-position: 50% 50%;
		background-repeat: no-repeat;
	}
	</style>
</head>
<body>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W4K9RLS"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	
<?php
		include './includes/song-page-particles.php';
		include './includes/header.php'; 
		include './includes/search.php';
		include './includes/breadcrumb.php';
		?>


		<div class="song">
			<?php 
			include_once './includes/song_details_view.php';
			include_once './includes/player.php';
			?>
		</div>

		<script type="text/javascript" src="<?php echo SITE_URL; ?>js/player.js?id=<?php echo rand(0,9);?>"></script>


	<?php
		include './includes/share.php';
		include './includes/page_description.php';
		include './includes/tags.php';
		if( !(isset($_COOKIE['ads']) && $_COOKIE['ads'] =='disabled') ){
			include './includes/horizontal-ad.php';
		}
		include './includes/related-files.php';
		if( !(isset($_COOKIE['ads']) && $_COOKIE['ads'] =='disabled') ){
			include './includes/horizontal-ad.php';
		}
		include './includes/other-features.php';
		if( !(isset($_COOKIE['ads']) && $_COOKIE['ads'] =='disabled') ){
			if( isMobile() ){
				include './includes/square-ad.php';
			}
		}
		include './includes/footer.php';
	?>
</body>
</html>