<?php


function song_list(){
	global $conn;
	$category_id = category_id();
	$page_number = 1;

	if(isset($_GET['page']) and !empty($_GET['page'])){
		if(is_numeric($_GET['page'])){
			$page_number = $_GET['page'];
		}
		else{
			echo "Invalid URL";
		}
	}

	$offset = ($page_number * SONG_LIMIT) - SONG_LIMIT;
	// echo $offset;

	$limit = SONG_LIMIT;
	$db_string = "SELECT * FROM songs WHERE status = 1 AND category_id = $category_id ORDER BY upload_timestamp DESC LIMIT $limit OFFSET $offset";
	$query = mysqli_query($conn, $db_string);
	if($query){
		while($result = mysqli_fetch_assoc($query)){
			$title = $result['title'];
			$category_name = catIdToName(  $result['category_id'] );
			$singer_name = singerIdToName ( $result['singer'] );
			$size = $result['size'];
			$song_link = SITE_URL . 'song/' . $result['song_id'] . '/' . urlSongTitle($result['title']);
			?>
			<div class="new_upload_block">
				<div class="new_upload_image_block">
					<i class="fas fa-music new_upload_song_music_icon"></i>
				</div>

				<div class="new_upload_song_meta">
				<p class="new_upload_song_title"><a class="new_upload_link" href="<?php echo $song_link;?>"><?php echo $result['title'];?></a></p>
					<span class="new_uploads_category"><?php echo $category_name; ?></span>
					<span class="new_uploads_singer"><?php echo $singer_name; ?></span>
					<span class="new_uploads_size"><?php echo $result['size']; ?></span>
				</div>
			</div>
		<?php
		}
	}
}

function category_id(){
	$category_id = explode('/', THIS_PAGE);
	$category_id = end($category_id);

	$category_id = explode('?', $category_id);
	$category_id = $category_id[0];
	// echo $category_id;
	
	if(is_numeric($category_id)){
		return $category_id;
	}
	else{
		die("Wrong Category Id");
	}
}
?>



<div class="new_uploads_container">
	<div class="main_title_cont">
		<h1 class="main_title"><?php echo $category_name;?> all songs list</h1>
	</div>
	<?php song_list(); ?>
</div>