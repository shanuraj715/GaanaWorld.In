<?php
include './config.php';
include SITE_DIR . '/db.php';


if( isset($_COOKIE['ads'] )){

}

if( isset($_POST) && isset($_POST['ad_mgmt'])){
    if( $_POST['ad_mgmt'] == 'enable_ad' ){
        setcookie('ads', 'enabled');
    }
    else{
        setcookie('ads', 'disabled');
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
</head>
<body>
    <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
        <div class="as-row">
            <input id="enable_ad" type="radio" name="ad_mgmt" class="" value="enable_ad" />
            <label for="enable_ad" class="">Enable Ad</label>
        </div>
        <div class="as-row">
            <input id="disable_ad" type="radio" name="ad_mgmt" class="" value="disable_ad" />
            <label for="disable_ad" class="">Disable Ad</label>
        </div>

        <div class="">
            <input type="submit" value="Submit" class="" />
        </div>
    </form>
</body>
</html>