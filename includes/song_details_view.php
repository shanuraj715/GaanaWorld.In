<div class="song_area1">
	<div class="song_image_block">
		<img src="<?php echo $image;?>" class="song_image" alt="<?php echo SITE_TITLE . ' Song poster';?>" />
	</div>

	<div class="song_meta">
		<div class="song_title_block">
			<h1 class="song_title"><i class="fas fa-music song_title_icon"></i><?php echo $title; ?></h1>
		</div>

		<div class="song_meta_details_block">
			<span class="song_category">
				<i class="fas fa-angle-double-right song_meta_icon"></i>
				Category : 
				<a href="<?php echo SITE_URL . 'category/' . $this_song_category;?>" class="song_category_link"><?php echo $category;?></a>
			</span>


			<span class="song_singer">
				<i class="fas fa-angle-double-right song_meta_icon"></i>
				Singer : 
				<a href="<?php echo SITE_URL . 'singer/' . str_replace(' ', '-', $singer);?>" class="song_singer_link"><?php echo $singer;?></a>
			</span>


			<span class="song_upload_dt">
				<i class="fas fa-angle-double-right song_meta_icon"></i>
				Added : <span class="uploaded_on_dt"><?php echo $upload_date . ' ' . $upload_time;;?></span>
			</span>

			
			<?php
			if(strtolower( $album_name ) != 'unknown album'){ ?>
				<span class="song_upload_dt">
					<i class="fas fa-angle-double-right song_meta_icon"></i>
					Album : <a href="<?php echo SITE_URL . 'show-album/' . $album_id . '/' . str_replace(' ', '_', $album_name);?>" class="song_album_name"><?php echo $album_name;?></a>
				</span>
			<?php
			}
			else{ ?>
				<span class="song_upload_dt">
					<i class="fas fa-angle-double-right song_meta_icon"></i>
					Album : <span class="song_album_name"><?php echo $album_name;?></span>
				</span>
				<?php
			} ?>


			<span class="song_size">
				<i class="fas fa-angle-double-right song_meta_icon"></i>
				File Size : <span class="song_size_show"><?php echo $size;?></span>
			</span>


			<span class="song_length">
				<i class="fas fa-angle-double-right song_meta_icon"></i>
				Length : <span class="song_length_show"><?php echo $length;?></span>
			</span>


			<span class="song_total_download">
				<i class="fas fa-angle-double-right song_meta_icon"></i>
				Total Downloads : <span class="song_total_download_show"><?php echo $total_downloads;?> Times</span>
			</span>
		</div>
			

	</div>
	<?php
	if( !(isset($_COOKIE['ads']) && $_COOKIE['ads'] =='disabled') ){ ?>
		<div class="ad-song-p1" style="width:400px; height: 400px;">
			<?php include './includes/square-ad.php'; ?>
		</div>
	<?php } ?>
</div>