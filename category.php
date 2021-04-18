<?php include 'config.php';
include './db.php';
include './functions/functions.php';
$is_child_cat_exist = false;
$is_songs_exist = false;

$category_id = explode('/', THIS_PAGE);
$category_id = end($category_id);

$category_id_arr = explode('?', $category_id);
$category_id = $category_id_arr[0];
// echo $category_id;
$this_page_number = 1; // setting default value
if(count($category_id_arr) > 1){
	$this_page_number = $category_id_arr[1];
}
$tags = ''; // initializing tags for default. it will overwritten if category found some tags.
// echo $this_page_number;
if(is_numeric($category_id)){
	if($this_page_number == 1){
		$sql = "SELECT * FROM categories WHERE category_id = $category_id";
		$query = mysqli_query($conn, $sql);
		if($query){
			$rows = mysqli_num_rows($query);
			$result = mysqli_fetch_assoc($query);
			$tags = $result['tags'];
			if($rows == 1){
				$sql = "SELECT * FROM categories WHERE parent = $category_id";
				$query = mysqli_query($conn, $sql);
				if($query){
					$rows = mysqli_num_rows($query);
					if($rows >= 1){ // if child categories found
						$is_child_cat_exist = true;
					}
				}
			}
			else{
				include './404.php';
				exit();
			}
		}
	}
	else{
		$sql = "SELECT tags FROM categories WHERE category_id = $category_id";
		$query = mysqli_query($conn, $sql);
		if($query){
			$rows = mysqli_num_rows($query);
			$result = mysqli_fetch_assoc($query);
			$tags = $result['tags'];
		}
		
	}
	$sql = "SELECT * FROM songs WHERE category_id = $category_id";
	$query = mysqli_query($conn, $sql);
	if($query){
		$rows = mysqli_num_rows($query);
		if($rows >= 1){
			$is_songs_exist = true;
		}
	}
	$category_title = catIdToName($category_id);

}
else{
	die("Wrong Category Id");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include './includes/head-files.php'; ?>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo page_title($category_title, true); ?></title>


	<meta name="robots" content="index,follow" />
	<!-- Meta -->
	<meta name="subject" content="<?php echo $tags;?>" />

	<meta name="description" content="Download all songs of <?php echo $category_title;?> on your devide and enjoy. All songs are availabe in high quality." />

	<meta name="author" content="<?php echo SITE_TITLE;?>" />

	<meta name="keywords" content="<?php echo SITE_TITLE . ', ' . $tags;?>, gaanaworld.in, gaanaworld.com, gaana world website, gaanaworld site" />

	<meta name="revised" content="<?php echo date('l' . ',' . 'd F Y', time() - 86400);?>" />

	<meta name="revisit-after" content="1 days" />

	<meta name="og:title" content="<?php echo page_title($category_title, true); ?>" />

	<meta name="og:url" content="<?php echo THIS_PAGE;?>" />

	<meta name="og:image" content="<?php echo SITE_URL;?>images/fevicon.png" />

	<meta name="og:site_name" content="<?php echo SITE_TITLE;?>" />

	<meta name="og:description" content="Download all songs of <?php echo $category_title;?> on your devide and enjoy. All songs are availabe in high quality." />
	
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
		include './includes/breadcrumb.php';
		$is_child_cat_exist ? include './includes/categories.php' : null;
		$is_songs_exist ? include './includes/song-list.php' : null;
		$is_songs_exist ? include './includes/pagination.php' : null;
		include './includes/page_description.php';
		include './includes/tags.php';
		include './includes/other-features.php';
		include './includes/footer.php';
	?>
</body>
</html>