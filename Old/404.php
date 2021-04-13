<?php include_once 'config.php';
include_once './db.php';

function err404(){ ?>
	<div id="notfound">
		<style type="text/css">
			#notfound {
			  position: relative;
			  height: 550px;
			  max-height: 100vh;
			}

			#notfound .notfound {
			  position: absolute;
			  left: 50%;
			  top: 50%;
			  -webkit-transform: translate(-50%, -50%);
			      -ms-transform: translate(-50%, -50%);
			          transform: translate(-50%, -50%);
			}

			.notfound {
			  max-width: 460px;
			  width: 100%;
			  text-align: center;
			  line-height: 1.4;
			}

			.notfound .notfound-404 {
			  position: relative;
			  width: 180px;
			  height: 180px;
			  margin: 0px auto 50px;
			}

			.notfound .notfound-404>div:first-child {
			  position: absolute;
			  left: 0;
			  right: 0;
			  top: 0;
			  bottom: 0;
			  background: #ffa200;
			  -webkit-transform: rotate(45deg);
			      -ms-transform: rotate(45deg);
			          transform: rotate(45deg);
			  border: 5px dashed #000;
			  border-radius: 5px;
			}

			.notfound .notfound-404>div:first-child:before {
			  content: '';
			  position: absolute;
			  left: -5px;
			  right: -5px;
			  bottom: -5px;
			  top: -5px;
			  -webkit-box-shadow: 0px 0px 0px 5px rgba(0, 0, 0, 0.1) inset;
			          box-shadow: 0px 0px 0px 5px rgba(0, 0, 0, 0.1) inset;
			  border-radius: 5px;
			}

			.notfound .notfound-404 h1 {
			  font-family: 'Cabin', sans-serif;
			  color: #000;
			  font-weight: 700;
			  margin: 0;
			  font-size: 90px;
			  position: absolute;
			  top: 50%;
			  -webkit-transform: translate(-50%, -50%);
			      -ms-transform: translate(-50%, -50%);
			          transform: translate(-50%, -50%);
			  left: 50%;
			  text-align: center;
			  height: 40px;
			  line-height: 40px;
			}

			.notfound h2 {
			  font-family: 'Cabin', sans-serif;
			  font-size: 33px;
			  font-weight: 700;
			  text-transform: uppercase;
			  letter-spacing: 7px;
			}

			.notfound p {
			  font-family: 'Cabin', sans-serif;
			  font-size: 16px;
			  color: #000;
			  font-weight: 400;
			}

			.notfound a {
			  font-family: 'Cabin', sans-serif;
			  display: inline-block;
			  padding: 10px 25px;
			  background-color: #8f8f8f;
			  border: none;
			  border-radius: 40px;
			  color: #fff;
			  font-size: 14px;
			  font-weight: 700;
			  text-transform: uppercase;
			  text-decoration: none;
			  -webkit-transition: 0.2s all;
			  transition: 0.2s all;
			}

			.notfound a:hover {
			  background-color: #2c2c2c;
			}
		</style>
		<div class="notfound">
			<div class="notfound-404">
				<div></div>
				<h1>404</h1>
			</div>
			<h2>Page not found</h2>
			<p>The page or file you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
			<a href="<?php echo SITE_URL; ?>">Home</a>
		</div>
	</div>
	<?php
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './includes/head-files.php'; ?>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="noindex,nofollow" />

    <meta name="og:image" content="<?php echo SITE_URL;?>images/fevicon.png" />

    <meta name="og:site_name" content="ERROR 404 | <?php echo SITE_TITLE;?>" />

    <title><?php echo '404 Error | ' . SITE_TITLE; ?></title>
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
        err404();
        include './includes/other-features.php';
        include './includes/footer.php';
    ?>
</body>
</html>