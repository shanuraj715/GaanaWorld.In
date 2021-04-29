<?php
session_start();
header("Content-Type: application/json");
$json = ['status' => true ];
session_destroy();

echo json_encode( $json );
?>