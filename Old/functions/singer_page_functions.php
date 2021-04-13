<?php

/**
 * 
 */
class SingerPage
{

	public $offset;
	public $page_number;
	
	function __construct()
	{
		$this -> offset = 0;
		$this -> page_number = 1;
	}

	public function totalSingers(){
		global $conn;
		$sql = "SELECT count(singer_id) as totalsingers from singers";
		$query = mysqli_query($conn, $sql);
		$result = mysqli_fetch_assoc($query);
		return $result['totalsingers'];
	}

	public function singerList(){
		$singer_data = $this -> getSingerListFromDB(); ?>
		<div class="main_title_cont">
	        <p class="main_title">List of Singers - Page <?php echo $this -> page_number;?></p>
	    </div>
		<?php
		if($singer_data != false){
			while($result = mysqli_fetch_assoc($singer_data)){ ?>
				<div class="category_block">
					<p class="category_line">
						<i class="fas fa-angle-double-right category_icon"></i>
						<a class="category_link" href="<?php echo SITE_URL . 'singer/' . str_replace(' ', '-', $result['singer_name']);?>"><?php echo $result['singer_name'];?></a>
					</p>
				</div>
				<?php
			}
		}
		else{
			header("Location: " . SITE_URL);
		}
	}

	private function getSingerListFromDB(){
		global $conn;
		$limit = SINGER_SHOW_LIMIT;
		$offset = $this -> offset;
		$sql = "SELECT * FROM singers ORDER BY singer_name ASC LIMIT $limit OFFSET $offset";
		$query = mysqli_query($conn, $sql);
		if($query){
			$rows = mysqli_num_rows($query);
			if($rows != 0){
				return $query;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
}

/**
 * 
 */
class Singer
{
	public $page;
	public $limit;
	public $offset;
	public $singer_id;
	public $singer_name;
	
	function __construct()
	{
		$this -> limit = SONG_LIMIT;
	}

	public function singerSongs(){
		$singer_data = $this -> singerSongList();
		$this -> singer_name = singerIdToName($this -> singer_id);
		if($singer_data != false){ ?>
			<div class="main_title_cont">
				<h1 class="main_title"><?php echo $this -> singer_name;?> All Songs</h1>
			</div>
			<?php
			while($result = mysqli_fetch_assoc($singer_data)){
			$song_link = SITE_URL . 'song/' . $result['song_id'] . '/' . urlSongTitle($result['title']);
			$category_name = catIdToName(  $result['category_id'] );
			$singer_name = singerIdToName ( $result['singer'] );

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
		else{
			echo "<p style='text-align: center;'>No Songs Available</p>";
		}
	}

	private function singerSongList(){
		global $conn;
		$singer_id = $this -> singer_id;
		$limit = $this -> limit;
		$offset = $this -> offset;
		$sql = "SELECT * FROM songs WHERE singer = $singer_id ORDER BY song_id DESC LIMIT $limit OFFSET $offset";
		$query = mysqli_query($conn, $sql);
		if($query){
			$rows = mysqli_num_rows($query);
			if($rows == 0){
				return false;
			}
			else{
				return $query;
			}
		}
		else{
			header('Location: ' . SITE_URL);
		}
	}
}

?>