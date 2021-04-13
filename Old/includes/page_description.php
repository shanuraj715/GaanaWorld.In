<?php 

$this_page = $_SERVER['SCRIPT_NAME'];
$this_page = explode('/', $this_page);
$this_page = $this_page[1];

if($this_page == 'category.php'){
	$description = 'Download all songs of ' . $category_name . ' from ' . SITE_TITLE . '. All songs are available in high quality. ' . $category_name . ' all songs download. ' . $category_name . ' all songs download from ' . SITE_TITLE . '. All ' . $category_name . ' songs download from ' . SITE_TITLE . '. Download all mp3 songs in 128kbps, 192kbps and 320kbps - in HD High Quality Audio only on ' . SITE_TITLE . ', You can also play the songs online before download.';
}
elseif($this_page == 'song.php'){
	$description = $title . ', Download this song in HD quality only from ' . SITE_TITLE . ', You can also listen this song online before downloading. Song was uploaded by ' . userIdToName( $uploaded_by) . ' on ' . $upload_date . ' at ' . $upload_time;
}
elseif($this_page == 'singer-song.php'){
	$description = 'Download all songs of ' . $singer_name . ' from ' . SITE_TITLE . '. All songs are available in high quality. ' . $singer_name . ' all songs download. ' . $singer_name . ' all songs download from ' . SITE_TITLE . '. All ' . $singer_name . ' songs download from ' . SITE_TITLE . '. Download all mp3 songs in 128kbps, 192kbps and 320kbps - in HD High Quality Audio only on ' . SITE_TITLE . ', You can also play the songs online before download.';
}
elseif($this_page == 'list_singer.php'){
	$description = "Download songs of Neha kakkar, Alka Yagnik, Arijit Singh, Mika Singh, Honey Singh, Tulsi Kumar, Dino James in 128kbps, 192kbps and 320kbps. List of all Bollywood Singers, Bhojpuri Singers, Hollywood Singers, Punjabi Singers. Browse songs by Singer Name.";
}
else{
	$description = '';
}




?>

<div class="page_description_container">
	<div class="main_title_cont">
		<p class="main_title text_center">Page Description</p>
	</div>
	<div class="page_description_block">
		<p class="page_description"><?php echo $description;?></p>
	</div>
</div>