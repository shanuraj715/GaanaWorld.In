<?php
include './config.php';
include './db.php';
include './functions/functions.php';
include './class/ClassFavSong.php';

$isLogged = true;





if( !isset($_SESSION['fav_song_user_email']) || empty($_SESSION['fav_song_user_email'])){
    $isLogged = false;
}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Favourite Songs | <?php echo SITE_TITLE;?></title>

    <meta name="robots" content="noindex,nofollow" />
	<?php include './includes/files.php'; ?>
</head>
<body class="notextselect">
    <?php include './includes/header.php'; ?>

    <div class="fav-song-page-container">
        <div class="fav-song-player-cont">
            <p class="fs-song-title" id="fs-song-title"><?php echo SITE_TITLE; ?></p>
            <div class="fs-song-image-container">
                <div class="fs-song-image-block">
                    <img class="fs-song-img" src="<?php echo SITE_URL;?>images/song_images/12.png" id="fs-song-img" />
                </div>
            </div>

            <div class="fs-player-btn-cont">
                <button id="repeat-btn" class="fs-player-btn fs-player-repeat-btn"><i id="repeat-btn-icon" class="fas fa-repeat-alt"></i></button>
                <button id="fs-prev-song-btn" class="fs-player-btn fs-player-prev-btn"><i class="fas fa-angle-double-left"></i></button>
                <button id="play-pause-btn" class="fs-player-btn fs-player-play-pause-btn"><i id="play-pause-btn-icon" class="fas fa-play"></i></button>
                <button id="fs-next-song-btn" class="fs-player-btn fs-player-next-btn"><i class="fas fa-angle-double-right"></i></button>
                <button id="fs-mute-btn" class="fs-player-btn fs-player-volume-btn"><i id="fs-mute-btn-icon" class="fas fa-volume-up"></i></button>
            </div>
            <div class="fs-player-controller">
                
                <audio style="display: none;" id="fs-audio-player" src=""></audio>
                <div class="fs-player-slider-cont">
                    <div class="fs-player-timer-cont">
                        <span class="fs-player-time" id="fs-player-time">00:00</span>
                    </div>

                    <div class="fs-player-length-cont">
                        <span class="fs-player-length-text" id="fs-player-length-text">05:10</span>
                    </div>
                    <input type="range" class="fs-player-slider" min="0" max="100" value="0" id="fs-player-slider" />
                </div>

                
            </div>

            <div class="fs-player-btn-cont">
                <button id="fs-download-btn" class="fs-player-btn fs-player-download-btn"><i class="fas fa-download"></i></button>
                <button class="fs-player-btn fs-player-remove-btn"><i class="fas fa-trash-alt"></i></button>
                <button class="fs-player-btn fs-player-share-btn"><i class="fas fa-share-alt"></i></button>
                <button id="fs-open-external" class="fs-player-btn"><i class="fas fa-external-link-alt"></i></button>
            </div>
        </div>

        <div class="fav-song-list-cont">
            <div class="fs-next-song-cont">
                <p class="fs-container-title">Next Song Queue</p>
                <div id="fs-queue-container">
                    <!-- <div class="fs-song-row">
                        <span class="fs-row-song-title"><i class="fas fa-headphones fs-row-icon"></i>Next song name will appear here Next song name will appear here</span>
                        <div class="fs-song-row-btn-cont">
                            <button class="fs-row-btn"><i class="fas fa-times"></i></button>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="fs-fav-song-list-cont">
                <p class="fs-container-title">Favourite Songs</p>
                <div id="fs-fav-songs-container">
                    <!-- <div class="fs-song-row fs-fav-song-card-width">
                        <span class="fs-row-song-title"><i class="fas fa-star fs-row-icon"></i>Next song name will appear here Next song name will appear here</span>
                        <div class="fs-song-row-btn-cont">
                            <button class="fs-row-btn"><i class="far fa-trash-alt"></i></button>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>

    </div>
    <?php if( !$isLogged ){ ?> 
    <div class="fs-popup-container">
        <div class="fs-login-popup">
            <input type="email" id="fs-login-inp" class="fs-login-inp" placeholder="Enter your email address to continue" />
            <button class="fs-login-btn" id="fs-login-btn">Submit</button>
        </div>
    </div>
    <?php }
    else{ ?>
    <button id="fs-logout-btn" class="fs-logout-btn">LogOut</button>
    <span style="display: none;" id=""><?php echo $_SESSION['fav_song_user_email'];?></span>
    <?php
    } ?>

    <?php include './includes/footer.php'; ?>
    <script src="./js/favSong.js?id=<?php echo rand(1, 1250);?>"></script>
</body>
</html>