

<?php

if(isset($_SESSION['userid'])){
$userid = $_SESSION['userid']; ?>
	<div class="admin_navigation">
		<div class="admin_nav_left">
			<a href="<?php echo SITE_URL . 'adminpanel/?page=upload';?>" class="admin_left_link_btn">Upload</a>
			<a href="<?php echo SITE_URL . 'adminpanel/?page=category';?>" class="admin_left_link_btn">Songs Category</a>
			<a href="<?php echo SITE_URL . 'adminpanel/?page=manage-uploads';?>" class="admin_left_link_btn">Manage Uploads</a>
			<a href="<?php echo SITE_URL . 'adminpanel/?page=singer';?>" class="admin_left_link_btn" title="Private Section">Manage Singers</a>

			<?php

			$sql = "SELECT * FROM accounts WHERE user_id = $userid";
			$query = mysqli_query($conn, $sql);
			if($query){
				$result = mysqli_fetch_assoc($query);
				if($result['is_admin'] == 1){ ?>
					<a href="<?php echo SITE_URL . 'adminpanel/?page=auto_upload';?>" class="admin_left_link_btn" title="Private Section">Auto Uploader</a>
					<?php
				}
			} ?>
			<a href="<?php echo SITE_URL . 'adminpanel/?page=account';?>" class="admin_left_link_btn">Account</a>
		</div>
		<div class="admin_nav_right">
			<a href="logout.php" class="admin-logout-btn">Logout</a>
		</div>
	</div>
	<?php
} ?>