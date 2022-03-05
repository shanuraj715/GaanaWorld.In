<?php
include './id3/getid3.php';
include './id3/write.php';
global $conn;

$status = false;
if (isset($_POST['song_title'])) {

	if (isset($_FILES['image'])) {

		if (isset($_POST['category'])) {

			if (isset($_POST['singer'])) {

				if (isset($_POST['album'])) {

					if (isset($_FILES['file'])) {

						if (isset($_POST['tags'])) {

							$song_title = mysqli_real_escape_string($conn, $_POST['song_title']);
							$image = $_FILES['image'];
							$category = mysqli_real_escape_string($conn, $_POST['category']);

							if ($_SESSION['albums_available'] == 1) {
								$album = mysqli_real_escape_string($conn, $_POST['album']);
							} else {
								$album = 200002;
							}
							$singer = mysqli_real_escape_string($conn, $_POST['singer']);

							$file = $_FILES['file'];
							$tags = mysqli_real_escape_string($conn, $_POST['tags']);

							$uploaded_file = uploadMp3($file);
							$file_addr = UPLOADS_DIR . '/' . date('m_Y') . '/' . $uploaded_file;
							$length = songMeta($file_addr, 'length');
							writeTags($file_addr, albumIdToName($album), $song_title, SITE_DIR . 'images/song_cover.jpg');
							if ($image['name'] != '') {
								$upload_image = uploadImage($image);
								error_log("Image_loaded => " . $upload_image);
							} else {
								$upload_image = '';
								error_log('image_not_loaded => ' . $image['name']);
							}

							$array = array(
								'title' => $song_title,
								'image' => $upload_image,
								'file' => $uploaded_file,
								'category' => $category,
								'singer' => $singer,
								'tags' => $tags,
								'album' => $album,
								'length' => $length,
								'size' => $file['size']
							);

							$status = storeInDB($array);

							if ($status == true) {
								// header('Location: ' . SITE_URL . 'adminpanel/?page=upload');
							}
						} else {
						}
					}
				}
			}
		}
	}
}


function storeInDB($array)
{

	global $conn;

	$title = $array['title'];
	$category_id = $array['category'];
	$album_id = $array['album'];
	$image = $array['image'];
	$total_downloads = 0;
	$uploaded_by = $_SESSION['userid'];
	$upload_date = date('d-m-Y');
	$upload_timestamp = time();
	$singer = $array['singer'];

	$size = number_format((float)($array['size'] / 1024) / 1024, 2, '.', '') . " MB";


	$length = $array['length'];
	$tags = $array['tags'];
	$status = 1;
	$file_name = $array['file'];

	$sql = "INSERT INTO songs(title, category_id, album_id, `image`, total_downloads, uploaded_by, upload_date, upload_timestamp, singer, size, `length`, tags, `status`, `file_name`)";

	$sql .= " VALUES('$title', $category_id, $album_id, '$image', $total_downloads, $uploaded_by, '$upload_date', '$upload_timestamp', $singer, '$size', '$length', '$tags', $status, '$file_name')";

	$query = mysqli_query($conn, $sql);
	if ($query) {
		return true;
		// $error_message = "Successfully Saved to the database.";   
	} else {
		return false;
		// mysqli_error($conn);
		// $error_message = "Unable to save data in the database. Please Contat the site admin.";
	}
}

function writeTags($file, $album, $title, $artwork)
{

	/* modify file properties like album name etc... */
	// error_log($file);
	$TaggingFormat = 'UTF-8';
	$id3 = new getID3;
	$id3->setOption(array('encoding' => $TaggingFormat));
	$tagwriter = new getid3_writetags;
	$tagwriter->filename = $file;
	$tagwriter->tagformats = array('id3v2.4');
	$tagwriter->overwrite_tags    = true;
	$tagwriter->remove_other_tags = true;
	$tagwriter->tag_encoding      = $TaggingFormat;
	$image = file_get_contents($artwork);
	$TagData = array(
		'title' => array($title  . ' - (' . SITE_TITLE . ')'),
		'album' => array($album  . ' - (' . SITE_TITLE . ')'),
		'Comments' => array('This song is downloaded from ' . SITE_URL),
		'artist' => array(SITE_TITLE),
		'attached_picture' => array(
			array (
				'data'=> $image,
				'picturetypeid'=> 0x03,
				'mime'=> 'image/jpeg',
				'description' => SITE_TITLE
			)
		)
	);
	echo $file;
	$tagwriter->tag_data = $TagData;
	if ($tagwriter->WriteTags()) {
		return true;
	} else {
		error_log('Unable to write tag of file ' . $file);
	}

	unset($id3);
	unset($tagwriter);
}


function uploadMp3($file)
{
	global $error_message;
	$date_dir = date('m_Y');
	$target_dir = '../uploads/' . $date_dir . '/';

	createSongDir($target_dir);

	$file_extension = explode('.', $file['name']);
	$file_extension = end($file_extension);

	$new_file_name = explode('.', $file['name']);
	$new_file_name = $new_file_name[0];
	$new_file_name = str_replace('#', '', $new_file_name);

	$new_file_name .= time() . '-' . SITE_TITLE . '.' . $file_extension;


	if (checkSize($file['size'])) {
		if (checkExtension($file['name'])) {
			if (move_uploaded_file($file['tmp_name'], $target_dir . $new_file_name)) {
				return $new_file_name;
			} else {
				return false;
			}
		} else {
			echo "Wrong File Extension.";
		}
	} else {
		echo "File Size Limit Exceed";
	}
}

function createSongDir($dir)
{
	if (is_dir($dir)) {
	} else {
		mkdir($dir);
	}
}

function checkSize($size)
{
	if ($size > FILE_UPLOAD_SIZE) {
		return false;
	} else {
		return true;
	}
}

function checkExtension($name)
{
	$file_extension = explode('.', $name);
	$file_extension = end($file_extension);

	$array = ['mp3'];
	if (in_array($file_extension, $array)) {
		return true;
	} else {
		return false;
	}
}

function checkImageExtension($name)
{
	$file_extension = explode('.', $name);
	$file_extension = end($file_extension);

	$array = ['png', 'jpg', 'jpeg'];
	if (in_array($file_extension, $array)) {
		return true;
	} else {
		return false;
	}
}

function songMeta($filename, $what)
{
	$getId3 = new getID3;
	$file = $getId3->analyze($filename);

	if ($what == 'length') {
		$length = $file['playtime_seconds'];
		$min = floor($length / 60);
		$sec = floor($length - ($min * 60));
		$string = $min . ' Min ' . $sec . ' Sec';
		return $string;
	}
}

function uploadImage($file)
{
	global $error_message;
	$target_dir = '../uploads/' . date('m_Y') . '/images/';

	if (!is_dir($target_dir)) {
		mkdir($target_dir);
	}

	$file_extension = explode('.', $file['name']);
	$file_extension = end($file_extension);

	$new_file_name = explode('.', $file['name']);
	$new_file_name = $new_file_name[0];

	$new_file_name .= time() . '-' . rand(0, 99) . SITE_TITLE . '.' . $file_extension;

	if ($file['size'] <= IMAGE_UPLOAD_SIZE) {
		if (checkImageExtension($file['name'])) {
			if (move_uploaded_file($file['tmp_name'], $target_dir . $new_file_name)) {
				return $new_file_name;
			} else {
				return false;
			}
		} else {
			return '';
		}
	} else {
		return '';
	}
}

?>

<div class="upload-container">
	<?php if ($status) { ?>
		<p class="message_shower">
			<?php if ($status) {
				echo 'Successfully Uploaded';
			} else {
				echo 'Unable to upload to the server';
			} ?>
		</p>
	<?php
	} ?>
	<div class="upload_block">
		<p class="admin_page_titles">Upload Song</p>
		<form action="" method="post" enctype="multipart/form-data">
			<div class="input_block">
				<input id="file_title" type='text' name="song_title" class="song_title_box" required="required" placeholder="Enter Song Title" />
			</div>
			<div class="file_upload_block">
				<span class="selector_text">Select Image File</span>
				<input type="file" accept="image/png,image/jpg,image/jpeg" name="image">
			</div>
			<div class="option_block">
				<span class="selector_text">Select Category</span>
				<select class="category_selector" name="category">
					<?php
					$user_id = $_SESSION['userid'];
					$sql = "SELECT * FROM categories WHERE belong_to_user = $user_id";
					global $conn;
					$query = mysqli_query($conn, $sql);
					if ($query) {
						$rows = mysqli_num_rows($query);
						while ($result = mysqli_fetch_assoc($query)) { ?>
							<option class="category_option" value="<?php echo $result['category_id']; ?>"><?php echo $result['category_name']; ?></option>
					<?php
						}
					} ?>
				</select>
			</div>


			<div class="option_block">
				<span class="selector_text">Select Singer</span>
				<select class="category_selector" name="singer">
					<?php
					$user_id = $_SESSION['userid'];
					$sql = "SELECT * FROM singers ORDER By singer_name ASC";
					global $conn;
					$query = mysqli_query($conn, $sql);
					if ($query) {
						$rows = mysqli_num_rows($query);
						while ($result = mysqli_fetch_assoc($query)) {
							$default = '';
							if (strtolower($result['singer_name']) == "unknown singer") {
								$default = 'selected="selected"';
							} ?>
							<option class="category_option" value="<?php echo $result['singer_id']; ?>" <?php echo $default; ?>><?php echo $result['singer_name']; ?></option>
					<?php
						}
					} ?>
				</select>
			</div>

			<?php if ($_SESSION['albums_available'] == 1) { ?>
				<div class="option_block">
					<span class="selector_text">Select Album</span>
					<select class="category_selector" name="album">
						<?php
						$user_id = $_SESSION['userid'];
						$sql = "SELECT * FROM albums ORDER BY album_name ASC";
						global $conn;
						$query = mysqli_query($conn, $sql);
						if ($query) {
							$rows = mysqli_num_rows($query);
							while ($result = mysqli_fetch_assoc($query)) {
								$selected = '';
								if (strtolower($result['album_name']) == 'unknown album') {
									$selected = 'selected=selected"';
								} ?>
								<option class="category_option" value="<?php echo $result['album_id']; ?>" <?php echo $selected; ?>><?php echo $result['album_name']; ?></option>
						<?php
							}
						} ?>
					</select>
				</div>
			<?php
			} else { ?>
				<div class="option_block">
					<span class="selector_text">Select Album</span>
					<select class="category_selector" name="album">
						<option class="category_option" value="200002">Unknown Album</option>
					</select>
				</div>
			<?php
			} ?>

			<div class="file_upload_block">
				<span class="selector_text">Select Mp3 File</span>
				<input type="file" accept="audio/mp3" id="file_input" name="file" required="required">
			</div>
			<div class="input_block">
				<textarea name="tags" class="tags_input" placeholder="Enter Tags Here. [Example : Hindi song, Punjabi Song, Hindi Remix]"></textarea>
			</div>
			<?php
			if (!(isset($_COOKIE['ads']) && $_COOKIE['ads'] == 'disabled')) {
				include '../includes/horizontal-ad.php';
			}
			?>
			<div class="upload_now_btn_block">
				<input type="submit" class="upload_btn" value="Upload Now" />
			</div>
		</form>
	</div>
</div>
<script src="<?php echo SITE_URL . 'adminpanel/js/script.js'; ?>"></script>