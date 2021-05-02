<?php
include '../config.php';
include '../db.php';
include '../functions/functions.php';
include './functions/functions.php';
include './class/class-login-user-ip-blocker.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include '../includes/head-files.php'; ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="robots" content="noindex,nofollow" />

	<title>Admin Panel | <?php echo SITE_TITLE; ?></title>
	<link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/fonts-awesome/css/all.min.css" />
	<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/style.css" />
	<link rel="stylesheet" href="<?php echo SITE_URL;?>css/pages.css" />
	<link rel="icon" href="<?php echo SITE_URL; ?>images/fevicon.png" />
	<script type="text/javascript" src="<?php echo SITE_URL;?>js/jquery-3.4.1.min.js"></script>
	<link rel="stylesheet" href="./css/admin_style.css?id=<?php echo rand(0, 9);?>" />
</head>
<body>
	<?php
		include '../includes/header.php';
		include './includes/navigation.php';

		$blocking = new BlockUsers;

		if( $blocking -> init() ){
			if(!is_logged()){
				include './includes/login.php';
				// loginDisabled();
			}
			else{
				include_page();
				// loginDisabled();
			}
		}
		else{
			$blocking -> display_data();
		}
		

		include '../includes/horizontal-ad.php';
		include '../includes/footer.php';

	?>
</body>
</html>