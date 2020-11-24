<?php
    session_start();
    ob_start();
    include '../config.php';
    session_destroy();
    header('Location: ' . SITE_URL);
?>